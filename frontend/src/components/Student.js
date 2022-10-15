import React, { useRef } from 'react';
import { AiFillDelete } from 'react-icons/ai';
import { TbEdit } from 'react-icons/tb';

const Student = ({ studentInfos, openStudentModal, deleteStudent }) => {

    const messageRef = useRef(null);

    const { _id } = studentInfos;

    const handleEditStudent = event => openStudentModal(studentInfos, 'PUT');

    const handleDeleteStudent = event => _id && deleteStudent(_id);

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
        setTimeout(() => {
            document.body.removeChild(messageRef.current);
            messageRef.current = null;
        }, 1);
    }

    const displayStudent = () =>
        Object.entries(studentInfos)
            .filter(([name, value]) => ['fname', 'lname', 'age', 'email'].includes(name))
            .map(([name, value]) =>
                <p key={name} className={name + (value ? ' active' : '')}>
                    {name && <span 
                        onMouseOver={handleHoverCopy} 
                        onMouseLeave={handleLeaveCopy}
                        onClick={handleCopy}
                        >{value}</span>}
                </p>
            )

    return (
        <div className="student half-component-el">
            {displayStudent()}

            <div className="menu_buttons">
                <TbEdit className='edit-btn_icon' onClick={handleEditStudent} />
                <AiFillDelete className='del-btn_icon' onClick={handleDeleteStudent} />
            </div>
        </div>
    );
};

export default Student;