let formElement = document.querySelector('#filter-form-id');
if (formElement) {
    formElement.addEventListener('submit', () => {
    });


    let inputs = formElement.querySelectorAll('input, select');

    if (inputs) {
        inputs.forEach((element) => {
            element.addEventListener('change', () => {
                console.log('element changed');

                // var url = new URL(location.href),
                //     params = {}
                // Object.keys(params).forEach(key => url.searchParams.append(key, params[key]))
                //
                // fetch(url, {
                //     method: 'GET',
                // });

                var url = new URL(location.href)

                var params = {lat:35.696233, long:139.570431} // or:
                var params = [['lat', '35.696233'], ['long', '139.570431']]

                url.search = new URLSearchParams(params).toString();

                fetch(url)

            });
        })
    }
}