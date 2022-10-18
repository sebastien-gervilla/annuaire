import React from 'react';
import useClipboard from '../../hooks/useClipboard';
import useFetch from '../../hooks/useFetch';

const StudentCard = ({ studentInfos, openStudentModal }) => {

    const { setAnchor } = useClipboard();
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

    const handleHoverCopy = event => setAnchor(event.target);

    const handleLeaveCopy = event => setAnchor(null);

    const isActive = (value) => value ? 'active' : '';

    return (
        <div className="student-card">
            <div className="header">
                <h3>Détails</h3>
                <button className='add-btn' onClick={handleEdit}>Modifier</button>
            </div>
            <div className="card_row">
                <div className="info">
                    <p className='field'>PRENOM</p>
                    <p className={isActive(studentInfos?.fname)}>
                        <span onMouseOver={handleHoverCopy} onMouseLeave={handleLeaveCopy}>
                            {studentInfos?.fname}</span>
                    </p>
                </div>
                <div className="info">
                    <p className='field'>NOM</p>
                    <p className={isActive(studentInfos?.lname)}>
                        <span onMouseOver={handleHoverCopy} onMouseLeave={handleLeaveCopy}>
                        {studentInfos?.lname}</span>
                    </p>
                </div>
            </div>
            <div className="card_row">
                <div className="info">
                    <p className='field'>GENRE</p>
                    <p className={isActive(studentInfos?.gender)}>
                        <span onMouseOver={handleHoverCopy} onMouseLeave={handleLeaveCopy}>
                        {studentInfos?.gender}</span>
                    </p>
                </div>
                <div className="info">
                    <p className='field'>AGE</p>
                    <p className={isActive(studentInfos?.age)}>
                        <span onMouseOver={handleHoverCopy} onMouseLeave={handleLeaveCopy}>
                        {studentInfos?.age}</span>
                    </p>
                </div>
            </div>
            <div className="card_row">
                <div className="info">
                    <p className='field'>EMAIL</p>
                    <p className={isActive(studentInfos?.email)}>
                        <span onMouseOver={handleHoverCopy} onMouseLeave={handleLeaveCopy}>
                        {studentInfos?.email}</span>
                    </p>
                </div>
                <div className="info">
                    <p className='field'>TELEPHONE</p>
                    <p className={isActive(studentInfos?.phone || 'Aucun')}>
                        <span onMouseOver={handleHoverCopy} onMouseLeave={handleLeaveCopy}>
                        {studentInfos?.phone || 'Aucun'}</span>
                    </p>
                </div>
            </div>
            <div className="card_row">
                <div className="info">
                    <p className='field'>DIPLOME</p>
                    <p className={isActive(studentInfos?.degree || 'Aucun')}>
                        <span onMouseOver={handleHoverCopy} onMouseLeave={handleLeaveCopy}>
                        {studentInfos?.degree || 'Aucun'}</span>
                    </p>
                </div>
                <div className="info">
                    <p className='field'>ANNEE D'ENTREE</p>
                    <p className={isActive(getIdsValues(schoolYearsReq.data?.body, "entry_years") || 'Aucun')}>
                        <span onMouseOver={handleHoverCopy} onMouseLeave={handleLeaveCopy}>
                        {getIdsValues(schoolYearsReq.data?.body, "entry_years") || 'Aucun'}</span>
                    </p>
                </div>
            </div>
            <div className="card_row fullsize">
                <div className="info">
                    <p className='field'>POTENTIELLES FILIERES</p>
                    <p className={isActive(getIdsValues(specializationsReq.data?.body, "pathways") || 'Aucun')}>
                        <span onMouseOver={handleHoverCopy} onMouseLeave={handleLeaveCopy}>
                        {getIdsValues(specializationsReq.data?.body, "pathways") || 'Aucun'}</span>
                    </p>
                </div>
            </div>
        </div>
    );
};

export default StudentCard;