export const uploadFile = (file) => {
    const formData = new FormData();
    formData.append('file', file);
    return new Promise((resolve, reject) => {
        const config = { headers: { 'Content-Type': 'multipart/form-data' } };
        axios.post('/api/files/upload', formData, config)
        .then(response => {
            resolve(response);
        })
        .catch(error => {
            reject(error);
        })
    })
}
