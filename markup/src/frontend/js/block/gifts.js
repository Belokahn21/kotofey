class gifts {
    constructor() {
        document.querySelector('.js-run-road-gift').addEventListener('click', () => {
        	console.log(document.querySelector('.gifts img'));
            document.querySelector('.gifts img').map((image) => {
                console.log(image);
            });
        });

    }
}

new gifts();

// document.querySelector('.LetsGoClass').addEventListener('click', () => {
//     LetsGo();
// });