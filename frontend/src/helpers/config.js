export const Base_URL = 'http://127.0.0.1:8000/api'

export const headerConfig = (token, contentType) => {
    const config = {
        headers: {
            'Content-Type': contentType || 'application/json',
            "Authorization": `Bearer ${token}`,
        },
    };
    return config;
}


//create unique ref for each product
export const makeUniqueId = (length) => {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
        counter += 1;
    }
    return result;
}