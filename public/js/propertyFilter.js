// resource/view/properties.blade.php

// Drawer Closer
const filterButton = document.getElementById('filterButton');
const filterDrawer = document.getElementById('filterDrawer');

filterButton.addEventListener('click', () => {
    filterDrawer.classList.toggle('hidden');
});