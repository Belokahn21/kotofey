class Gifts {
    constructor() {
        this.lastWidth = 0;
        this.step = 120;
        this.fullWidth = 0;
        this.intervelId = null;
        this.button = document.querySelector('.js-run-road-gift');
        this.images = document.querySelectorAll('.gifts-road__image');

        this.getFullWidth();

        this.addEvents();
        this.stayImages();
    }

    addEvents() {
        if (!this.button) {
            return false;
        }

        const speed = this.button.getAttribute('data-speed') ? this.button.getAttribute('data-speed') : 1000;

        this.button.addEventListener('click', () => {
            setInterval(() => {
                this.stayImages();
            }, speed);
        });
    }

    stayImages() {
        this.images.forEach((image) => {
            image.style.left = this.lastWidth + 'px';
            this.lastWidth += this.step;
        });
    }

    getFullWidth() {
        this.fullWidth = this.images.length * this.step;
    }
}

new Gifts();