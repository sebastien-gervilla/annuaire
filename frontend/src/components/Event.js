import React, { useRef } from 'react';
import { AiFillDelete } from 'react-icons/ai';
import { TbEdit } from 'react-icons/tb';

const Event = ({ eventInfos, openEventModal, deleteEvent }) => {

    const messageRef = useRef(null);

    const { _id } = eventInfos;

    const handleEditEvent = event => openEventModal(eventInfos, 'PUT');

    const handleDeleteEvent = event => _id && deleteEvent(_id);

    const handleCopy = event => {
        if (!event.target.textContent) return;
        navigator.clipboard.writeText(event.target.textContent);
        messageRef.current.textContent = "Collé !";
    }

    const handleHoverCopy = event => {
        if (messageRef.current) return;
        const msg = document.createElement('p');
        msg.classList.add('copy-msg');
        msg.textContent = 'Copier';
        const rect = event.target.getBoundingClientRect();
        msg.style.left = (rect.x + rect.width * 2 / 3) + 'px';
        msg.style.top = (rect.y + rect.height * 1.5) + 'px';
        document.body.appendChild(msg);
        messageRef.current = msg;
        setTimeout(() => msg.classList.add('appear'), 1)
    }

    const handleLeaveCopy = event => {
        if (!messageRef.current) return;
        messageRef.current.classList.remove('appear');
        console.log(messageRef.current);
        setTimeout(() => {
            document.body.removeChild(messageRef.current);
            messageRef.current = null;
        }, 1);
    }

    const displayEvent = () =>
        Object.entries(eventInfos)
            .filter(([name, value]) => ['title', 'type', 'creation_date'].includes(name))
            .map(([name, value]) =>
                <p key={name} className={name + (value ? ' active' : '')}>
                    {name && <span 
                        onMouseOver={handleHoverCopy} 
                        onMouseLeave={handleLeaveCopy}
                        onClick={handleCopy}
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