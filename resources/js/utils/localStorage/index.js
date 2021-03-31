export const setStorageItem = (key, state, data) => {
    localStorage.setItem(key, JSON.stringify(data));
    state[key] = data;
}

export const getStorageItem = (key) => {
    const item = JSON.parse(localStorage.getItem(key));
    return item ? item : null;
}

export const removeStorageItem = (key, state) => {
    localStorage.removeItem(key);
    state[key] = null;
}
