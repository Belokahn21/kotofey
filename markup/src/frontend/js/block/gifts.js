class gifts {
    constructor() {
        let element = document.querySelector('.js-run-road-gift');

        if (!element) {
            return false;
        }

        element.addEventListener('click', () => {
            console.log(document.querySelector('.gifts img'));
            document.querySelector('.gifts img').map((image) => {
                console.log(image);
            });
        });

    }
}

new gifts();