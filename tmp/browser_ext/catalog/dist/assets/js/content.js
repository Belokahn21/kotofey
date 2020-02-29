chrome.runtime.onMessage.addListener(function (request, sender, sendResponse) {
    let name = document.querySelector('h2').textContent;
    var price = document.querySelector('.lead').textContent.match(new RegExp(/(\d+)р./, 'gi')).toString().match(new RegExp(/(\d+)/, 'gi'));
    let article = document.getElementsByTagName('strong')[2].textContent;
    let weight = document.getElementsByTagName('strong')[3].textContent;
    let description = document.querySelector('.desc').textContent;
    let category;

    let url = "http://local.kotofey.store/rest/category/three/";
    // let url = "https://kotofey.store/rest/product/create/";
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/html'
        },
    }).then(function (response) {
        return response.json();
    }).then(function (data) {
        category = data;
    });

    console.log("asddasasddas");

    weight = weight.split(" ");

    switch (weight[1]) {
        case "гр.":
            weight = weight[0] / 1000;
            break;
        default:
            weight = weight[0];
            break;
    }

    const element = {};

    element.name = name;
    element.base_price = Number(price[0]);
    element.purchase = Number(element.base_price);
    element.price = Number(element.purchase) + Number(Math.ceil(element.purchase * 0.30));
    element.article = article;
    element.weight = weight;
    element.description = description;
    element.count = 0;
    element.category = category;

    sendResponse({element: element});
});
