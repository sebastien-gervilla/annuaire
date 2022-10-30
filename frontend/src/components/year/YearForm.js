import React, { useState } from 'react';
import { IoClose } from 'react-icons/io5';
import { defaultYear } from '../../utils/model-defaults';
import apiRequest from '../../utils/api-request';
import ErrorMessage from '../ErrorMessage';

const YearForm = ({ yearInfos, method, closeModal, onSubmit }) => {

    const [year, setYear] = useState(yearInfos || defaultYear);
    const [error, setError] = useState(null);
    const [warning, setWarning] = useState(null);
    
    const handleChanges = event => 
        setYear({...year, [event.target.name]: event.target.value});

    const handleCloseModal = event => closeModal();

    const handleSubmitForm = async event => {
        event.preventDefault();
        const res = await apiRequest('schoolyear/schoolyear', method, year);
        console.log(res);
        if (!res) return setError("Une erreur est survenue...");
        if (res.status !== 200) {
            res.body?.warning && setWarning(res.body.warning);
            return setError(res.message)
        };
        onSubmit();
        closeModal();
    }

    const displayError = () =>
        (!error) ?
            warning && <ErrorMessage type='warning' message={warning} />
        : <ErrorMessage type={'error'} message={error} />

    const displayTitle = () => method === 'POST' ?
        'Nouvelle année de formation' : (method === 'PUT') ?
        'Modifier une année de formation' : '';

    return (
        <form className='year-form app-form'>
            <div className="form-header">
                <h2>{displayTitle()}</h2>
                <button onClick={handleCloseModal}><IoClose/></button>
            </div>
            <div className="form-input">
                <p>TITRE *</p>
                <input type="text" name='title' value={year.title} onChange={handleChanges} />
            </div>
            {displayError()}
            <div className="form-input">
                <input onClick={handleSubmitForm} name="submit" type="submit" value="Valider"/>
            </div>
        </form>
    );
};

export default YearForm;