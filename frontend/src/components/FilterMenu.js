import React from 'react';

const FilterMenu = ({ sortOptions, labels, handleChanges, customInputs = [] }) => {

    const displayInputs = () => {
        if (!sortOptions) return;
        const {sorted, ...filterOptions} = sortOptions;
        return Object.entries(filterOptions).map(([field, value], index) =>
            <div key={field} className={"filter-input " + field}>
                <input 
                    placeholder={labels[index]} 
                    name={field} 
                    value={value} 
                    type="text"
                    onChange={handleChanges}
                />
            </div> 
        );
    }

    return (
        <div className="filter-menu">
            {displayInputs()}
            {customInputs}
        </div>
    );
};

export default FilterMenu;