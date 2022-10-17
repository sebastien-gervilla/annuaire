import React from 'react';
import useFetch from '../hooks/useFetch';

const EventSelect = ({ handleChanges }) => {

    const eventsReq = useFetch('event/events');

    const displayOptions = () => eventsReq.data?.body &&
        eventsReq.data.body.map(event =>
            <option key={event._id} value={event._id}>{event.title}</option>
        )

    return (
        <select onChange={handleChanges} name="participations" multiple>
            {displayOptions()}
        </select>
    );
};

export default EventSelect;