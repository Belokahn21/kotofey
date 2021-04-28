import Inputmask from "maskedinput";

document.addEventListener('DOMContentLoaded', () => {
    let russsianPhone = document.querySelectorAll(".js-mask-ru");

    if (russsianPhone) {
        russsianPhone.forEach(el => {
            let im = new Inputmask("+7 (999) 999 99-99", {placeholder: "+7 (___) ___ __ __"});
            im.mask(el);
        });
    }

//     let russsianPhone = document.querySelector(".js-mask-ru");
//     if (russsianPhone) {
//         let im = new Inputmask("+7 (999) 999 99-99", {placeholder: "+7 (___) ___ __ __"});
//         im.mask(russsianPhone);
//     }
});
