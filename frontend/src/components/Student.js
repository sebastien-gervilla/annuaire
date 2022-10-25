import React from 'react';
import { useNavigate } from 'react-router-dom';
import { AiFillDelete, AiOutlineInfoCircle } from 'react-icons/ai';
import { TbEdit } from 'react-icons/tb';
import useClipboard from '../hooks/useClipboard';

const Student = ({ studentInfos, specs, openStudentModal, deleteStudent }) => {

    const navigate = useNavigate();
    const { setAnchor } = useClipboard();

    const { _id } = studentInfos;

    const handleEditStudent = event => openStudentModal(studentInfos, 'PUT');

    const handleDeleteStudent = event => _id && deleteStudent(_id);

    const handleShowStudent = event => navigate('/student/' + _id);

    const handleHoverCopy = event => setAnchor(event.target);

    const handleLeaveCopy = event => setAnchor(null);

    const displayStudent = () => studentInfos &&
        Object.entries(studentInfos)
            .filter(([name, value]) => ['fname', 'lname', 'age', 'gender', 'email'].includes(name))
            .map(([name, value]) =>
                <p key={name} className={name + ' copyable'}>
                    {name && <span 
                        onMouseOver={handleHoverCopy} 
                        onMouseLeave={handleLeaveCopy}
                        >{value}</span>}
                </p>
            )

    const displayPathways = () => studentInfos?.pathways && specs &&
        studentInfos.pathways.map(pathway => {
            const spec = specs.find(specialization => specialization._id === pathway);
            return (
                <div key={spec._id} className={"pathway " + spec.title.substr(0, 3)}>
                    <span>{spec.title[0]}</span>
                </div>
            );
        });

    return (
        <div className="student box-component-el">
            {displayStudent()}
            <div className="pathways">
                {displayPathways()}
            </div>

            <div className="menu_buttons">
                <AiOutlineInfoCircle className='info-btn_icon' onClick={handleShowStudent} />
                <TbEdit className='edit-btn_icon' onClick={handleEditStudent} />
                <AiFillDelete className='del-btn_icon' onClick={handleDeleteStudent} />
            </div>
        </div>
    );
};

export default Student;