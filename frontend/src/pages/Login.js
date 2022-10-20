import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import ErrorMessage from '../components/ErrorMessage';
import apiRequest from '../utils/api-request';
import { defaultUser } from '../utils/model-defaults';

const Login = () => {

    const navigate = useNavigate();

    const [user, setUser] = useState(defaultUser);
    const [error, setError] = useState(null);

    const handleChangeUser = event => 
        setUser({...user, [event.target.name]: event.target.value});

    const handleSubmitForm = async event => {
        event.preventDefault();
        const res = await apiRequest('auth/login', 'POST', user);
        if (res?.status && res.status !== 200) return setError(res.message);
        if (res && res.status === 200 && res.body?.token) {
            document.cookie = "token=" + res.body.token;
            navigate('/');
        };
    }

    const displayError = () => error &&
        <ErrorMessage type={'error'} message={error} />

    return (
        <section id="login-page">
            <div className="login-area">
                <div className="login-content">
                    <form className='app-form'>
                        <div className="form-header">
                            <h2>Se connecter</h2>
                        </div>
                        <div className="form-input">
                            <p>EMAIL</p>
                            <input onChange={handleChangeUser} name="email" type="email" />
                        </div>
                        <div className="form-input">
                            <p>MOT DE PASSE</p>
                            <input onChange={handleChangeUser} name="password" type="password" />
                        </div>
                        {displayError()}
                        <div className="form-input">
                            <input onClick={handleSubmitForm} name="submit" type="submit" value="Valider"/>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    );
};

export default Login;