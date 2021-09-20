import './../../styles/order/print.scss';

document.addEventListener("DOMContentLoaded", () => {
    const print = document.getElementById('app-signs-print');
    print.addEventListener('click', (event) => {
        window.print();
        event.preventDefault();
    })
});
