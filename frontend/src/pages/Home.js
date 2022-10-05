import React from 'react';
import Header from '../components/Header';
import Students from '../components/Students';

const Home = () => {
    return (
        <section id="home-page">
            <Header />

            <div className="main-area">
                <div className="main-content">

                    <Students />

                </div>
            </div>
        </section>
    );
};

export default Home;