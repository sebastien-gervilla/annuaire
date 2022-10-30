import React from 'react';
import Header from '../components/Header';

const NotFound = () => {
    return (
        <section className="not-found-page">
            <Header />

            <div className="main-area">
                <div className="main-content">

                    <img src="/assets/images/notfound.png" alt="Not found image" />

                </div>
            </div>
        </section>
    );
};

export default NotFound;