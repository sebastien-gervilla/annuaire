import React from 'react';
import { useNavigate } from 'react-router-dom';
import { AiFillDelete } from 'react-icons/ai';
import { TbEdit } from 'react-icons/tb';
import useClipboard from '../../hooks/useClipboard';

const User = ({ userInfos, openUserModal, deleteUser }) => {

    const navigate = useNavigate();
    const { setAnchor } = useClipboard();

    const { _id } = userInfos;

    const handleEditUser = event => openUserModal(userInfos, 'PUT');

    const handleDeleteUser = event => _id && deleteUser(_id);

    const handleHoverCopy = event => setAnchor(event.target);

    const handleLeaveCopy = event => setAnchor(null);

    const displayUser = () => userInfos &&
        Object.entries(userInfos)
            .filter(([name, value]) => ['fname', 'lname', 'email'].includes(name))
            .map(([name, value]) =>
                <p key={name} className={name + ' copyable'}>
                    {name && <span 
                        onMouseOver={handleHoverCopy} 
                        onMouseLeave={handleLeaveCopy}
                        >{value}</span>}
                </p>
            )

    const displayMenuButtons = () => userInfos && !userInfos.is_admin &&
        <div className="menu_buttons">
            <TbEdit className='edit-btn_icon' onClick={handleEditUser} />
            <AiFillDelete className='del-btn_icon' onClick={handleDeleteUser} />
        </div>

    return (
        <div className="user box-component-el">
            {displayUser()}
            {displayMenuButtons()}
        </div>
    );
};

export default User;