let notify = document.querySelector('.notify');
const timeout = 3500;

if (notify) {
    setTimeout(() => {
        notify.remove();
    }, timeout);
}