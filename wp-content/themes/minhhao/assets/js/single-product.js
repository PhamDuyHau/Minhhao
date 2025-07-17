document.addEventListener('DOMContentLoaded', function () {
    const minusBtn = document.querySelector('.minus-btn');
    const plusBtn = document.querySelector('.plus-btn');
    const qtyInput = document.querySelector('.quantity-input');
    const hiddenQty = document.getElementById('form-quantity');
    const priceElem = document.querySelector('[data-unit-price]');
    const priceDisplay = document.getElementById('product-total-price');

    if (!minusBtn || !plusBtn || !qtyInput || !priceElem || !hiddenQty) return;

    const unitPrice = parseFloat(priceElem.dataset.unitPrice);

    function updateTotal() {
        let qty = Math.max(1, parseInt(qtyInput.value || 1));
        qtyInput.value = qty;
        hiddenQty.value = qty;

        const total = unitPrice * qty;
        priceDisplay.innerText = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(total);
    }

    minusBtn.addEventListener('click', () => {
        qtyInput.value = Math.max(1, parseInt(qtyInput.value || 1) - 1);
        updateTotal();
    });

    plusBtn.addEventListener('click', () => {
        qtyInput.value = parseInt(qtyInput.value || 1) + 1;
        updateTotal();
    });

    qtyInput.addEventListener('change', updateTotal);

    updateTotal();
});
