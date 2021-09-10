import {AisleSignHelper} from "./aisle_sign_helper";

const aisleNumberInput = document.getElementById('aisle_order_sign_aisleNumber');
const itemCategoriesSelects = document.getElementsByClassName('item_category_select');
const itemsSelects = document.getElementsByClassName('item_select');

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
});
