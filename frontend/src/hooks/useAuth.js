import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import useFetch from './useFetch';

export default function useAuth() {
    const authReq = useFetch('auth/isauth/?' + document.cookie);
    const navigate = useNavigate();

    useEffect(() => {
        console.log(authReq);
        console.log(document.cookie);
        if (!authReq.data?.status) return;
        if (authReq.data.status !== 200) navigate('/login');
    }, [authReq.data]);

    return { refresh: () => authReq.doFetch('auth/isauth/?' + document.cookie) }
}