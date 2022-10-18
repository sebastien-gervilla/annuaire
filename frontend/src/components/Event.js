import React from 'react';
import { AiFillDelete } from 'react-icons/ai';
import { TbEdit } from 'react-icons/tb';
import useClipboard from '../hooks/useClipboard';

const Event = ({ eventInfos, openEventModal, deleteEvent }) => {

    const { setAnchor } = useClipboard();

    const { _id } = eventInfos;

    const handleEditEvent = event => openEventModal(eventInfos, 'PUT');

    const handleDeleteEvent = event => _id && deleteEvent(_id);

    const handleHoverCopy = event => setAnchor(event.target);

    const handleLeaveCopy = event => setAnchor(null);

    const displayEvent = () =>
        Object.entries(eventInfos)
            .filter(([name, value]) => ['title', 'type', 'creation_date'].includes(name))
            .map(([name, value]) =>
                <p key={name} className={name + (value ? ' active' : '')}>
                    {name && <span 
                        onMouseOver={handleHoverCopy} 
                        onMouseLeave={handleLeaveCopy}
                        >{value}</span>}
                </p>
            );

    return (
        <div className="event half-component-el">
            {displayEvent()}
            <div className="menu_buttons">
                <TbEdit className='edit-btn_icon' onClick={handleEditEvent} />
                <AiFillDelete className='del-btn_icon' onClick={handleDeleteEvent} />
            </div>
        </div>
    );
};

export default Event;