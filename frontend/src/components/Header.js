import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { IoPower } from 'react-icons/io5';
import { HiOutlineMoon } from 'react-icons/hi';
import { MdWbSunny } from 'react-icons/md';

const Header = () => {

    const [isDark, setIsDark] = useState(isDarkMode());
    const navigate = useNavigate();

    const handleToggleDarkMode = () => {
        isDarkMode() ?
            document.documentElement.classList.remove('dark-mode') :
            document.documentElement.classList.add('dark-mode');
        
        setIsDark(prev => !prev);
    }

    const displayDarkModeIcon = () => !isDark ?
        <HiOutlineMoon id='dark-mode_icon' onClick={handleToggleDarkMode} /> :
        <MdWbSunny id='light-mode_icon' onClick={handleToggleDarkMode} />

    return (
        <div className="app-header">
            <div className="header-content">
                <div className="brand">
                    <h1 onClick={() => navigate('/')}>Annuaire NWS</h1>
                </div>
                <div className="buttons">
                    <button>{displayDarkModeIcon()}</button>
                    <button><IoPower id='disconnect_icon' /></button>
                </div>
            </div>
        </div>
    );
};

export default Header;

const isDarkMode = () => document.documentElement.classList.contains('dark-mode');