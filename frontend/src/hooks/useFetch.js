import { useCallback, useEffect, useState } from 'react';

export default function useFetch(defUrl, defOptions = {}) {
    const [data, setData] = useState(null);
    const [error, setError] = useState(null);
    const [isLoading, setIsLoading] = useState(false);
    const [relUrl, setRelUrl] = useState(defUrl);

    const changeRelUrl = (newUrl) => setRelUrl(newUrl);
    
    const fetchFn = useCallback(async (url) => {
        const controller = new AbortController();
        const signal = controller.signal;
        const fullUrl = process.env.REACT_APP_API_PATH + url;

        setIsLoading(true);
        setError(null);
        const options = {
            ...defOptions,
            signal: signal,
            credentials: 'include'
        };

        try {
            const res = await fetch(fullUrl, options);
            const json = await res.json();
            setData(json);
        } catch (error) {
            console.log("Error while fetching with url : ", url, error);
            setError(error);
        } finally {
            setIsLoading(false);
        }
    }, [relUrl]);

    const doFetch = (url = relUrl) => { fetchFn(url) };

    useEffect(() => {
        doFetch();
    }, [relUrl]);

    return { data, error, isLoading, doFetch, changeRelUrl };
}