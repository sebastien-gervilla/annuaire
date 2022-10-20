import React, { useState } from 'react';
import { IoClose } from 'react-icons/io5';
import { defaultEvent } from '../../utils/model-defaults';
import apiRequest from '../../utils/api-request';
import ErrorMessage from '../ErrorMessage';

const EventForm = ({ eventInfos, method, closeModal, onSubmit }) => {

    const [event, setEvent] = useState(eventInfos || defaultEvent);
    const [error, setError] = useState(null);
    const [warning, setWarning] = useState(null);
    
    const handleChanges = cEvent => 
        setEvent({...event, [cEvent.target.name]: cEvent.target.value});

    const handleCloseModal = cEvent => closeModal();

    const handleSubmitForm = async cEvent => {
        cEvent.preventDefault();
        const res = await apiRequest('event/event', method, event);
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
        'Nouvel élève' : (method === 'PUT') ?
        'Modifier un élève' : '';

    return (
        <form className='event-form app-form'>
            <div className="form-header">
                <h2>{displayTitle()}</h2>
                <button onClick={handleCloseModal}><IoClose/></button>
            </div>
            <div className="form-input">
                <p>TITRE *</p>
                <input type="text" name='title' value={event.title} onChange={handleChanges} />
            </div>
            <div className="form-input">
                <p>TYPE *</p>
                <select className='form-select' name="type" value={event.type} onChange={handleChanges}>
                    <option value="JPO">JPO</option>
                    <option value="Entretien">Entretien</option>
                    <option value="Visite">Visite</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            <div className="form-input">
                <p>DATE D'EVENEMENT</p>
                <input type="text" name='date' value={event.date} onChange={handleChanges} />
            </div>
            <div className="form-input">
                <p>DESCRIPTION</p>
                <input type="text" name='description' value={event.description} onChange={handleChanges} />
            </div>
            {displayError()}
            <div className="form-input">
                <input onClick={handleSubmitForm} name="submit" type="submit" value="Valider"/>
            </div>
        </form>
    );
};

export default EventForm;