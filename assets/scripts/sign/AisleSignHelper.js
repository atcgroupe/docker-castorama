import $ from 'jquery';
import {FormHelper} from "../app/form_helper";

export class AisleSignHelper {
    constructor(formName) {
        this.formName = formName;
        this.isSmall = (formName.search('small') !== -1);
        this.maxAisleNumber = 999;
        this.minStretchAisleNumber = 200;
        this.aisleNumberInput = document.getElementById(`${formName}_aisleNumber`);
        this.itemsCategory = document.getElementById(`${formName}_category`);
        this.previewAisleNumbers = document.getElementsByClassName('aisle-number-value');
        this.itemsText = document.getElementsByClassName('items_text');
        this.itemsSelects = document.getElementsByClassName('item_select');
        this.itemsCheckboxes = document.getElementsByClassName('item_checkbox');

        this.refreshSignPreview();

        this.addAisleNumberListener();
        this.addCategoryListener();
        this.addItemsSelectsListeners();
        if (!this.isSmall) this.addCheckBoxesListeners();
    };

    setPreviewNumber() {
        if (this.aisleNumberInput.value >= this.maxAisleNumber) this.aisleNumberInput.value = this.maxAisleNumber;

        Array.from(this.previewAisleNumbers).forEach((aisleNumber) => {
            aisleNumber.innerHTML = this.aisleNumberInput.value;
            if (this.aisleNumberInput.value >= this.minStretchAisleNumber) {
                aisleNumber.classList.remove('standard');
                aisleNumber.classList.add('stretch');
            } else {
                aisleNumber.classList.add('standard');
                aisleNumber.classList.remove('stretch');
            }
        })
    };

    setPreviewText() {
        let text = '';
        let i = 0;

        Array.from(this.itemsSelects).forEach((select) => {
            let option = select.options[select.selectedIndex];
            if (!this.isOptionEmpty(select)) {
                if (i > 0) text += '<br />';
                text += option.text;
            }
            i++;
        })

        Array.from(this.itemsText).forEach((label) => label.innerHTML = text);
    }

    setPreviewImages(itemSelect) {
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

            Array.from(images).forEach((picto) => picto.setAttribute('src', image.name));
        });
    }

    isOptionEmpty(dataSelect) {
        const option = dataSelect.options[dataSelect.selectedIndex];

        return typeof option === 'undefined' || option.text === '';
    }

    resetItemSelect(item) {
        item.setAttribute('disabled', 'disabled');
        item.value = '';
        item.text = '';
    }

    resetItemCheckbox(checkbox) {
        checkbox.setAttribute('disabled', 'disabled');
        $(checkbox).prop('checked', false);
    }

    enableElement(element) {
        element.removeAttribute('disabled');
    }

    setItemsStatus() {
        for (let i = 1; i < 3; i++) {
            const dataItem = document.getElementById(`${this.formName}_item${i}`);
            const targetItem = document.getElementById(`${this.formName}_item${i + 1}`);
            const targetCheckbox = !this.isSmall ?
                document.getElementById(`${this.formName}_hideItem${i + 1}Image`) : false;

            if (this.isOptionEmpty(dataItem)) {
                this.resetItemSelect(targetItem);
                if (targetCheckbox) this.resetItemCheckbox(targetCheckbox);
            } else {
                this.enableElement(targetItem)
                if (targetCheckbox) this.enableElement(targetCheckbox);
            }
        }
    }

    refreshPreviewImages() {
        for (let i = 1; i < 4; i++) {
            this.setPreviewImages(document.getElementById(`${this.formName}_item${i}`));
        }
    }

    refreshSignPreview() {
        this.setPreviewNumber();
        this.setItemsStatus();
        if (!this.isSmall) this.refreshPreviewImages();
        this.setPreviewText();
    }

    setSelectItemsFromCategory() {
        const self = this;
        const value = this.itemsCategory.value;
        const route = this.itemsCategory.dataset.route;
        const form = new FormData();
        form.append('category', value);

        fetch(route, {
            method: 'POST',
            body: form
        }).then(function (response){
            return response.json();
        }).then(function (data) {
            Array.from(self.itemsSelects).forEach((itemSelect) => {
                FormHelper.setSelectOptions(itemSelect, data);
            })
            self.refreshSignPreview();
        });
    }

    addAisleNumberListener() {
        this.aisleNumberInput.addEventListener('change', () => this.setPreviewNumber());
    }

    addCategoryListener() {
        this.itemsCategory.addEventListener('change', () => this.setSelectItemsFromCategory());
    }

    addItemsSelectsListeners() {
        Array.from(this.itemsSelects).forEach((itemSelect) => {
            itemSelect.addEventListener('change', () => this.refreshSignPreview());
        });
    }

    addCheckBoxesListeners() {
        Array.from(this.itemsCheckboxes).forEach((checkbox) => {
            checkbox.addEventListener('change', () => this.refreshPreviewImages());
        });
    }
}
