import {FormHelper} from "../app/form_helper";

export class MaterialSectorSignHelper {
    constructor(formName) {
        this.formName = formName;
        this.maxAisleNumber = 999;

        this.previewOne = document.getElementById('material-sector-sign-1');
        this.previewTwo = document.getElementById('material-sector-sign-2');
        this.previewsSector = document.getElementsByClassName(`sector-value`);
        this.previewsAisleNumber = document.getElementsByClassName('aisle-number-value');

        this.aisleNumberInput = document.getElementById(`${formName}_aisleNumber`);
        this.alignmentSelect = document.getElementById(`${formName}_alignment`);
        this.itemsCategorySelect = document.getElementById(`${formName}_category`);
        this.itemsText = document.getElementsByClassName('product-items');
        this.itemsSelects = document.getElementsByClassName('item_select');

        this.refreshSignPreview();
        this.addAisleNumberListener();
        this.addAlignmentListener();
        this.addCategoryListener();
        this.addItemsSelectsListeners();
    };

    setPreviewNumber() {
        if (this.aisleNumberInput.value >= this.maxAisleNumber) {
            this.aisleNumberInput.value = this.maxAisleNumber;
        }

        Array.from(this.previewsAisleNumber).forEach((item) => {
            item.innerText = this.aisleNumberInput.value;
        })
    };

    setPreviewAlignment() {
        const alignment = this.alignmentSelect.value;

        if (alignment === 'all') {
            this.previewOne.classList.remove('right');
            this.previewOne.classList.add('left');
            this.previewTwo.classList.remove('left');
            this.previewTwo.classList.add('right');
            return;
        }

        if (alignment === 'left') {
            this.previewOne.classList.remove('right');
            this.previewOne.classList.add('left');
            return;
        }

        if (alignment === 'right') {
            this.previewOne.classList.remove('left');
            this.previewOne.classList.add('right');
        }
    }

    setPreviewsScale() {
        if (this.alignmentSelect.value === 'all') {
            this.previewOne.classList.remove('large');
            this.previewOne.classList.add('medium');
            return;
        }

        this.previewOne.classList.remove('medium');
        this.previewOne.classList.add('large');
    }

    setPreviewsVisibility() {
        if (this.alignmentSelect.value === 'all') {
            this.previewTwo.classList.remove('d-none');
            return;
        }

        this.previewTwo.classList.add('d-none');
    }

    setPreviewSector() {
        Array.from(this.previewsSector).forEach(sector => {
            sector.innerText = (this.itemsCategorySelect.value === undefined) ?
                '' : this.itemsCategorySelect.options[this.itemsCategorySelect.selectedIndex].text;
        });
    }

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

    isOptionEmpty(dataSelect) {
        const option = dataSelect.options[dataSelect.selectedIndex];

        return typeof option === 'undefined' || option.text === '';
    }

    resetItemSelect(item) {
        item.setAttribute('disabled', 'disabled');
        item.value = '';
        item.text = '';
    }

    enableElement(element) {
        element.removeAttribute('disabled');
    }

    setItemsStatus() {
        for (let i = 1; i < 3; i++) {
            const dataItem = document.getElementById(`${this.formName}_item${i}`);
            const targetItem = document.getElementById(`${this.formName}_item${i + 1}`);

            if (this.isOptionEmpty(dataItem)) {
                this.resetItemSelect(targetItem);
            } else {
                this.enableElement(targetItem)
            }
        }
    }

    refreshSignPreview() {
        this.setPreviewsVisibility();
        this.setPreviewsScale();
        this.setPreviewNumber();
        this.setPreviewAlignment();
        this.setPreviewSector();
        this.setItemsStatus();
        this.setPreviewText();
    }

    setSelectItemsFromCategory() {
        const self = this;
        const value = this.itemsCategorySelect.value;
        const route = this.itemsCategorySelect.dataset.route;
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

    addAlignmentListener() {
        this.alignmentSelect.addEventListener('change', () => {
            this.setPreviewsVisibility();
            this.setPreviewsScale();
            this.setPreviewAlignment()
        });
    }

    addCategoryListener() {
        this.itemsCategorySelect.addEventListener('change', () => this.setSelectItemsFromCategory());
    }

    addItemsSelectsListeners() {
        Array.from(this.itemsSelects).forEach((itemSelect) => {
            itemSelect.addEventListener('change', () => this.refreshSignPreview());
        });
    }
}
