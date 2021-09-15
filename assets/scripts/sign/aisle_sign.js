import {AisleSignHelper} from "./aisle_sign_helper";
import $ from 'jquery';

const aisleNumberInput = document.getElementById('aisle_order_sign_aisleNumber');
const itemCategoriesSelects = document.getElementsByClassName('item_category_select');
const itemsSelects = document.getElementsByClassName('item_select');
const itemsCheckboxes = document.getElementsByClassName('item_checkbox');

document.addEventListener("DOMContentLoaded", function(event) {
    // Preset data
    AisleSignHelper.SetPreviewNumbers(aisleNumberInput.value);
    AisleSignHelper.setPreviewText();
    AisleSignHelper.setItemsSelectsStatusFromParent();

    // Listeners
    aisleNumberInput.addEventListener('change', function () {
        if (this.value >= 99) this.value = 99;

        AisleSignHelper.SetPreviewNumbers(this.value);
    });

    Array.from(itemCategoriesSelects).forEach((categorySelect) => {
        categorySelect.addEventListener('change', function () {
            AisleSignHelper.setSelectItemsFromCategory(categorySelect);
        });
    })

    Array.from(itemsSelects).forEach((itemSelect) => {
        AisleSignHelper.setPreviewImages(itemSelect);

        itemSelect.addEventListener('change', function () {
            AisleSignHelper.setItemsSelectsStatusFromParent();
            AisleSignHelper.setPreviewImages(itemSelect);
            AisleSignHelper.setPreviewText();
        });
    });

    Array.from(itemsCheckboxes).forEach((checkbox) => {
        checkbox.addEventListener('change', () => {
            AisleSignHelper.setPreviewImages($(checkbox).closest('.item-container').find('.item_select')[0]);
        });
    });
});
