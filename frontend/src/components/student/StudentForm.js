import React, { useState } from 'react';
import { IoClose } from 'react-icons/io5';
import useFetch from '../../hooks/useFetch';
import apiRequest from '../../utils/api-request';
import { defaultStudent } from '../../utils/model-defaults';
import TableSelect from '../TableSelect';

const StudentForm = ({ studentInfos, method, closeModal, onSubmit }) => {

    const eventsReq = useFetch("event/events");
    const schoolYearsReq = useFetch("schoolyear/schoolyears");
    const specializationsReq = useFetch("specialization/specializations");

    const [student, setStudent] = useState(studentInfos || defaultStudent);
    const [error, setError] = useState(null);
    
    const handleChanges = event => 
        setStudent({...student, [event.target.name]: event.target.value});

    const handleChangeAge = event => {
        let age = event.target.value;
        age = (age < 0) ? 0 : age;
        age = (age > 99) ? 99 : age;
        setStudent({...student, [event.target.name]: age});
    }
    
    const onChangeSelectValues = (name, values) =>
        setStudent(prev => { 
            return {
                ...prev, 
                [name]: [...values]
            }
        });
        
    const handleCloseModal = event => closeModal();

    const handleSubmitForm = async event => {
        event.preventDefault();
        const res = await apiRequest('student/student', method, student);
        if (res.status !== 200) return setError(res.message);
        onSubmit();
        closeModal();
    }

    const displayError = () => error &&
        <p>{error}</p>

    return (
        <form className='student-form app-form'>
            <div className="form-header">
                <h2>Nouvel élève</h2>
                <button onClick={handleCloseModal}><IoClose/></button>
            </div>
            <div className="form-input_row">
                <div className="form-input">
                    <p>PRENOM *</p>
                    <input type="text" name='fname' value={student.fname} onChange={handleChanges} />
                </div>
                <div className="form-input">
                    <p>NOM *</p>
                    <input type="text" name='lname' value={student.lname} onChange={handleChanges} />
                </div>
            </div>
            <div className="form-input_row">
                <div className="form-input_row">
                    <div className="form-input">
                        <p>GENRE *</p>
                        <select name="gender" className='form-select' value={student.gender} onChange={handleChanges}>
                            <option value="Homme">Homme</option>
                            <option value="Femme">Femme</option>
                        </select>
                    </div>
                    <div className="form-input">
                        <p>AGE *</p>
                        <input type="number" name="age" value={student.age} onChange={handleChangeAge} />
                    </div>
                </div>
                <div className="form-input">
                    <p>EMAIL *</p>
                    <input type="email" name='email' value={student.email} onChange={handleChanges} />
                </div>
            </div>
            <div className="form-input_row">
                <div className="form-input">
                    <p>TELEPHONE</p>
                    <input type="text" name='phone' value={student.phone} onChange={handleChanges} />
                </div>
                <div className="form-input">
                    <p>DIPLOME</p>
                    <input type="text" name='degree' value={student.degree} onChange={handleChanges} />
                </div>
            </div>
            <div className="form-input">
                <p>ANNEE D'ENTREE</p>
                <TableSelect name={'entry_years'} 
                    tableData={schoolYearsReq.data?.body} 
                    onChangeValues={onChangeSelectValues}
                    defaultValues={student.entry_years} />
            </div>
            <div className="form-input">
                <p>POTENTIELLE SPECIALISATION</p>
                <TableSelect name={'pathways'} 
                    tableData={specializationsReq.data?.body} 
                    onChangeValues={onChangeSelectValues}
                    defaultValues={student.pathways} />
            </div>
            <div className="form-input">
                <p>PARTICIPATIONS</p>
                <TableSelect name={'participations'} 
                    tableData={eventsReq.data?.body} 
                    onChangeValues={onChangeSelectValues}
                    defaultValues={student.participations} />
            </div>
            {displayError()}
            <div className="form-input">
                <input onClick={handleSubmitForm} name="submit" type="submit" value="Valider"/>
            </div>
        </form>
    );
};

export default StudentForm;