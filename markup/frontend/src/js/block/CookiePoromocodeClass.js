import * as Cookies from "es-cookie";

export default class CookiePoromocodeClass {

    constructor() {
        this.COOKIE_KEY_CODE = 'promocode';
    }

    save(code, discount) {
        Cookies.set(this.COOKIE_KEY_CODE, JSON.stringify({
            code: code,
            discount: discount,
        }));
    }

    getPromocode() {
        try {
            return JSON.parse(Cookies.get(this.COOKIE_KEY_CODE));
        } catch (e) {
            return null;
        }
    }

    delete(code) {
        Cookies.remove(this.COOKIE_KEY_CODE);
    }
}