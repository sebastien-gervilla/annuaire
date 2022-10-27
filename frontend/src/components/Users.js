import React, { useEffect, useState } from 'react';
import useFetch from '../hooks/useFetch';
import { Modal } from 'skz-ui';
import { defaultUser, filterUserOptions } from '../utils/model-defaults';
import UserForm from './user/UserForm';
import User from './User';
import { VscChevronLeft, VscChevronRight } from 'react-icons/vsc';
import apiRequest from '../utils/api-request';
import usePagination from '../hooks/usePagination';
import useSort from '../hooks/useSort';
import DataMenu from './DataMenu';
import FilterMenu from './FilterMenu';

const Users = () => {

    const usersReq = useFetch('user/users');
    const [users, setUsers] = useState([]);

    const { sortedData, sortOptions, handleChanges, 
        handleToggleOrder, setOptions } = useSort(users, filterUserOptions);

    const pageHandler = usePagination();

    const [userModal, setUserModal] = useState({
        user: defaultUser,
        isOpen: false,
        method: 'POST',
        closeModal: () => setUserModal(prev => { return {...prev, isOpen: false}})
    });

    useEffect(() => {
        const body = usersReq.data?.body;
        if (!body || usersReq.data?.status !== 200) return;
        setUsers(body);
        pageHandler.updateMax(body.length);
    }, [usersReq.data]);

    useEffect(() => {
        const body = usersReq.data?.body;
        if (!body) return;
        pageHandler.refreshPage(body.length);
    }, [pageHandler.maxPage]);

    const openUserModal = (user = defaultUser, method = 'POST') =>
        setUserModal({
            ...userModal,
            isOpen: true,
            user,
            method
        });

    const displayUserModal = () =>
        <Modal 
            open={userModal.isOpen} 
            onClose={userModal.closeModal} 
            body={
                <UserForm 
                    userInfos={userModal.user}
                    method={userModal.method}
                    closeModal={userModal.closeModal}
                    onSubmit={usersReq.doFetch}
                />
            } 
        />

    const displayUsers = () => {
        if (!sortedData) return;

        const start = 6 * pageHandler.page;
        const end = (start + 6) > sortedData.length ? 
            sortedData.length : (start + 6);

        const displayedUsers = sortedData.slice(start, end);

        return displayedUsers.map(user =>
            <User key={user._id} 
                userInfos={user}
                openUserModal={openUserModal}
                deleteUser={deleteUser}
            />
        )
    }

    const displayTotal = () => {
        const len = sortedData.length;
        if (len === 0) return 'Aucun utilisateur enregistré.';
        if (len === 1) return 'Un utilisateur enregistré.';
        if (len > 1) return len + ' utilisateurs enregistrés.';
    }

    // Api calls

    const deleteUser = async userId => { // Snackbar when delete ?
        const res = await apiRequest('user/user', 'DELETE', { _id: userId });
        if (res.status === 200) usersReq.doFetch();
    }

    return (
        <div className="users box-component full-component">
            {displayUserModal()}
            <div className="header">
                <h2>Utilisateurs</h2>
                <button className='add-btn' onClick={() => openUserModal()}>Ajouter</button>
            </div>
            <FilterMenu sortOptions={sortOptions} labels={menuLabels} handleChanges={handleChanges} />
            <DataMenu fields={dataMenuFields} sortedOption={sortOptions.sorted} handleToggleOrder={handleToggleOrder} />
            <div className="data">
                {displayUsers()}
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
    { name: 'fname', label: 'PRENOM' },
    { name: 'lname', label: 'NOM' },
    { name: 'email', label: 'EMAIL' }
];

const menuLabels = [
    'Prénom',
    'Nom',
    'Email'
];

export default Users;