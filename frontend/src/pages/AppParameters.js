import React from 'react';
import Header from '../components/Header';
import Years from '../components/year/Years';
import Specs from '../components/spec/Specs';

const AppParameters = () => {
    return (
        <section id="years-page">
            <Header />

            <div className="main-area">
                <div className="main-content">

                    <div className="row">
                        <Years />
                        <Specs />
                    </div>

                </div>
            </div>
        </section>
    );
};

export default AppParameters;