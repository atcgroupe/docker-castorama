/* Order list management */

/* data-list */
import * as List from 'list.js';

const dataListTable = document.getElementById('data-list-table');

if (dataListTable !== null) {
    const options = {
        valueNames: ['shop', 'number', 'customerReference', 'title', 'member', 'delivery', 'status']
    }

    const dataList = new List('data-list', options);
}

/* Shop user filter */
const select = document.getElementById('app-shop-user');

if (select !== null) {
    select.addEventListener('change', () => {
        window.location.href = select.options[select.selectedIndex].dataset.route;
    });
}

/* Table edit link */
const tableItems = document.getElementsByClassName('data-list-item');

Array.from(tableItems).forEach((element) => {
    element.addEventListener('click', () => {
        window.location.href = element.dataset.route;
    })
});
