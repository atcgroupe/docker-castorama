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

select.addEventListener('change', () => {
    window.location.href = select.options[select.selectedIndex].dataset.route;
});
