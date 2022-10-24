import React, { useEffect, useState } from "react";

export default function useSort(data = [], defaultOptions = {}) {
    const [sortOptions, setSortOptions] = useState(defaultOptions);
    const [sortedData, setSortedData] = useState(data);

    const handleChanges = event => event.target && setSortOptions({
        ...sortOptions, [event.target.name]: event.target.value
    });

    const setOptions = (option, value) => option && setSortOptions({
        ...sortOptions, [option]: value
    });

    const handleToggleOrder = event => event.currentTarget && setSortOptions({
        ...sortOptions, sorted: {
            field: event.currentTarget.name,
            isAsc: sortOptions.sorted?.field === event.currentTarget.name ?
                !sortOptions.sorted.isAsc : true
        }
    });

    useEffect(() => {
        const { sorted, ...filterOptions } = sortOptions;
        setSortedData(
            data.filter(el =>
                !Object.entries(el).find(([field, value]) => 
                    filterOptions[field] && !doesMatchFilter(value, filterOptions[field])
                )
            ).sort((prev, curr) => 
                (prev[sorted.field] > curr[sorted.field]) ?
                    (sorted.isAsc ? 1 : -1) : (!sorted.isAsc ? 1 : -1)
            )
        );
    }, [sortOptions]);

    useEffect(() => { setSortedData(data); }, [data]);

    return { sortedData, sortOptions, handleChanges, handleToggleOrder, setOptions };
}

const doesMatchFilter = (value, filterValue) => {
    if (typeof value === 'string' && typeof filterValue === 'string') 
        return value.toLowerCase().includes(filterValue.toLowerCase());
    if (typeof value === 'number')
        return value.toString().includes(filterValue.toString());
    if (Array.isArray(value) && Array.isArray(filterValue))
        return filterValue.every(val => value.includes(val));
}