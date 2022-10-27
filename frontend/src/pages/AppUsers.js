import React from 'react';
import Users from '../components/Users';
import Header from '../components/Header';

const AppUsers = () => {
    return (
        <section id="users-page">
            <Header needAdmin />

            <div className="main-area">
                <div className="main-content">

                    <Users />

                </div>
            </div>
        </section>
    );
};

export default AppUsers;