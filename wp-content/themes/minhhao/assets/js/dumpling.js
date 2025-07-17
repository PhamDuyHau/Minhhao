document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.product-cart-link').forEach(link => {
    link.addEventListener('click', function (e) {
      if (e.button !== 0) return; // only left click

      const type = this.dataset.productType;
      const addToCartUrl = this.dataset.addToCartUrl;

      if (type === 'simple') {
        e.preventDefault(); // prevent navigation
        jQuery.post(addToCartUrl, function () {
          jQuery(document.body).trigger('added_to_cart');
        });
      }
    });
  });
});
