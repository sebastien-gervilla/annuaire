import React from 'react';
import MultipleSelect from './MultipleSelect';

const TableSelect = ({ name, tableData, onChangeValues, defaultValues = [], placeholder = '' }) => {

    const getOptions = () => tableData &&
        tableData.map(row => {
            return {
                value: row._id,
                label: row.title
            }
        });

    return (
        <MultipleSelect 
            name={name}
            options={getOptions()}
            onChangeValues={onChangeValues}
            defaultValues={defaultValues}
            placeholder={placeholder}
        />
    );
};

export default TableSelect;