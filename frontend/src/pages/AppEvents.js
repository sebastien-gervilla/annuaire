import React, { useState } from 'react';
import Header from '../components/Header';

const AppEvents = () => {

    
    const [sortOptions, setSortOptions] = useState({
        page: 0,
        pageSize: 6,
        selectedEvent: null
    })

    return (
        <section id="events-page">
            <Header />
        </section>
    );
};

export default AppEvents;