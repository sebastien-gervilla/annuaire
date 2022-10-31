import React, { useEffect, useState } from 'react';
import useFetch from '../../hooks/useFetch';
import { Modal } from 'skz-ui';
import { defaultSpec, filterSpecOptions } from '../../utils/model-defaults';
import SpecForm from './SpecForm';
import Spec from './Spec';
import { VscChevronLeft, VscChevronRight } from 'react-icons/vsc';
import apiRequest from '../../utils/api-request';
import usePagination from '../../hooks/usePagination';
import useSort from '../../hooks/useSort';
import DataMenu from '../DataMenu';
import FilterMenu from '../FilterMenu';

const Specs = () => {

    const specsReq = useFetch('specialization/specializations');
    const [specs, setSpecs] = useState([]);

    const { sortedData, sortOptions, handleChanges, 
        handleToggleOrder, setOptions } = useSort(specs, filterSpecOptions);

    const pageHandler = usePagination();

    const [specModal, setSpecModal] = useState({
        spec: defaultSpec,
        isOpen: false,
        method: 'POST',
        closeModal: () => setSpecModal(prev => { return {...prev, isOpen: false}})
    });

    useEffect(() => {
        const body = specsReq.data?.body;
        if (!body || specsReq.data?.status !== 200) return;
        setSpecs(body);
        pageHandler.updateMax(body.length);
    }, [specsReq.data]);

    useEffect(() => {
        const body = specsReq.data?.body;
        if (!body) return;
        pageHandler.refreshPage(body.length);
    }, [pageHandler.maxPage]);

    const openSpecModal = (spec = defaultSpec, method = 'POST') =>
        setSpecModal({
            ...specModal,
            isOpen: true,
            spec,
            method
        });

    const displaySpecModal = () =>
        <Modal 
            open={specModal.isOpen} 
            onClose={specModal.closeModal} 
            body={
                <SpecForm 
                    specInfos={specModal.spec}
                    method={specModal.method}
                    closeModal={specModal.closeModal}
                    onSubmit={specsReq.doFetch}
                />
            } 
        />

    const displaySpecs = () => {
        if (!sortedData) return;

        const start = 6 * pageHandler.page;
        const end = (start + 6) > sortedData.length ? 
            sortedData.length : (start + 6);

        const displayedSpecs = sortedData.slice(start, end);

        return displayedSpecs.map(spec =>
            <Spec key={spec._id} 
                specInfos={spec}
                openSpecModal={openSpecModal}
                deleteSpec={deleteSpec}
            />
        )
    }

    const displayTotal = () => {
        const len = sortedData.length;
        if (len === 0) return 'Aucune specialisation enregistrée.';
        if (len === 1) return 'Un specialisation enregistrée.';
        if (len > 1) return len + ' specialisations enregistrées.';
    }

    // Api calls

    const deleteSpec = async specId => { // Snackbar when delete ?
        const res = await apiRequest('specialization/specialization', 'DELETE', { _id: specId });
        if (res.status === 200) specsReq.doFetch();
    }

    return (
        <div className="specs box-component half-component">
            {displaySpecModal()}
            <div className="header">
                <h2>Specialisations</h2>
                <button className='add-btn' onClick={() => openSpecModal()}>Ajouter</button>
            </div>
            <DataMenu fields={dataMenuFields} sortedOption={sortOptions.sorted} handleToggleOrder={handleToggleOrder} />
            <div className="data">
                {displaySpecs()}
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
    { name: 'title', label: 'TITRE' },
    { name: 'color', label: 'COULEUR' },
    { name: 'contrast', label: 'CONTRASTE' }
];

export default Specs;