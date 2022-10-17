import React, { useState } from 'react';
import { Modal } from 'skz-ui';
import { useParams } from 'react-router-dom';
import Header from '../components/Header';
import StudentCard from '../components/student/StudentCard';
import useFetch from '../hooks/useFetch';
import { defaultStudent } from '../utils/model-defaults';
import StudentForm from '../components/student/StudentForm';
import StudentEvents from '../components/student/StudentEvents';

const AppStudent = () => {

    const { id } = useParams();
    const studentReq = useFetch('student/student/?_id=' + id);

    const [studentModal, setStudentModal] = useState({
        student: defaultStudent,
        isOpen: false,
        method: 'PUT',
        closeModal: () => setStudentModal(prev => { return {...prev, isOpen: false}})
    });

    const openStudentModal = (student = defaultStudent, method = 'PUT') =>
        setStudentModal({
            ...studentModal,
            isOpen: true,
            student,
            method
        });

    const displayStudentModal = () =>
        <Modal 
            open={studentModal.isOpen} 
            onClose={studentModal.closeModal} 
            body={
                <StudentForm 
                    studentInfos={studentModal.student}
                    method={studentModal.method}
                    closeModal={studentModal.closeModal}
                    onSubmit={studentReq.doFetch}
                />
            } 
        />

    return (
        <section id="student-page">
            <Header />
            {displayStudentModal()}
            <div className="main-area">
                <div className="main-content">

                    <StudentCard studentInfos={studentReq.data?.body} openStudentModal={openStudentModal} />
                    <StudentEvents participationsIds={studentReq.data?.body?.participations} />

                </div>
            </div>
        </section>
    );
};

export default AppStudent;