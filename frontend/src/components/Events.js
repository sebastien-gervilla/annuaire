import React, { useEffect, useState } from 'react';
import useFetch from '../hooks/useFetch';
import { Modal } from 'skz-ui';
import { defaultEvent } from '../utils/model-defaults';
import { calcMaxPage } from '../utils/useful-functions';
import EventForm from './event/EventForm';
import Event from './Event';
import { VscChevronLeft, VscChevronRight } from 'react-icons/vsc';
import apiRequest from '../utils/api-request';

const Events = () => {

    const eventsReq = useFetch('event/events');
    const [events, setEvents] = useState([]);
    const [sortOptions, setSortOptions] = useState({
        page: 0,
        pageSize: 6,
        maxPage: 0
    });

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
        setSortOptions({
            ...sortOptions, 
            maxPage: calcMaxPage(body.length, sortOptions.pageSize)
        });
    }, [eventsReq.data]);

    const handleChangePage = event =>
    setSortOptions({
        ...sortOptions,
        page: changePage(event)
    });

    const openEventModal = (event = defaultEvent, method = 'POST') =>
        setEventModal({
            ...eventModal,
            isOpen: true,
            event,
            method
        });

    const changePage = event => {
        let newPage = sortOptions.page + parseInt(event.currentTarget.value);
        const pages = sortOptions.maxPage - 1;
        if (newPage > pages) return pages;
        if (newPage < 0) return 0;
        if (newPage !== sortOptions.page) return newPage;
    };

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

        const start = 6 * sortOptions.page;
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
                    <button className='switch-btn' onClick={handleChangePage} value="-1"><VscChevronLeft/></button>
                    <button className='switch-btn' onClick={handleChangePage} value="1"><VscChevronRight/></button>
                </div>
                <p>Page {sortOptions.page + 1} / {sortOptions.maxPage || 1}</p>
            </div>
        </div>
    );
};

export default Events;