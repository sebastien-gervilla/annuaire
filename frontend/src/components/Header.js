import React from 'react';
import { IoPower } from 'react-icons/io5';
import { HiOutlineMoon } from 'react-icons/hi';

const Header = () => {
    return (
        <div className="app-header">
            <div className="header-content">
                <div className="brand">
                    <h1>Annuaire NWS</h1>
                </div>
                <div className="buttons">
                    <button><HiOutlineMoon id='dark-mode_icon' /></button>
                    <button><IoPower id='disconnect_icon' /></button>
                </div>
            </div>
        </div>
    );
};

export default Header;