import React, { useState } from 'react';
import { IoClose } from 'react-icons/io5';
import apiRequest from '../utils/api-request';
import { defaultStudent } from '../utils/model-defaults';

const StudentForm = ({ studentInfos = defaultStudent, closeModal }) => {

    const [student, setStudent] = useState(studentInfos);

    const handleChanges = event => 
        setStudent({...student, [event.target.name]: event.target.value});

    const handleChangeAge = event => {
        let age = event.target.value;
        age = (age < 0) ? 0 : age;
        age = (age > 99) ? 99 : age;
        setStudent({...student, [event.target.name]: age});
    }

    const handleCloseModal = event => closeModal();

    const handleSubmitForm = event => {
        event.preventDefault();
        apiRequest('students/student', 'POST', student);
        closeModal();
    }

    return (
        <form className='student-form'>
            <div className="header">
                <h2>Nouvel élève</h2>
                <button onClick={handleCloseModal}><IoClose/></button>
            </div>
            <div className="inputs">
                <div className="names row">
                    <input type="text" name='fname' placeholder='Prénom' value={student.fname} onChange={handleChanges} />
                    <input type="text" name='lname' placeholder='Nom' value={student.lanme} onChange={handleChanges} />
                </div>
                <div className="gender-age row">
                    <select name="gender" placeholder='Genre' value={student.gender} onChange={handleChanges}>
                        <option value="Homme">Homme</option>
                        <option value="Femme">Femme</option>
                    </select>
                    <input type="number" name="age" placeholder='Age' value={student.age} onChange={handleChangeAge} />
                </div>
                <input type="email" name="email" placeholder='Email' value={student.email} onChange={handleChanges} />
                <input type="text" name="number" placeholder='Téléphone' value={student.number} onChange={handleChanges} />
                <input type="text" name='degree' placeholder='Diplome' value={student.degree} onChange={handleChanges}/>
                <button type="submit" onClick={handleSubmitForm}>Valider</button>
            </div>
        </form>
    );
};

export default StudentForm;