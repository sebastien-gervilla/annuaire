import React from 'react';
import { AiFillDelete } from 'react-icons/ai';
import { TbEdit } from 'react-icons/tb';

const Student = ({ studentInfos }) => {

    const { fname, lname, age, gender, email, phone, degree} = studentInfos;

    return (
        <div className="student">
            <p className='fname'>{fname}</p>
            <p className='lname'>{lname}</p>
            <p className='age'>{age}</p>
            <p className='gender'>{gender}</p>
            <p className='email'>{email}</p>
            <p className='phone'>{phone}</p>
            <p className='degree'>{degree}</p>

            <div className="menu_buttons">
                <TbEdit className='edit-btn_icon' />
                <AiFillDelete className='del-btn_icon' />
            </div>
        </div>
    );
};

export default Student;