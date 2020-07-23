let formElement = document.querySelector('#filter-form-id');
if (formElement) {
    formElement.addEventListener('submit', () => {
    });


    let inputs = formElement.querySelectorAll('input, select');

    if (inputs) {
        inputs.forEach((element) => {
            element.addEventListener('change', () => {
                console.log('element changed');
            });
        })
    }
}