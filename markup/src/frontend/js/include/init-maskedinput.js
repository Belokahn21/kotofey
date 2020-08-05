import Inputmask from "maskedinput";

let russsianPhone = document.querySelector(".js-mask-ru");
if (russsianPhone) {
	let im = new Inputmask("+7 (999) 999 99-99", {placeholder: "+7 (___) ___ __ __"});
	im.mask(russsianPhone);
}