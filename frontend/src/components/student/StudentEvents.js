import React, { useEffect, useState } from 'react';
import { VscChevronLeft, VscChevronRight } from 'react-icons/vsc';
import { Modal } from 'skz-ui';
import useFetch from '../../hooks/useFetch';
import usePagination from '../../hooks/usePagination';
import { defaultEvent } from '../../utils/model-defaults';
import { calcMaxPage } from '../../utils/useful-functions';
import EventForm from '../event/EventForm';
import StudentEvent from './StudentEvent';

const StudentEvents = ({ studentId, participations, removeParticipation }) => {

    const eventsReq = useFetch('event/events');
    const [events, setEvents] = useState([]);

    const pageHandler = usePagination();

    useEffect(() => {
        const body = eventsReq.data?.body;
        if (!body) return;
        setEvents(getEvents());
        pageHandler.updateMax(body.length);
    }, [eventsReq.data, participations]);

    useEffect(() => {
        const body = eventsReq.data?.body;
        if (!body) return;
        pageHandler.refreshPage(body.length);
    }, [pageHandler.maxPage]);

    const getEvents = () => participations && eventsReq.data?.body && 
        participations.map(participation => {
            const event = eventsReq.data.body.find(event => event._id === participation._id);
            return {...event, date: participation.date};
        });

    const displayEvents = () => {
        if (!events) return;

        const start = 6 * pageHandler.page;
        const end = (start + 6) > events.length ? 
            events.length : (start + 6);

        const displayedEvents = events.slice(start, end);

        return displayedEvents.map(event =>
            <StudentEvent key={event._id} 
                eventInfos={event}
                removeParticipation={(() => removeParticipation(event._id, studentId))}
            />
        )
    }

    return (
        <div className="events half-component">
            <div className="header">
                <h2>Evènements</h2>
                <button className='add-btn'>Ajouter</button>
            </div>
            <div className="menu">
                <p className='title'>TITLE</p>
                <p className='type'>TYPE</p>
                <p className='date'>DATE</p>
                <div className='menu_buttons placeholder'>PLUS</div>
            </div>
            <div className="data">
                {displayEvents()}
            </div>
            <div className="footer">
                <div className="buttons">
                    <button className='switch-btn' onClick={pageHandler.prevPage} value="-1"><VscChevronLeft/></button>
                    <button className='switch-btn' onClick={pageHandler.nextPage} value="1"><VscChevronRight/></button>
                </div>
                <p>Page {pageHandler.page + 1} / {pageHandler.maxPage || 1}</p>
            </div>
        </div>
    );
};

export default StudentEvents;