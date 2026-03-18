const modal = document.getElementById('list-modal');
const listItems = document.querySelectorAll('.modal-item');
const closeBtn = document.querySelector('.modal-close');

function openModal(gameName, variant) {
    modal.classList.add('active');
    fetch('get_scores.php?game_name=${encodeURIComponent(gameName)}&variant=${encodeURIComponent(variant)}')
        .then(res => res.json())
        .then(data => {

            listItems.forEach((li, index) => {
                const leaderInfo = li.querySelector('.leader-info');

                if (data[index]) {
                    leaderInfo.children[1].textContent = data[index].username;
                    li.children[1].textContent = data[index].score;
                } else {
                    leaderInfo.children[1].textContent = '--'
                    li.children[1].textContent = '--';
                }
            });
        })
        .catch(err => {
            console.error("Error fetching scores:", err);
            listItems.forEach(li => {
                const leaderInfo = li.querySelector('.leader-info');
                leaderInfo.children[1].textContent = '--'
                li.children[1].textContent = '--';
            });
        });
    const name = document.getElementById('modal-game-name');
    name.textContent = gameName + " - " + variant;
}

function closeModal() {
    modal.classList.remove('active');
}

closeBtn.addEventListener('click', closeModal);

modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
});

