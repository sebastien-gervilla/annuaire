import React, { useEffect, useState } from 'react';
import useFetch from '../hooks/useFetch';
import { Modal } from 'skz-ui';
import { defaultStudent } from '../utils/model-defaults';
import { calcMaxPage } from '../utils/useful-functions';
import StudentForm from './StudentForm';
import Student from './Student';
import { VscChevronLeft, VscChevronRight } from 'react-icons/vsc';

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
        closeModal: () => setStudentModal(prev => { return {...prev, isOpen: false}})
    });

    useEffect(() => console.log(studentsReq.data), [studentsReq]);

    useEffect(() => {
        const body = studentsReq.data?.body;
        if (!body) return;
        setStudents(body);
        setSortOptions({
            ...sortOptions, 
            maxPage: calcMaxPage(body.length, sortOptions.pageSize)
        });
    }, [studentsReq.data]);

    const handleOpenStudentModal = event => {
        event.preventDefault();
        setStudentModal({...studentModal, isOpen: true});
    }

    const onSubmit = () => studentsReq.doFetch();

    const displayStudentModal = () =>
        <Modal 
            open={studentModal.isOpen} 
            onClose={studentModal.closeModal} 
            body={
                <StudentForm 
                    studentInfos={studentModal.student}
                    closeModal={studentModal.closeModal}
                    onSubmit={onSubmit}
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
            <Student key={student._id} studentInfos={student} />
        )
    }

    const handleChangePage = event =>
        setSortOptions({
            ...sortOptions,
            page: changePage(event)
        });

    const changePage = event => {
        let newPage = sortOptions.page + parseInt(event.currentTarget.value);
        const pages = sortOptions.maxPage - 1;
        if (newPage > pages) return pages;
        if (newPage < 0) return 0;
        if (newPage !== sortOptions.page) return newPage;
    };

    return (
        <div className="students">
            {displayStudentModal()}
            <div className="header">
                <h2>Students</h2>
                <button className='add-btn' onClick={handleOpenStudentModal}>Ajouter</button>
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