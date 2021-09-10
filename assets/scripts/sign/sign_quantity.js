const quantityInputs = document.getElementsByClassName('sign-quantity');

Array.from(quantityInputs).forEach((input) => {
    input.addEventListener('change', () => {
        if (input.value <= 1) input.value = 1;

        const route = input.dataset.route;
        const form = new FormData();
        form.append('quantity', input.value);

        fetch(route, {
            method: 'POST',
            body: form
        });
    });
});
