class ConvertDate {

    format(unix) {
        var date = new Date(unix * 1000);
        return date.toLocaleDateString();
    }
}

export default ConvertDate;