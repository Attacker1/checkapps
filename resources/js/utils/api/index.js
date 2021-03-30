export const apiConfig = (method, params, httpMethod = 'post') => {
    const data = JSON.stringify({
        'jsonrpc': '2.0',
        'method': method,
        'params': params
    });

    return {
        method: httpMethod,
        headers: {
            'Content-Type': 'application/json',
            'X-API-Key': process.env.VUE_APP_API_KEY,
            'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE',
            'Access-Control-Allow-Headers': 'Authorization',
            'Access-Control-Allow-Origin' : '*',
            'Accept-Language': 'en',
        },
        data: data,
    };
}
