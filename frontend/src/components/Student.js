import React from 'react';
import { useNavigate } from 'react-router-dom';
import { AiFillDelete, AiOutlineInfoCircle } from 'react-icons/ai';
import { TbEdit } from 'react-icons/tb';
import useClipboard from '../hooks/useClipboard';

const Student = ({ studentInfos, openStudentModal, deleteStudent }) => {

    const navigate = useNavigate();
    const { setAnchor } = useClipboard();

    const { _id } = studentInfos;

    const handleEditStudent = event => openStudentModal(studentInfos, 'PUT');

    const handleDeleteStudent = event => _id && deleteStudent(_id);

    const handleShowStudent = event => navigate('/student/' + _id);

    const handleHoverCopy = event => setAnchor(event.target);

    const handleLeaveCopy = event => setAnchor(null);

    const displayStudent = () =>
        Object.entries(studentInfos)
            .filter(([name, value]) => ['fname', 'lname', 'email'].includes(name))
            .map(([name, value]) =>
                <p key={name} className={name + (value ? ' active' : '')}>
                    {name && <span 
                        onMouseOver={handleHoverCopy} 
                        onMouseLeave={handleLeaveCopy}
                        >{value}</span>}
                </p>
            )

    return (
        <div className="student half-component-el">
        <div className="student box-component-el">
            {displayStudent()}

            <div className="menu_buttons">
                <AiOutlineInfoCircle className='info-btn_icon' onClick={handleShowStudent} />
                <TbEdit className='edit-btn_icon' onClick={handleEditStudent} />
                <AiFillDelete className='del-btn_icon' onClick={handleDeleteStudent} />
            </div>
        </div>
    );
};

export default Student;