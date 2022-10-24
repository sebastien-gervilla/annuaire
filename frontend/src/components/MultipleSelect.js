import React, { useState } from 'react';
import useArray from '../hooks/useArray';
import { IoClose } from 'react-icons/io5';
import { BiChevronDown } from 'react-icons/bi';

const MultipleSelect = ({ name, options, onChangeValues, defaultValues = [], placeholder = '' }) => {

    const values = useArray(defaultValues || []);
    const [openSelect, setOpenSelect] = useState(false);

    const handleClickOption = event => {
        event.preventDefault();
        const newValue = parseInt(event.target.value);

        let newArray = [...values.array];
        if (newArray.includes(newValue))
            newArray.splice(newArray.indexOf(newValue), 1);
        else
            newArray.push(newValue);

        values.set(newArray);
        onChangeValues(name, newArray);
    }

    const handleToggleSelect = event => setOpenSelect(prev => !prev);

    const handleResetValues = event => {
        values.set([]);
        onChangeValues(name, []);
    }

    const displayValues = () => values.array.length > 0 &&
        values.array.map(value => 
            options?.find(option => option.value === value)?.label
        ).join(", ");

    const displayOptions = () => options &&
        options.map(option =>
            <button 
                key={option.value} 
                className={values.array.includes(option.value) ? 'selected' : ''}
                value={option.value}
                onClick={handleClickOption}
            >{option.label}</button>
        );

    return (
        <div className={"multiple-select"}>
            <div className="select-bar" onClick={handleToggleSelect}>
                <p>{displayValues() || placeholder}</p>
            </div>
            <div className="buttons">
                <IoClose className='reset-multiple-select' onClick={handleResetValues} />
                <BiChevronDown className='open-multiple-select' onClick={handleToggleSelect} />
            </div>
            {openSelect &&
                <ul>
                    {displayOptions()}
                </ul>
            }
        </div>
    );
};

export default MultipleSelect;