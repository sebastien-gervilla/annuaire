import React from 'react';

const Header = () => {
    return (
        <div className="app-header">
            <div className="header-content">
                <div className="brand">
                    <h1>Annuaire NWS</h1>
                </div>
                <div className="buttons">
                    <button><img src="/assets/icons/disconnect.svg" alt="Disconnect icon"/></button>
                </div>
            </div>
        </div>
    );
};

export default Header;