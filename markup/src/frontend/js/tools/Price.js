class Price {
    static format(price) {
        return new Intl.NumberFormat('ru-RU').format(price);
    }
}

module.exports = Price;