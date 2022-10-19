import React from 'react';
import { BiErrorAlt, BiError } from 'react-icons/bi';

const ErrorMessage = ({ type, message }) => {

    const diplayErrorIcon = () => {
        if (type === 'error')
            return <BiErrorAlt />
        if (type === 'warning')
            return <BiError /> 
    }

    return (
        <div className={"error-msg" + (type ? (' ' + type) : '')} >
            <div className="wrapper">
                {diplayErrorIcon()}
                <p>{message}</p>
            </div>
        </div>
    );
};

export default ErrorMessage;