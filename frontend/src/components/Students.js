import React, { useEffect, useState } from 'react';
import useFetch from '../hooks/useFetch';
import { Modal } from 'skz-ui';
import { defaultStudent } from '../utils/model-defaults';
import { calcMaxPage } from '../utils/useful-functions';
import StudentForm from './StudentForm';
import Student from './Student';
import { VscChevronLeft, VscChevronRight } from 'react-icons/vsc';
import apiRequest from '../utils/api-request';

const Students = () => {

    const studentsReq = useFetch('students/students');
    const [students, setStudents] = useState([]);
    const [sortOptions, setSortOptions] = useState({
        page: 0,
        pageSize: 6,
        maxPage: 0
    });

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
        setSortOptions({
            ...sortOptions, 
            maxPage: calcMaxPage(body.length, sortOptions.pageSize)
        });
    }, [studentsReq.data]);

    const handleChangePage = event =>
    setSortOptions({
        ...sortOptions,
        page: changePage(event)
    });

    const openStudentModal = (student = defaultStudent, method = 'POST') =>
        setStudentModal({
            ...studentModal,
            isOpen: true,
            student,
            method
        });

    const changePage = event => {
        let newPage = sortOptions.page + parseInt(event.currentTarget.value);
        const pages = sortOptions.maxPage - 1;
        if (newPage > pages) return pages;
        if (newPage < 0) return 0;
        if (newPage !== sortOptions.page) return newPage;
    };

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

        const start = 6 * sortOptions.page;
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
        const res = await apiRequest('students/student', 'DELETE', { _id: studentId });
        if (res.status === 200) studentsReq.doFetch();
    }

    return (
        <div className="students">
            {displayStudentModal()}
            <div className="header">
                <h2>Students</h2>
                <button className='add-btn' onClick={() => openStudentModal()}>Ajouter</button>
            </div>
            <div className="menu">
                <p className='fname'>PRENOM</p>
                <p className='lname'>NOM</p>
                <p className='age'>AGE</p>
                <p className='gender'>SEXE</p>
                <p className='email'>EMAIL</p>
                <p className='phone'>TELEPHONE</p>
                <p className='degree'>DIPLOME</p>
                <div className='menu_buttons placeholder'>PLUS</div>
            </div>
            <div className="data">
                {displayStudents()}
            </div>
            <div className="footer">
                <div className="buttons">
                    <button className='switch-btn' onClick={handleChangePage} value="-1"><VscChevronLeft/></button>
                    <button className='switch-btn' onClick={handleChangePage} value="1"><VscChevronRight/></button>
                </div>
                <p>Page {sortOptions.page + 1} / {sortOptions.maxPage}</p>
            </div>
        </div>
    );
};

export default Students;