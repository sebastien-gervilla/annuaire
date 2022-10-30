import React from 'react';
import Header from '../components/Header';
import Students from '../components/student/Students';
import Events from '../components/event/Events';

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