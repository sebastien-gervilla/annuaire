export default async function apiRequest(relUrl, method, data = null, options = {}) {
    const fullUrl = process.env.REACT_APP_API_PATH + relUrl;

    try {
        const body = JSON.stringify(data);
        const res = await fetch(fullUrl, {...options, body, method});
        return await res.json();
    } catch (error) {
        console.log("Error while fetching with url : ", fullUrl, error);
    }
}