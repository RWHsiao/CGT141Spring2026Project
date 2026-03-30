const modal = document.getElementById('list-modal');
const listItems = document.querySelectorAll('.modal-item');
const closeBtn = document.querySelector('.modal-close');

function openModal(gameName, variant) {
    console.log(`get_leaderboard_scores.php?game_name=${encodeURIComponent(gameName)}&variant=${encodeURIComponent(variant)}`);
    fetch(`get_leaderboard_scores.php?game_name=${encodeURIComponent(gameName)}&variant=${encodeURIComponent(variant)}`)
        .then(res => res.json())
        .then(data => {

            listItems.forEach((li, index) => {
                const userInfo = li.querySelector('.leader-info .user-info');
                const pfp = userInfo.querySelector('.leader-pfp');
                const username = userInfo.querySelector('.leader-username');

                if (data[index]) {
                    pfp.src = `Images/PFP${data[index].pfp}.png`;
                    pfp.style.display = 'inline-block';
                    username.textContent = data[index].username;
                    li.children[1].textContent = data[index].score;

                    if (data[index].username === window.currentUsername) {
                        li.style.border = '2px solid blue';
                    }
                    else {
                        li.style.border = 'none';
                    }
                } else {
                    pfp.style.display = 'none';
                    username.textContent = '--';
                    li.children[1].textContent = '--';
                    li.style.border = 'none';
                }
            });
        })
        .catch(err => {
            console.error("Error fetching scores:", err);
            listItems.forEach(li => {
                const userInfo = li.querySelector('.leader-info .user-info');
                const pfp = userInfo.querySelector('.leader-pfp');
                const username = userInfo.querySelector('.leader-username');
                pfp.style.display = 'none';
                username.textContent = '--';
                li.children[1].textContent = '--';
                li.style.border = 'none';
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

