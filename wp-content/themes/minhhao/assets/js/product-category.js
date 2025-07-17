document.addEventListener('DOMContentLoaded',  function() {
            const subcatButtons = document.querySelectorAll('.subcategory-btn');
            const gridContainer = document.getElementById('product-grid-container');
            const parentCategoryId = categoryData.parentCategoryId;


            subcatButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active styles from all
                    subcatButtons.forEach(btn => {
                        btn.classList.remove('bg-[#B40303]', 'text-white');
                        btn.classList.add('bg-[#FFD4C7]', 'text-[#7A0202]');
                    });

                    // Apply active styles to clicked
                    this.classList.add('bg-[#B40303]', 'text-white');
                    this.classList.remove('bg-[#FFD4C7]', 'text-[#7A0202]');

                    const subcatId = this.dataset.subcatId;

                    // Optional loading state
                    gridContainer.innerHTML = '<p class="text-center text-gray-500">Đang tải sản phẩm...</p>';

                    const url = new URL(categoryData.ajaxUrl);
                    url.searchParams.append('action', 'load_subcategory_products');
                    url.searchParams.append('term_id', subcatId);
                    url.searchParams.append('parent_id', parentCategoryId);

                    fetch(url)
                        .then(res => res.text())
                        .then(html => {
                            gridContainer.innerHTML = html;
                        });
                });
            });
        });

