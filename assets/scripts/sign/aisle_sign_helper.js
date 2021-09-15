import {FormHelper} from "../app/form_helper";
import $ from 'jquery';

export const AisleSignHelper = {
    SetPreviewNumbers: (value) => {
        const aisleNumbers = document.getElementsByClassName('aisle-number-value');

        Array.from(aisleNumbers).forEach((aisleNumber) => {
            aisleNumber.innerHTML = value;
        })
    },
    setPreviewText: () => {
        const itemsSelects = document.getElementsByClassName('item_select');
        const itemsText = document.getElementsByClassName('items_text');
        let text = '';
        let i = 0;

        Array.from(itemsSelects).forEach((select) => {
            let option = select.options[select.selectedIndex];
            if (typeof option !== 'undefined' && option.value !== '') {
                if (i > 0) text += '<br />';
                text += option.text;
            }
            i++;
        })

        Array.from(itemsText).forEach((label) => {
            label.innerHTML = text;
        });
    },
    setPreviewImages: (itemSelect) => {
        const checkbox = $(itemSelect).closest('.item-container').find('input[type="checkbox"]');
        const route = itemSelect.dataset.route;
        const form = new FormData();
        form.append('itemId', itemSelect.value);
        form.append('hideImage', checkbox.is(':checked'));
        fetch(route, {
            method: 'POST',
            body: form
        }).then(function (response) {
            return response.json();
        }).then(function (image) {
            const itemNumber = itemSelect.dataset.item;
            const images = document.getElementsByClassName(`picto${itemNumber}-img`)

            Array.from(images).forEach((picto) => {
                picto.setAttribute('src', image.name)
            });
        });
    },
    setItemSelectsAttributes: (dataSelect, targetItemSelect, targetCategorySelect, targetCheckbox) => {
        const option = dataSelect.options[dataSelect.selectedIndex];

        if (typeof option === 'undefined' || option.text === '') {
            targetCategorySelect.setAttribute('disabled', 'disabled');
            targetCategorySelect.value = '';
            targetItemSelect.setAttribute('disabled', 'disabled');
            targetItemSelect.value = '';
            targetItemSelect.text = '';
            targetCheckbox.setAttribute('disabled', 'disabled');
            $(targetCheckbox).prop('checked', false);
        } else {
            targetCategorySelect.removeAttribute('disabled');
            targetItemSelect.removeAttribute('disabled');
            targetCheckbox.removeAttribute('disabled');
        }
    },
    setItemsSelectsStatusFromParent: () => {
        const itemOneSelect = document.getElementById('aisle_order_sign_item1');
        const itemTwoSelect = document.getElementById('aisle_order_sign_item2');
        const itemThreeSelect = document.getElementById('aisle_order_sign_item3');
        const categoryTwoSelect = document.getElementById(`aisle_order_sign_category2`);
        const categoryThreeSelect = document.getElementById(`aisle_order_sign_category3`);
        const itemTwoCheckbox = document.getElementById(`aisle_order_sign_hideItem2Image`);
        const itemThreeCheckbox = document.getElementById(`aisle_order_sign_hideItem3Image`);

        AisleSignHelper.setItemSelectsAttributes(itemOneSelect, itemTwoSelect, categoryTwoSelect, itemTwoCheckbox);
        AisleSignHelper.setItemSelectsAttributes(itemTwoSelect, itemThreeSelect, categoryThreeSelect, itemThreeCheckbox);
        AisleSignHelper.setPreviewImages(itemTwoSelect);
        AisleSignHelper.setPreviewImages(itemThreeSelect);
    },
    setSelectItemsFromCategory: (categorySelect) => {
        const value = categorySelect.value;
        const itemSelect = document.getElementById(categorySelect.dataset.cible);
        const route = categorySelect.dataset.route;
        const form = new FormData();
        form.append('category', value)

        fetch(route, {
            method: 'POST',
            body: form
        }).then(function (response){
            return response.json();
        }).then(function (data) {
            FormHelper.setSelectOptions(itemSelect, data);
            AisleSignHelper.setItemsSelectsStatusFromParent();
            AisleSignHelper.setPreviewText()
            AisleSignHelper.setPreviewImages(itemSelect);
        });
    }
}
