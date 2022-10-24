import React, { useEffect, useState } from 'react';
import useFetch from '../hooks/useFetch';
import { Modal } from 'skz-ui';
import { defaultEvent, filterEventOptions } from '../utils/model-defaults';
import EventForm from './event/EventForm';
import Event from './Event';
import { VscChevronLeft, VscChevronRight } from 'react-icons/vsc';
import apiRequest from '../utils/api-request';
import usePagination from '../hooks/usePagination';
import useSort from '../hooks/useSort';
import DataMenu from './DataMenu';
import FilterMenu from './FilterMenu';

const Events = () => {

    const eventsReq = useFetch('event/events');
    const [events, setEvents] = useState([]);

    const { sortedData, sortOptions, handleChanges, 
        handleToggleOrder, setOptions } = useSort(events, filterEventOptions);

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
        if (!sortedData) return;

        const start = 6 * pageHandler.page;
        const end = (start + 6) > sortedData.length ? 
            sortedData.length : (start + 6);

        const displayedEvents = sortedData.slice(start, end);

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
        <div className="events box-component full-component">
            {displayEventModal()}
            <div className="header">
                <h2>Evènements</h2>
                <button className='add-btn' onClick={() => openEventModal()}>Ajouter</button>
            </div>
            <FilterMenu sortOptions={sortOptions} labels={menuLabels} handleChanges={handleChanges} />
            <DataMenu fields={dataMenuFields} sortedOption={sortOptions.sorted} handleToggleOrder={handleToggleOrder} />
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

const dataMenuFields = [
    { name: 'title', label: 'TITRE' },
    { name: 'type', label: 'TYPE' },
    { name: 'description', label: 'DESCRIPTION' },
    { name: 'date', label: "DATE D'EVENEMENT" }
];

const menuLabels = [
    'Titre',
    'Type',
    'Description',
    "Date d'évènements"
];

export default Events;