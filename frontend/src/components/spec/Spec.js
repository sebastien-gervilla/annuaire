import React from 'react';
import { useNavigate } from 'react-router-dom';
import { AiFillDelete } from 'react-icons/ai';
import { TbEdit } from 'react-icons/tb';
import useClipboard from '../../hooks/useClipboard';

const Spec = ({ specInfos, openSpecModal, deleteSpec }) => {

    const navigate = useNavigate();
    const { setAnchor } = useClipboard();

    const { _id } = specInfos;

    const handleEditSpec = event => openSpecModal(specInfos, 'PUT');

    const handleDeleteSpec = event => _id && deleteSpec(_id);

    const handleHoverCopy = event => setAnchor(event.target);

    const handleLeaveCopy = event => setAnchor(null);

    const displaySpec = () => specInfos &&
        Object.entries(specInfos)
            .filter(([name, value]) => ['title', 'color', 'contrast'].includes(name))
            .map(([name, value]) =>
                <p key={name} className={name + ' copyable'} style={{color: (name === 'color') ? value : 'unset'}}>
                    {name && <span 
                        onMouseOver={handleHoverCopy} 
                        onMouseLeave={handleLeaveCopy}
                        >{value}</span>}
                </p>
            )

    const displayMenuButtons = () => specInfos && !specInfos.is_admin &&
        <div className="menu_buttons">
            <TbEdit className='edit-btn_icon' onClick={handleEditSpec} />
            <AiFillDelete className='del-btn_icon' onClick={handleDeleteSpec} />
        </div>

    return (
        <div className="spec box-component-el">
            {displaySpec()}
            {displayMenuButtons()}
        </div>
    );
};

export default Spec;