import React, { useEffect, useState } from 'react';
import useFetch from '../hooks/useFetch';
import { Modal } from 'skz-ui';
import { defaultEvent } from '../utils/model-defaults';
import EventForm from './event/EventForm';
import Event from './Event';
import { VscChevronLeft, VscChevronRight } from 'react-icons/vsc';
import apiRequest from '../utils/api-request';
import usePagination from '../hooks/usePagination';

const Events = () => {

    const eventsReq = useFetch('event/events');
    const [events, setEvents] = useState([]);

    const pageHandler = usePagination();

    const [eventModal, setEventModal] = useState({
        event: defaultEvent,
        isOpen: false,
        method: 'POST',
        closeModal: () => setEventModal(prev => { return {...prev, isOpen: false}})
    });

    useEffect(() => {
        const body = eventsReq.data?.body;
        if (!body) return;
        setEvents(body);
        pageHandler.updateMax(body.length);
    }, [eventsReq.data]);

    useEffect(() => {
        const body = eventsReq.data?.body;
        if (!body) return;
        pageHandler.refreshPage(body.length);
    }, [pageHandler.maxPage]);

    const openEventModal = (event = defaultEvent, method = 'POST') =>
        setEventModal({
            ...eventModal,
            isOpen: true,
            event,
            method
        });

    const displayEventModal = () =>
        <Modal 
            open={eventModal.isOpen} 
            onClose={eventModal.closeModal} 
            body={
                <EventForm 
                    eventInfos={eventModal.event}
                    method={eventModal.method}
                    closeModal={eventModal.closeModal}
                    onSubmit={eventsReq.doFetch}
                />
            } 
        />

    const displayEvents = () => {
        if (!events) return;

        const start = 6 * pageHandler.page;
        const end = (start + 6) > events.length ? 
            events.length : (start + 6);

        const displayedEvents = events.slice(start, end);

        return displayedEvents.map(event =>
            <Event key={event._id} 
                eventInfos={event}
                openEventModal={openEventModal}
                deleteEvent={deleteEvent}
            />
        )
    }

    // Api calls

    const deleteEvent = async eventId => { // Snackbar when delete ?
        const res = await apiRequest('event/event', 'DELETE', { _id: eventId });
        if (res.status === 200) eventsReq.doFetch();
    }

    return (
        <div className="events half-component">
            {displayEventModal()}
            <div className="header">
                <h2>Evènements</h2>
                <button className='add-btn' onClick={() => openEventModal()}>Ajouter</button>
            </div>
            <div className="menu">
                <p className='title'>TITLE</p>
                <p className='type'>TYPE</p>
                <p className='date'>DATE D'EVENEMENT</p>
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

export default Events;