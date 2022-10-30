import React, { useEffect, useState } from 'react';
import useFetch from '../../hooks/useFetch';
import { Modal } from 'skz-ui';
import { defaultYear, filterYearOptions } from '../../utils/model-defaults';
import YearForm from './YearForm';
import Year from './Year';
import { VscChevronLeft, VscChevronRight } from 'react-icons/vsc';
import apiRequest from '../../utils/api-request';
import usePagination from '../../hooks/usePagination';
import useSort from '../../hooks/useSort';
import DataMenu from '../DataMenu';
import FilterMenu from '../FilterMenu';

const Years = () => {

    const yearsReq = useFetch('schoolyear/schoolyears');
    const [years, setYears] = useState([]);

    const { sortedData, sortOptions, handleChanges, 
        handleToggleOrder, setOptions } = useSort(years, filterYearOptions);

    const pageHandler = usePagination();

    const [yearModal, setyearModal] = useState({
        year: defaultYear,
        isOpen: false,
        method: 'POST',
        closeModal: () => setyearModal(prev => { return {...prev, isOpen: false}})
    });

    useEffect(() => {
        const body = yearsReq.data?.body;
        if (!body || yearsReq.data?.status !== 200) return;
        setYears(body);
        pageHandler.updateMax(body.length);
    }, [yearsReq.data]);

    useEffect(() => {
        const body = yearsReq.data?.body;
        if (!body) return;
        pageHandler.refreshPage(body.length);
    }, [pageHandler.maxPage]);

    const openYearModal = (year = defaultYear, method = 'POST') =>
        setyearModal({
            ...yearModal,
            isOpen: true,
            year,
            method
        });

    const displayYearModal = () =>
        <Modal 
            open={yearModal.isOpen} 
            onClose={yearModal.closeModal} 
            body={
                <YearForm 
                    yearInfos={yearModal.year}
                    method={yearModal.method}
                    closeModal={yearModal.closeModal}
                    onSubmit={yearsReq.doFetch}
                />
            } 
        />

    const displayYears = () => {
        if (!sortedData) return;

        const start = 6 * pageHandler.page;
        const end = (start + 6) > sortedData.length ? 
            sortedData.length : (start + 6);

        const displayedYears = sortedData.slice(start, end);

        return displayedYears.map(year =>
            <Year key={year._id} 
                yearInfos={year}
                openYearModal={openYearModal}
                deleteYear={deleteYear}
            />
        )
    }

    const displayTotal = () => {
        const len = sortedData.length;
        if (len === 0) return 'Aucune année de formation enregistrée.';
        if (len === 1) return 'Une année de formation enregistrée.';
        if (len > 1) return len + ' années de formation enregistrées.';
    }

    // Api calls

    const deleteYear = async yearId => { // Snackbar when delete ?
        const res = await apiRequest('schoolyear/schoolyear', 'DELETE', { _id: yearId });
        if (res.status === 200) yearsReq.doFetch();
    }

    return (
        <div className="years box-component half-component">
            {displayYearModal()}
            <div className="header">
                <h2>Années de formation</h2>
                <button className='add-btn' onClick={() => openYearModal()}>Ajouter</button>
            </div>
            <DataMenu fields={dataMenuFields} sortedOption={sortOptions.sorted} handleToggleOrder={handleToggleOrder} />
            <div className="data">
                {displayYears()}
            </div>
            <div className="footer">
                <div className="buttons">
                    <button className='switch-btn' onClick={pageHandler.prevPage} value="-1"><VscChevronLeft/></button>
                    <button className='switch-btn' onClick={pageHandler.nextPage} value="1"><VscChevronRight/></button>
                </div>
                <p className='total'>{displayTotal()}</p>
                <p>Page {pageHandler.page + 1} / {pageHandler.maxPage || 1}</p>
            </div>
        </div>
    );
};

const dataMenuFields = [
    { name: 'title', label: 'TITRE' }
];

export default Years;