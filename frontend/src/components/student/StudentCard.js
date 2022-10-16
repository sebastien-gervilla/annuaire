import React from 'react';
import useFetch from '../../hooks/useFetch';

const StudentCard = ({ studentInfos, openStudentModal }) => {

    const schoolYearsReq = useFetch('schoolyear/schoolyears');
    const specializationsReq = useFetch('specialization/specializations');

    const getIdsValues = (table, field) => studentInfos && table && 
        studentInfos[field].map(id => {
            const row = table.find(row => row._id === id);
            return row ? row.title : '';
        }).join(' / ');

    const handleEdit = (event) => {
        event.preventDefault();
        openStudentModal(studentInfos);
    };

    return (
        <div className="student-card">
            <div className="header">
                <h3>Détails</h3>
                <button className='add-btn' onClick={handleEdit}>Modifier</button>
            </div>
            <div className="card_row">
                <div className="info">
                    <p className='field'>PRENOM</p>
                    <p>{studentInfos?.fname}</p>
                </div>
                <div className="info">
                    <p className='field'>NOM</p>
                    <p>{studentInfos?.lname}</p>
                </div>
            </div>
            <div className="card_row">
                <div className="info">
                    <p className='field'>GENRE</p>
                    <p>{studentInfos?.gender}</p>
                </div>
                <div className="info">
                    <p className='field'>AGE</p>
                    <p>{studentInfos?.age}</p>
                </div>
            </div>
            <div className="card_row">
                <div className="info">
                    <p className='field'>EMAIL</p>
                    <p>{studentInfos?.email}</p>
                </div>
                <div className="info">
                    <p className='field'>TELEPHONE</p>
                    <p>{studentInfos?.phone || 'Aucun'}</p>
                </div>
            </div>
            <div className="card_row">
                <div className="info">
                    <p className='field'>DIPLOME</p>
                    <p>{studentInfos?.degree || 'Aucun'}</p>
                </div>
                <div className="info">
                    <p className='field'>ANNEE D'ENTREE</p>
                    <p>{getIdsValues(schoolYearsReq.data?.body, "entry_years") || 'Aucun'}</p>
                </div>
            </div>
            <div className="card_row fullsize">
                <div className="info">
                    <p className='field'>POTENTIELLES FILIERES</p>
                    <p>{getIdsValues(specializationsReq.data?.body, "pathways") || 'Aucun'}</p>
                </div>
            </div>
        </div>
    );
};

export default StudentCard;