import React from 'react';
import { BiReset, BiChevronsRight } from 'react-icons/bi';
import useArray from '../hooks/useArray';

const TransferSelect = ({ data, onChangeValues, defaultValues = [] }) => {

    const selected = useArray(defaultValues);

    const handleSelect = event => {
        const id = parseInt(event.target.value);
        const newValue = data?.find(el => el._id === id);

        if (!newValue) return;

        selected.push(newValue);
        onChangeValues('', [...selected.array, newValue]);
    }

    const handleUnselect = event => {
        const id = parseInt(event.target.value);
        const newValue = data?.find(el => el._id === id);

        if (!newValue) return;

        const index = selected.array.map(el => el._id).indexOf(id);
        selected.remove(index);
        onChangeValues('', selected.array.slice(index, 1));
    }

    const handleReset = event => selected.clear();

    const handleSelectAll = event => selected.set(data);

    const displayData = () => data && data
        .filter(element => !selected.array.find(el => el._id === element._id))
        .map(element =>
            <button key={element._id}
                type='button' 
                value={element._id}
                className='row' 
                onClick={handleSelect}>
                {element.title}
            </button>
        );

    const displaySelected = () => selected.array && selected.array
        .map(element =>
            <button key={element._id} 
                type='button'
                value={element._id}
                className='row' 
                onClick={handleUnselect}>
                {element.title}
            </button>
        );

    return (
        <div className="transfer-select">
            <div className="unselected list">
                <div className="header">
                    <p>Disponibles</p>
                    <button type='button' onClick={handleReset}><BiReset /></button>
                </div>
                <div className="rows">
                    {displayData()}
                </div>
            </div>
            <div className="selected list">
                <div className="header">
                    <p>Sélectionnés</p>
                    <button type='button' onClick={handleSelectAll}><BiChevronsRight /></button>
                </div>
                <div className="rows">
                    {displaySelected()}
                </div>
            </div>
        </div>
    );
};

export default TransferSelect;