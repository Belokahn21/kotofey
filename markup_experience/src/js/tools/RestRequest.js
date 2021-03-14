class RestRequest {
    static all(url) {
        return fetch(url).then(response => response.json());
    }

    static one(url, id) {
        return fetch(`${url}${id}/`).then(response => response.json());
    }

    static post(url, options) {
        return fetch(url, {
            method: 'POST',
            ...options
        }).then(response => response.json());
    }

    static delete(url, id) {
        return fetch(`${url}${id}/`, {
            method: 'DELETE',
        }).then(response => response.json());
    }
}

export default RestRequest;