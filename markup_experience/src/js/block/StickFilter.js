class StickFilter {
    constructor(catalog = null) {

        this.element = document.querySelectorAll('.js-stick-filter');
        this.filter = document.querySelector('.filter-catalog');
        this.catalog = catalog;

        this.initEvents();
    }

    initEvents() {

        if (!this.element) {
            return false;
        }

        if (!this.filter) {
            return false;
        }

        this.element.forEach((foreachElement) => {

            foreachElement.addEventListener('click', (event) => {
                let element = event.target;

                if (foreachElement !== element) {
                    element = element.parentElement;
                }

                if (this.catalog !== null) {
                    this.catalog.show();
                }

                this.filter.scrollIntoView();
            });
        });

        // window.addEventListener('scroll', () => {
        //     if (this.element) {
        //         this.element.forEach((foreachElement) => {
        //             if (foreachElement.offsetTop) {
        //                 console.log(foreachElement.offsetTop);
        //             }
        //         });
        //     }
        // });
    }
}

export default StickFilter;