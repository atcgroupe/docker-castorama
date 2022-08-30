export class MaterialAlgecoSignHelper {
    constructor(formName) {
        this.formName = formName;
        this.dirSelect = document.getElementById(`${formName}_dir`);
        this.itemsSelects = document.getElementsByClassName('sign-item-select');
        this.item2Select = document.getElementById(`${formName}_item2`);
        this.item3Select = document.getElementById(`${formName}_item3`);
        this.item4Select = document.getElementById(`${formName}_item4`);
        this.text = document.getElementsByClassName('items_text')[0];
        this.template = document.getElementById('material-algeco');

        this.refreshVueState();
        this.addItemsSelectEventListeners();
        this.addDirSelectEventListener();
    }

    refreshVueState() {
        this._refreshSelectsStatus();
        this._refreshSignPreview();
    }

    _refreshSignPreview() {
        let text = '';

        Array.from(this.itemsSelects).forEach((select, index) => {
            const itemLabel = select.options[select.selectedIndex].text;
            if (index === 0) text = `• ${itemLabel}`;

            if (index > 0 && itemLabel !== '') {
                text += `<br>• ${itemLabel}`;
            }
        })

        this.text.innerHTML = text;

        this.template.classList.remove('dir-r');
        this.template.classList.remove('dir-l');
        this.template.classList.add(`dir-${this.dirSelect.value}`)
    }

    _refreshSelectsStatus() {
        if (this.item2Select.value !== '') {
            this._enableSelect(this.item3Select);
        }

        if (this.item3Select.value !== '') {
            this._enableSelect(this.item4Select);
        }

        if (this.item2Select.value === '') {
            this._disableSelect(this.item3Select);
            this._disableSelect(this.item4Select);
            return;
        }

        if (this.item3Select.value === '') {
            this._disableSelect(this.item4Select);
        }
    }

    _disableSelect(select) {
        select.value = '';
        select.setAttribute('disabled', 'disabled');
    }

    _enableSelect(select) {
        select.removeAttribute('disabled');
    }

    addItemsSelectEventListeners() {
        Array.from(this.itemsSelects).forEach(select => {
            select.addEventListener('change', () => {
                this.refreshVueState();
            });
        })
    }

    addDirSelectEventListener() {
        this.dirSelect.addEventListener('change', () => {
            this.refreshVueState();
        });
    }
}
