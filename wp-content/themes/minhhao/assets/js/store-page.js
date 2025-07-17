document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('city-select');
    const showBtn = document.getElementById('city-show');
    const boxes = [...document.querySelectorAll('.store-box')];
    const mapFrame = document.getElementById('store-map');
    const form = document.getElementById('city-form');

    function activateBox(box) {
        boxes.forEach(b => b.classList.remove('active'));
        box.classList.add('active');

        if (box.dataset.map) {
            mapFrame.src = box.dataset.map;
        }

        box.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }

    function filter(city) {
        let firstVisible = null;
        let shownCount = 0;

        boxes.forEach(box => {
            const match = !city || box.dataset.city === city;

            if (match && shownCount < 4) {
                box.style.display = 'block';
                if (!firstVisible) firstVisible = box;
                shownCount++;
            } else {
                box.style.display = 'none';
            }
        });

        if (firstVisible) activateBox(firstVisible);
    }

    // ✅ Initial load: show all
    filter('');

    // ✅ Submit event only for city-form
    if (form) {
        form.addEventListener('submit', (e) => {
            if (e.target.id === 'city-form') {
                e.preventDefault();
                const city = select?.value || '';
                filter(city);
            }
        });
    }

    // ✅ Button click also filters
    if (showBtn) {
        showBtn.addEventListener('click', () => {
            const city = select?.value || '';
            filter(city);
        });
    }

    // ✅ Clickable store boxes
    boxes.forEach(box => {
        box.addEventListener('click', () => activateBox(box));
    });

    console.log("✅ store-page.js loaded!");
});

