document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('game-search');
    const gameList = document.querySelector('.game-list');
    const buttons = Array.from(document.querySelectorAll('.game-item'));
    const sortOptions = Array.from(document.querySelectorAll('.sort-option'));

    // Function to update alternating backgrounds
    function updateAlternatingBackgrounds() {
        // Only visible buttons inside the current DOM order
        const visibleButtons = Array.from(gameList.children)
            .filter(btn => btn.style.display !== 'none');

        visibleButtons.forEach((btn, index) => {
            btn.style.background = (index % 2 === 0) ? '#3f3f3f' : '#838383';
        });
    }

    // Function to sort buttons
    function sortButtons(sortType) {
        let sorted = [...buttons];
        switch(sortType) {
            case 'az':
                sorted.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
                break;
            case 'za':
                sorted.sort((a, b) => b.dataset.name.localeCompare(a.dataset.name));
                break;
            case 'high': // Plays highest
                sorted.sort((a, b) => parseInt(b.dataset.plays) - parseInt(a.dataset.plays));
                break;
            case 'low': // Plays lowest
                sorted.sort((a, b) => parseInt(a.dataset.plays) - parseInt(b.dataset.plays));
                break;
        }
        // Re-append buttons in sorted order
        sorted.forEach(btn => gameList.appendChild(btn));
        updateAlternatingBackgrounds();
    }

    // Search input filter
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        buttons.forEach(btn => {
            const name = btn.dataset.name.toLowerCase();
            btn.style.display = name.includes(query) ? 'flex' : 'none';
        });
        updateAlternatingBackgrounds();
    });

    // Sort option click handler
    sortOptions.forEach(option => {
        option.addEventListener('click', e => {
            e.preventDefault();
            const sortType = option.dataset.sort;

            // Remove selected class from all options
            sortOptions.forEach(o => o.classList.remove('selected'));
            // Add selected class to clicked option
            option.classList.add('selected');
            console.log("selected: ", sortType, option.classList);

            // Sort buttons
            sortButtons(sortType);
        });
    });

    // Select default sort on page load (first option)
    const defaultSort = sortOptions[0];
    defaultSort.classList.add('selected');
    sortButtons(defaultSort.dataset.sort);
});