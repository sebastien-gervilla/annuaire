import React, { useState } from 'react';
import { useNavigate, NavLink } from 'react-router-dom';
import { IoPower } from 'react-icons/io5';
import { HiOutlineMoon } from 'react-icons/hi';
import { MdWbSunny } from 'react-icons/md';
import { GoGear } from 'react-icons/go';
import apiRequest from '../utils/api-request';
import useAuth from '../hooks/useAuth';

const Header = ({ needAdmin = false }) => {

    const { refresh } = useAuth(needAdmin);

    const [isDark, setIsDark] = useState(isDarkMode());
    const navigate = useNavigate();

    const handleToggleDarkMode = () => {
        isDarkMode() ?
            document.documentElement.classList.remove('dark-mode') :
            document.documentElement.classList.add('dark-mode');
        
        setIsDark(prev => !prev);
    }

    const handleLogout = async event => {
        const res = await apiRequest('auth/logout', 'POST', { token : document.cookie });
        if (res && res.success) {
            document.cookie = "token=; Path=/; Expires = Thu, 01 Jan 1970 00:00:01 GMT;";
            refresh();
        };
    }

    const displayDarkModeIcon = () => !isDark ?
        <HiOutlineMoon id='dark-mode_icon' onClick={handleToggleDarkMode} /> :
        <MdWbSunny id='light-mode_icon' onClick={handleToggleDarkMode} />

    return (
        <div className="app-header">
            <div className="header-content">
                <div className="brand">
                    <img onClick={() => navigate('/')} src="/assets/images/logo.png" alt="Directory icon" />
                    <h1 onClick={() => navigate('/')}>Annuaire</h1>
                </div>
                <div className="buttons">
                    <button>{displayDarkModeIcon()}</button>
                    <button onClick={() => navigate('/parameters')} ><GoGear id='parameters_icon'/></button>
                    <button onClick={handleLogout}><IoPower id='disconnect_icon'/></button>
                </div>
            </div>
        </div>
    );
};

export default Header;

const isDarkMode = () => document.documentElement.classList.contains('dark-mode');