import React, { useRef } from 'react';
import { IoRemoveCircleOutline } from 'react-icons/io5';
import useClipboard from '../../hooks/useClipboard';

const StudentEvent = ({ eventInfos, removeParticipation }) => {

    const { setAnchor } = useClipboard();

    const { _id } = eventInfos;

    const handleRemoveParticipation = event => _id && removeParticipation(_id);

    const handleHoverCopy = event => setAnchor(event.target);

    const handleLeaveCopy = event => setAnchor(null);

    const displayEvent = () => eventInfos &&
        Object.entries(eventInfos)
            .filter(([name, value]) => ['title', 'type', 'date'].includes(name))
            .map(([name, value]) =>
                <p key={name} className={name + ' copyable'}>
                    {name && <span 
                        onMouseOver={handleHoverCopy} 
                        onMouseLeave={handleLeaveCopy}
                        >{value}</span>}
                </p>
            );

    return (
        <div className="event box-component-el">
            {displayEvent()}
            <div className="menu_buttons">
                <IoRemoveCircleOutline className='del-btn_icon' onClick={handleRemoveParticipation} />
            </div>
        </div>
    );
};

export default StudentEvent;