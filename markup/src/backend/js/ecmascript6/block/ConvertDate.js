class ConvertDate {

    format(unix) {
        var date = new Date(unix);
        return date.getDate() + ":" + (date.getMonth() + 1) + ":" + date.getFullYear();
    }
}

module.exports = ConvertDate;