import React from 'react';
import { FiChevronDown } from 'react-icons/fi';

const DataMenu = ({ fields, sortedOption, handleToggleOrder }) => {

    const displayLabels = () => fields?.length > 0 &&
        fields.map(field =>
            <div key={field.name} className={'field ' + field.name}>
                <p>{field.label}</p>
                <button onClick={handleToggleOrder} name={field.name}>
                    <FiChevronDown className={
                        sortedOption?.field === field.name &&
                        ((sortedOption?.isAsc && 'asc') || (sortedOption?.isAsc === false && 'desc'))
                    } />
                </button>
            </div>
        )

    return (
        <div className="data-menu">
            {displayLabels()}
            <div className='menu_buttons placeholder'>PLUS</div>
        </div>
    );
};

export default DataMenu;