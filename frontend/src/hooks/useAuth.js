import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import useFetch from './useFetch';

export default function useAuth(needAdmin = false) {
    const authReq = useFetch('auth/isauth/?' + document.cookie);
    const navigate = useNavigate();

    useEffect(() => {
        if (authReq.error) navigate('/login');
        if (!authReq.data?.status) return;
        if (authReq.data.status !== 200) navigate('/login');
        if (needAdmin) {
            const body = authReq.data?.body;
            !body.is_admin && navigate('/login');
        }
    }, [authReq.data, authReq.error]);

    return { refresh: () => authReq.doFetch('auth/isauth/?' + document.cookie) }
}