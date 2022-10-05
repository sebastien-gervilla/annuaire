import React, { useCallback, useEffect, useState } from 'react';

export default function useFetch(defUrl, defOptions = {}) {
    const [data, setData] = useState(null);
    const [isLoading, setIsLoading] = useState(false);
    const [url, setUrl] = useState(defUrl);

    const changeDefUrl = (newUrl) => setUrl(newUrl);
    
    const fetch = useCallback(async (url) => {
        const controller = new AbortController();
        const signal = controller.signal;

        setIsLoading(true);
        const options = {
            ...defOptions,
            signal: signal
        };

        try {
            const res = await fetch(url, options);
            setData(res.data);
        } catch (error) {
            console.log("Error while fetching with url : ", url, error);
        } finally {
            setIsLoading(false);
        }
    }, [url])

    const fetchEffet = () => { fetch() };

    useEffect(() => {
        fetchEffet();
    }, []);

    return { data, isLoading, changeDefUrl };
}