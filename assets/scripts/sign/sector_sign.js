const itemsSelects = document.getElementsByClassName('sector-item-select');
const optionSelect = document.getElementById('sector_order_sign_option');
const selectItem2Container = document.getElementById('sector-item2-container');
const previewVersoContainer = document.getElementById('preview-verso-container');
const previewRectoTitle = document.getElementById('preview-recto-title');
const selectItem1Label = document.getElementById('sector-item1-label');
const selectItem2 = document.getElementById('sector_order_sign_item2');

const setTextPreview = (select) => {
    const option = select.options[select.selectedIndex];
    const itemText = document.getElementById(`1-${select.dataset.face}-sector-text`);

    itemText.innerText = (option.value === '') ? '' : option.text;
};

const setPreviewColor = (select) => {
    const form = new FormData();
    form.append('item', select.value);

    fetch(select.dataset.route, {
        method: 'POST',
        body: form
    }).then(function (response) {
        return response.json();
    }).then(function (data) {
        const element = document.getElementById(`1-${select.dataset.face}`);

        switch (data.color) {
            case 'grey':
                element.classList.remove('blue');
                element.classList.add('grey');
                break;
            case 'blue':
                element.classList.remove('grey');
                element.classList.add('blue');
                break;
        }
    });
};

const displayElementsFromOptionValue = (value) => {
    switch (value) {
        case '1':
            selectItem2Container.hidden = true;
            previewVersoContainer.hidden = true;
            previewRectoTitle.innerText = 'Recto/Verso';
            selectItem1Label.innerText = 'Secteur';
            selectItem2.value = '';
            setTextPreview(selectItem2);
            break;
        case '2':
            selectItem2Container.hidden = false;
            previewVersoContainer.hidden = false;
            previewRectoTitle.innerText = 'Recto';
            selectItem1Label.innerText = 'Secteur Recto';
            break;
    }
};

document.addEventListener('DOMContentLoaded', () => {
    Array.from(itemsSelects).forEach((select) => {
        setTextPreview(select);
        setPreviewColor(select);

        select.addEventListener('change', () => {
            setTextPreview(select);
            setPreviewColor(select);
        });
    });

    displayElementsFromOptionValue(optionSelect.value);

    optionSelect.addEventListener('change', () => {
        displayElementsFromOptionValue(optionSelect.value);
    });
});
