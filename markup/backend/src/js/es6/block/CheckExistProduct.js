class CheckExistProduct {
    constructor() {
        this.button = document.querySelectorAll('.js-check-exist-product');
        this.addEvent();
    }

    addEvent() {
        if (!this.button) {
            return false;
        }

        this.button.forEach((forEachElement) => {
            forEachElement.addEventListener('click', (event) => {
                let element = event.target;

                if (forEachElement !== element) {
                    element = element.parentElement;
                }

                const externalCode = element.getAttribute('data-code');
                const vendorId = element.getAttribute('data-vendor-id');
                let i = element.querySelector('i');

                fetch(location.protocol + '//' + location.hostname + '/ajax/exist/', {
                    method: 'POST',
                    body: JSON.stringify({
                        'code': externalCode,
                        'vendorId': vendorId,
                    })
                }).then(response => response.json()).then(data => {
                    if (data === "true") {
                        i.classList.replace('far', 'fas');
                        i.classList.replace('fa-question-circle', 'fa-check');
                    } else {
                        i.classList.replace('far', 'fas');
                        i.classList.replace('fa-question-circle', 'fa-times');
                    }
                });


            });
        });
    }


}

new CheckExistProduct();