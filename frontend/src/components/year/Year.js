import React from 'react';
import { useNavigate } from 'react-router-dom';
import { AiFillDelete } from 'react-icons/ai';
import { TbEdit } from 'react-icons/tb';
import useClipboard from '../../hooks/useClipboard';

const Year = ({ yearInfos, openYearModal, deleteYear }) => {

    const navigate = useNavigate();
    const { setAnchor } = useClipboard();

    const { _id } = yearInfos;

    const handleEditYear = event => openYearModal(yearInfos, 'PUT');

    const handleDeleteYear = event => _id && deleteYear(_id);

    const handleHoverCopy = event => setAnchor(event.target);

    const handleLeaveCopy = event => setAnchor(null);

    const displayYear = () => yearInfos &&
        Object.entries(yearInfos)
            .filter(([name, value]) => ['title'].includes(name))
            .map(([name, value]) =>
                <p key={name} className={name + ' copyable'}>
                    {name && <span 
                        onMouseOver={handleHoverCopy} 
                        onMouseLeave={handleLeaveCopy}
                        >{value}</span>}
                </p>
            )

    const displayMenuButtons = () => yearInfos && !yearInfos.is_admin &&
        <div className="menu_buttons">
            <TbEdit className='edit-btn_icon' onClick={handleEditYear} />
            <AiFillDelete className='del-btn_icon' onClick={handleDeleteYear} />
        </div>

    return (
        <div className="year box-component-el">
            {displayYear()}
            {displayMenuButtons()}
        </div>
    );
};

export default Year;