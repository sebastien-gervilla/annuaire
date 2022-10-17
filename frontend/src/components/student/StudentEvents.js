import React, { useEffect, useState } from 'react';
import { VscChevronLeft, VscChevronRight } from 'react-icons/vsc';
import { Modal } from 'skz-ui';
import useFetch from '../../hooks/useFetch';
import { defaultEvent } from '../../utils/model-defaults';
import { calcMaxPage } from '../../utils/useful-functions';
import EventForm from '../event/EventForm';
import StudentEvent from './StudentEvent';
import apiRequest from '../../utils/api-request';

const StudentEvents = ({ participationsIds }) => {

    const eventsReq = useFetch('event/events');
    console.log(eventsReq.data);

    const [events, setEvents] = useState([]);
    const [sortOptions, setSortOptions] = useState({
        page: 0,
        pageSize: 6,
        maxPage: 0
    });

    useEffect(() => {
        const body = eventsReq.data?.body;
        if (!body) return;
        setEvents(getEvents());
        setSortOptions({
            ...sortOptions, 
            maxPage: calcMaxPage(body.length, sortOptions.pageSize)
        });
    }, [eventsReq.data]);

    const getEvents = () => participationsIds && eventsReq.data?.body && 
        eventsReq.data?.body?.filter(event =>
            participationsIds.includes(event._id)
        );

    const handleChangePage = event =>
    setSortOptions({
        ...sortOptions,
        page: changePage(event)
    });

    const changePage = event => {
        let newPage = sortOptions.page + parseInt(event.currentTarget.value);
        const pages = sortOptions.maxPage - 1;
        if (newPage > pages) return pages;
        if (newPage < 0) return 0;
        if (newPage !== sortOptions.page) return newPage;
    };

    const displayEvents = () => {
        if (!events) return;

        const start = 6 * sortOptions.page;
        const end = (start + 6) > events.length ? 
            events.length : (start + 6);

        const displayedEvents = events.slice(start, end);

        return displayedEvents.map(event =>
            <StudentEvent key={event._id} 
                eventInfos={event}
                removeEvent={removeEvent}
            />
        )
    }

    // Api calls

    const removeEvent = async eventId => { // call delete function here
        const res = await apiRequest('event/event', 'DELETE', { _id: eventId });
        if (res.status === 200) eventsReq.doFetch();
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
                <p className='creation_date'>DATE DE CREATION</p>
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

export default StudentEvents;