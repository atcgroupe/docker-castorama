/* Displays app flash alerts */

import { Toast } from "bootstrap";

Array.from(document.getElementsByClassName('toast')).forEach((toastElm) => {
    const delay = Number(toastElm.dataset.delay);
    const autohide = Boolean(toastElm.dataset.autohide);
    const toast = new Toast(toastElm, {'autohide': autohide, 'delay': delay});

    toast.show();
});
