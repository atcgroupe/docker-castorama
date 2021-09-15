export const FormHelper = {
    setSelectOptions: (select, options) => {
        select.innerHTML = "";
        options.forEach((option) => {
            let optionElem = document.createElement('option');
            optionElem.value = option.value;
            optionElem.text = option.label;

            select.add(optionElem);
        });
    }
}
