import React, { useState } from 'react';
import { IoClose } from 'react-icons/io5';
import { defaultUser } from '../../utils/model-defaults';
import apiRequest from '../../utils/api-request';
import ErrorMessage from '../ErrorMessage';

const UserForm = ({ userInfos, method, closeModal, onSubmit }) => {

    const [user, setUser] = useState({...userInfos, password: ''} || defaultUser);
    const [error, setError] = useState(null);
    const [warning, setWarning] = useState(null);
    
    const handleChanges = event => 
        setUser({...user, [event.target.name]: event.target.value});

    const handleCloseModal = event => closeModal();

    const handleSubmitForm = async event => {
        event.preventDefault();
        const password = user.password ? user.password : userInfos.password;
        const newUser = (method === 'PUT' ? {...user, password: password} : user);
        const res = await apiRequest('user/user', method, newUser);
        if (!res) return setError("Une erreur est survenue...");
        if (res.status !== 200) {
            res.body?.warning && setWarning(res.body.warning);
            return setError(res.message)
        };
        onSubmit();
        closeModal();
    }

    const displayError = () =>
        (!error) ?
            warning && <ErrorMessage type='warning' message={warning} />
        : <ErrorMessage type={'error'} message={error} />

    const displayTitle = () => method === 'POST' ?
        'Nouvel utilisateur' : (method === 'PUT') ?
        'Modifier un utilisateur' : '';

    return (
        <form className='user-form app-form'>
            <div className="form-header">
                <h2>{displayTitle()}</h2>
                <button onClick={handleCloseModal}><IoClose/></button>
            </div>
            <div className="form-input_row">
                <div className="form-input">
                    <p>PRENOM *</p>
                    <input type="text" name='fname' value={user.fname} onChange={handleChanges} />
                </div>
                <div className="form-input">
                    <p>NOM *</p>
                    <input type="text" name='lname' value={user.lname} onChange={handleChanges} />
                </div>
            </div>
            <div className="form-input_row">
                <div className="form-input">
                    <p>EMAIL *</p>
                    <input type="email" name='email' value={user.email} onChange={handleChanges} />
                </div>
                <div className="form-input">
                    <p>MOT DE PASSE *</p>
                    <input type="text" name='password' placeholder={method === 'PUT' && 'Ancien mot de passe'} 
                    value={user.password} onChange={handleChanges} />
                </div>
            </div>
            {displayError()}
            <div className="form-input">
                <input onClick={handleSubmitForm} name="submit" type="submit" value="Valider"/>
            </div>
        </form>
    );
};

export default UserForm;