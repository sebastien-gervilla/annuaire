import React from 'react';
import Events from '../components/Events';
import Header from '../components/Header';
import Students from '../components/Students';
import useAuth from '../hooks/useAuth';

const AppStudents = () => {

    useAuth();

    return (
        <section id="home-page">
            <Header />

            <div className="main-area">
                <div className="main-content">

                    <Events />
                    <Students />

                </div>
            </div>
        </section>
    );
};

export default AppStudents;