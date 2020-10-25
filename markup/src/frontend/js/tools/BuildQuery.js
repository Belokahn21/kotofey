class BuildQuery {
    static format(form) {

        const formData = new FormData(form);
        const data = [...formData.entries()];
        const asString = data.map(x => `${encodeURIComponent(x[0])}=${encodeURIComponent(x[1])}`).join('&');
        return asString;
    }
}

module.exports = BuildQuery;