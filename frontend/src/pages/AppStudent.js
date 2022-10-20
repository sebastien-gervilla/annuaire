import React, { useState } from 'react';
import { Modal } from 'skz-ui';
import { useParams } from 'react-router-dom';
import Header from '../components/Header';
import StudentCard from '../components/student/StudentCard';
import useFetch from '../hooks/useFetch';
import { defaultStudent } from '../utils/model-defaults';
import StudentForm from '../components/student/StudentForm';
import StudentEvents from '../components/student/StudentEvents';
import apiRequest from '../utils/api-request';
import { toTimeFormat } from '../utils/useful-functions';

const AppStudent = () => {

    const { id } = useParams();
    const studentReq = useFetch('student/student/?_id=' + id);
    const participationReq = useFetch('participation/participation/?studentId=' + id);

    const [studentModal, setStudentModal] = useState({
        student: defaultStudent,
        isOpen: false,
        method: 'PUT',
        closeModal: () => setStudentModal({...studentModal, isOpen: false})
    });

    const openStudentModal = (student = defaultStudent, method = 'PUT') =>
        setStudentModal({
            ...studentModal,
            isOpen: true,
            student,
            method
        });

    const onSubmitModal = () => {
        studentReq.doFetch();
        participationReq.doFetch();
    }

    const displayStudentModal = () =>
        <Modal 
            open={studentModal.isOpen} 
            onClose={studentModal.closeModal} 
            body={
                <StudentForm 
                    studentInfos={studentModal.student}
                    method={studentModal.method}
                    closeModal={studentModal.closeModal}
                    onSubmit={onSubmitModal}
                />
            } 
        />

    const getParticipations = () => studentReq.data?.body?.participations?.map((participationId, index) => {
        return { _id: participationId, date: toTimeFormat(participationReq.data?.body?.find(
            participation => participation.event_id === participationId
        )?.date) };
    });

    // Api calls

    const removeParticipation = async (eventId, studentId) => {
        if (!studentId || !eventId) return;
        const res = await apiRequest('participation/participation', 'DELETE', { studentId, eventId });
        if (res.status === 200) studentReq.doFetch();
    }

    return (
        <section id="student-page">
            <Header />
            {displayStudentModal()}
            <div className="main-area">
                <div className="main-content">

                    <StudentCard studentInfos={studentReq.data?.body} openStudentModal={openStudentModal} />
                    <StudentEvents studentId={studentReq.data?.body?._id} 
                    participations={getParticipations()}
                    removeParticipation={removeParticipation} />

                </div>
            </div>
        </section>
    );
};

export default AppStudent;