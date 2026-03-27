const modal = document.getElementById('list-modal');
const listItems = document.querySelectorAll('.modal-item');
const closeBtn = document.querySelector('.modal-close');

function openModal(gameName, variant, userId) {
    fetch(`get_stat_scores.php?game_name=${encodeURIComponent(gameName)}&variant=${encodeURIComponent(variant)}&user_id=${encodeURIComponent(userId)}`)
        .then(res => res.json())
        .then(data => {

            listItems.forEach((li, index) => {
                if (data[index]) {
                    li.children[1].textContent = data[index].score;
                } else {
                    li.children[1].textContent = '--';
                }
            });
        })
        .catch(err => {
            console.error("Error fetching scores:", err);
            listItems.forEach(li => {
                li.children[1].textContent = '--';
            });
        });
    const name = document.getElementById('modal-game-name');
    name.textContent = gameName + " - " + variant;
    setTimeout(function() {
        modal.classList.add('active');
    }, 100);
    
}

function closeModal() {
    modal.classList.remove('active');
}

closeBtn.addEventListener('click', closeModal);

modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
});

