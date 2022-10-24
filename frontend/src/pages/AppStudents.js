import React from 'react';
import Events from '../components/Events';
import Header from '../components/Header';
import Students from '../components/Students';

const AppStudents = () => {
    return (
        <section id="home-page">
            <Header />

            <div className="main-area">
                <div className="main-content">

                    <Students />
                    <Events />

                </div>
            </div>
        </section>
    );
};

export default AppStudents;