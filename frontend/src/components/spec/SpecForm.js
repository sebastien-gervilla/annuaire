import React, { useState } from 'react';
import { IoClose } from 'react-icons/io5';
import { defaultSpec } from '../../utils/model-defaults';
import apiRequest from '../../utils/api-request';
import ErrorMessage from '../ErrorMessage';
import ColorWheel from '../ColorWheel';

const SpecForm = ({ specInfos, method, closeModal, onSubmit }) => {

    const [spec, setSpec] = useState(specInfos || defaultSpec);
    const [error, setError] = useState(null);
    const [warning, setWarning] = useState(null);

    const [openWheel, setOpenWheel] = useState(false);
    const [wheelColor, setWheelColor] = useState('#fff');

    const handleToggleWheel = event => setOpenWheel(prev => !prev);
    
    const handleChanges = event => 
        setSpec({...spec, [event.target.name]: event.target.value});

    const handleCloseModal = event => closeModal();

    const handleSubmitForm = async event => {
        event.preventDefault();
        const res = await apiRequest('specialization/specialization', method, spec);
        if (!res) return setError("Une erreur est survenue...");
        if (res.status !== 200) {
            res.body?.warning && setWarning(res.body.warning);
            return setError(res.message)
        };
        onSubmit();
        closeModal();
    }

    const displayColorWheel = () => openWheel &&
        <ColorWheel onChange={newColor => setSpec({...spec, color: newColor})} />

    const displayError = () =>
        (!error) ?
            warning && <ErrorMessage type='warning' message={warning} />
        : <ErrorMessage type={'error'} message={error} />

    const displayTitle = () => method === 'POST' ?
        'Nouvelle specialisation' : (method === 'PUT') ?
        'Modifier une specialisation' : '';

    return (
        <form className='spec-form app-form'>
            {displayColorWheel()}
            <div className="form-header">
                <h2>{displayTitle()}</h2>
                <button onClick={handleCloseModal}><IoClose/></button>
            </div>
            <div className="form-input_row">
                <div className="form-input">
                    <p>TITRE *</p>
                    <input type="text" name='title' value={spec.title} onChange={handleChanges} />
                </div>
                <div className="form-input">
                    <p>ABREVIATION *</p>
                    <input type="text" name='abbreviation' value={spec.abbreviation} onChange={handleChanges} />
                </div>
            </div>
            <div className="form-input_row">
                <div className="form-input">
                    <p>COULEUR DE CONTRASTE</p>
                    <select name="contrast" className='form-select' value={spec.contrast} onChange={handleChanges} >
                        <option value="Noir">Noir</option>
                        <option value="Blanc">Blanc</option>
                    </select>
                </div>
                <div className="form-input">
                    <p>COULEUR</p>
                    <button className='input-button' onClick={handleToggleWheel} 
                    type="button" value={spec.color}>{spec.color}</button>
                </div>
            </div>
            {displayError()}
            <div className="form-input">
                <input onClick={handleSubmitForm} name="submit" type="submit" value="Valider"/>
            </div>
        </form>
    );
};

export default SpecForm;