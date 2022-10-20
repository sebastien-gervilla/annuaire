import React, { useEffect, useState } from 'react';
import useFetch from '../hooks/useFetch';
import { Modal } from 'skz-ui';
import { defaultStudent } from '../utils/model-defaults';
import StudentForm from './student/StudentForm';
import Student from './Student';
import { VscChevronLeft, VscChevronRight } from 'react-icons/vsc';
import apiRequest from '../utils/api-request';
import usePagination from '../hooks/usePagination';

const Students = () => {

    const studentsReq = useFetch('student/students');
    const [students, setStudents] = useState([]);

    const pageHandler = usePagination();

    const [studentModal, setStudentModal] = useState({
        student: defaultStudent,
        isOpen: false,
        method: 'POST',
        closeModal: () => setStudentModal(prev => { return {...prev, isOpen: false}})
    });

    useEffect(() => {
        const body = studentsReq.data?.body;
        if (!body) return;
        setStudents(body);
        pageHandler.updateMax(body.length);
    }, [studentsReq.data]);

    useEffect(() => {
        const body = studentsReq.data?.body;
        if (!body) return;
        pageHandler.refreshPage(body.length);
    }, [pageHandler.maxPage]);

    const openStudentModal = (student = defaultStudent, method = 'POST') =>
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
                    onSubmit={studentsReq.doFetch}
                />
            } 
        />

    const displayStudents = () => {
        if (!students) return;

        const start = 6 * pageHandler.page;
        const end = (start + 6) > students.length ? 
            students.length : (start + 6);

        const displayedStudents = students.slice(start, end);

        return displayedStudents.map(student =>
            <Student key={student._id} 
                studentInfos={student}
                openStudentModal={openStudentModal}
                deleteStudent={deleteStudent}
            />
        )
    }

    // Api calls

    const deleteStudent = async studentId => { // Snackbar when delete ?
        const res = await apiRequest('student/student', 'DELETE', { _id: studentId });
        if (res.status === 200) studentsReq.doFetch();
    }

    return (
        <div className="students half-component">
            {displayStudentModal()}
            <div className="header">
                <h2>Elèves</h2>
                <button className='add-btn' onClick={() => openStudentModal()}>Ajouter</button>
            </div>
            <div className="menu">
                <p className='fname'>PRENOM</p>
                <p className='lname'>NOM</p>
                <p className='email'>EMAIL</p>
                <div className='menu_buttons placeholder'>PLUS</div>
            </div>
            <div className="data">
                {displayStudents()}
            </div>
            <div className="footer">
                <div className="buttons">
                    <button className='switch-btn' onClick={pageHandler.prevPage} value="-1"><VscChevronLeft/></button>
                    <button className='switch-btn' onClick={pageHandler.nextPage} value="1"><VscChevronRight/></button>
                </div>
                <p>Page {pageHandler.page + 1} / {pageHandler.maxPage || 1}</p>
            </div>
        </div>
    );
};

export default Students;