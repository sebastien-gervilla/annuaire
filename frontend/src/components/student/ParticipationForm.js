import React, { useState } from 'react';
import { IoClose } from 'react-icons/io5';
import useArray from '../../hooks/useArray';
import useFetch from '../../hooks/useFetch';
import apiRequest from '../../utils/api-request';
import ErrorMessage from '../ErrorMessage';
import TransferSelect from '../TransferSelect';

const ParticipationForm = ({ studentId, method, closeModal, onSubmit }) => {

    const eventsReq = useFetch("event/events");
    const participationsReq = useFetch("participation/participations/?studentId=" + studentId);

    const selectedEvents = useArray([]);
    const [error, setError] = useState(null);
    const [warning, setWarning] = useState(null);

    const getAvailableEvents = () => eventsReq.data?.body && participationsReq.data?.body &&
        eventsReq.data?.body.filter(event => !participationsReq.data?.body.find(
            participation => participation.event_id === event._id
        ));
    
    const onChangeSelectValues = (name, values) => selectedEvents.set(values.map(value => value._id));
        
    const handleCloseModal = event => closeModal();

    const handleSubmitForm = async event => {
        event.preventDefault();
        const res = await apiRequest('participation/participations', method, {
            studentId,
            participations: selectedEvents.array
        });

        if (!res) return setError("Une erreur est survenue...");
        if (res.status !== 200 || res.body?.warning) {
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
    
    return (
        <form className='student-form app-form'>
            <div className="form-header">
                <h2>Ajouter des participations</h2>
                <button onClick={handleCloseModal}><IoClose/></button>
            </div>
            <div className="form-input">
                <TransferSelect data={getAvailableEvents()} onChangeValues={onChangeSelectValues} />
            </div>
            {displayError()}
            <div className="form-input">
                <input onClick={handleSubmitForm} name="submit" type="submit" value="Valider"/>
            </div>
        </form>
    );
};

export default ParticipationForm;