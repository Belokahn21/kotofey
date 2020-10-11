import Number from '../tools/Number';

class LiveSearch {
    constructor(selector) {
        this.elements = document.querySelectorAll(selector);
        this.oldPlaceholder = "";
        this.bankPhrases = ["Роял канин для котят", "Acana Wild Prarie", "Влажный корм", "Лакомства"];

        if (!this.elements) {
            return false;
        }

        this.init();

    }

    init() {
        this.elements.forEach((element) => {
            element.setAttribute('placeholder', "");
            document.addEventListener('DOMContentLoaded', () => {
                this.typing(element, this.bankPhrases[Number.getRandom(0, this.bankPhrases.length)]);
            });

        });
    }

    typing(element, phrase, timer = null) {
        if (timer) {
            clearTimeout(timer);
        }
        timer = setTimeout(() => {
            let placeholder = element.getAttribute('placeholder');
            let letter = phrase[placeholder.length];
            element.setAttribute('placeholder', placeholder + letter);

            if (placeholder.length + 1 < phrase.length) {
                this.typing(element, phrase, timer);
            }

            clearTimeout(timer);
        }, this.getRandomInt(250 * 2.5))
    }

    getRandomInt(max) {
        return Math.floor(Math.random() * Math.floor(max));
    }
}

module.exports = LiveSearch;