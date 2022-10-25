import React, { useEffect, useState } from 'react';
import useFetch from '../hooks/useFetch';
import { Modal } from 'skz-ui';
import { defaultStudent, filterStudentOptions } from '../utils/model-defaults';
import StudentForm from './student/StudentForm';
import Student from './Student';
import { VscChevronLeft, VscChevronRight } from 'react-icons/vsc';
import apiRequest from '../utils/api-request';
import usePagination from '../hooks/usePagination';
import useSort from '../hooks/useSort';
import FilterMenu from './FilterMenu';
import DataMenu from './DataMenu';
import TableSelect from './TableSelect';

const Students = () => {

    const specsReq = useFetch('specialization/specializations');
    const studentsReq = useFetch('student/students');
    const [students, setStudents] = useState([]);

    const { sortedData, sortOptions, handleChanges, 
        handleToggleOrder, setOptions } = useSort(students, filterStudentOptions);

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
        if (!sortedData) return;

        const start = 6 * pageHandler.page;
        const end = (start + 6) > sortedData.length ? 
            sortedData.length : (start + 6);

        const displayedStudents = sortedData.slice(start, end);

        return displayedStudents.map(student =>
            <Student key={student._id} 
                studentInfos={student}
                specs={specsReq.data?.body}
                openStudentModal={openStudentModal}
                deleteStudent={deleteStudent}
            />
        )
    }

    const displayFilterMenu = () => {
        if (!sortOptions) return;
        const {pathways, ...options} = sortOptions;
        return (<FilterMenu sortOptions={options} labels={menuLabels} handleChanges={handleChanges} customInputs={[
            <TableSelect key={'pathways'} name={'pathways'} placeholder={'Filières'}
            tableData={specsReq.data?.body} onChangeValues={onChangePathwaysValues} />
        ]} />)
    }

    const onChangePathwaysValues = (name, values) => setOptions(name, values);

    // Api calls

    const deleteStudent = async studentId => { // Snackbar when delete ?
        const res = await apiRequest('student/student', 'DELETE', { _id: studentId });
        if (res.status === 200) studentsReq.doFetch();
    }

    return (
        <div className="students box-component full-component has-filter">
            {displayStudentModal()}
            <div className="header">
                <h2>Elèves</h2>
                <button className='add-btn' onClick={() => openStudentModal()}>Ajouter</button>
            </div>
            {displayFilterMenu()}
            <DataMenu fields={dataMenuFields} sortedOption={sortOptions.sorted} handleToggleOrder={handleToggleOrder} />
            <div className="data">
                {displayStudents()}
            </div>
            <div className="footer">
                <div className="buttons">
                    <button className='switch-btn' onClick={pageHandler.prevPage} value="-1"><VscChevronLeft/></button>
                    <button className='switch-btn' onClick={pageHandler.nextPage} value="1"><VscChevronRight/></button>
                </div>
                <p className='total'>{sortedData.length + " élèves enregistrés."}</p>
                <p>Page {pageHandler.page + 1} / {pageHandler.maxPage || 1}</p>
            </div>
        </div>
    );
};

const dataMenuFields = [
    { name: 'fname', label: 'PRENOM' },
    { name: 'lname', label: 'NOM' },
    { name: 'age', label: 'AGE' },
    { name: 'gender', label: 'SEXE' },
    { name: 'email', label: 'EMAIL' },
    { name: 'pathways', label: 'FILIERES' },
];

const menuLabels = [
    'Prénom',
    'Nom',
    'Age',
    'Sexe',
    'Email'
];

export default Students;