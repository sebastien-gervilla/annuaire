import React, { useEffect } from 'react';
import useFetch from '../hooks/useFetch';

const Students = () => {

    const studentsReq = useFetch('students/students');

    useEffect(() => console.log(studentsReq.data), [studentsReq]);

    return (
        <div className="students">
            <div className="header">
                <h2>Students</h2>
                <button>Ajouter</button>
            </div>
            <div className="data">

            </div>
            <div className="footer">

            </div>
        </div>
    );
};

export default Students;