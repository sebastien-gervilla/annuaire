import React, { useEffect, useState } from 'react';
import useFetch from '../hooks/useFetch';
import { Modal } from 'skz-ui';
import { defaultStudent } from '../utils/model-defaults';
import StudentForm from './StudentForm';

const Students = () => {

    const studentsReq = useFetch('students/students');

    const [studentModal, setStudentModal] = useState({
        student: defaultStudent,
        isOpen: false,
        closeModal: () => setStudentModal(prev => { return {...prev, isOpen: false}})
    });

    useEffect(() => console.log(studentsReq.data), [studentsReq]);

    const handleOpenStudentModal = event => {
        event.preventDefault();
        setStudentModal({...studentModal, isOpen: true});
    }

    const displayStudentModal = () =>
        <Modal 
            open={studentModal.isOpen} 
            onClose={studentModal.closeModal} 
            body={
                <StudentForm 
                    studentInfos={studentModal.student}
                    closeModal={studentModal.closeModal}
                />
            } 
        />

    return (
        <div className="students">
            {displayStudentModal()}
            <div className="header">
                <h2>Students</h2>
                <button onClick={handleOpenStudentModal}>Ajouter</button>
            </div>
            <div className="data">

            </div>
            <div className="footer">

            </div>
        </div>
    );
};

export default Students;