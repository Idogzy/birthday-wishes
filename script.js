document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const birthdayInput = document.getElementById('birthday');
    const generateBtn = document.getElementById('generateBtn');
    const messageContainer = document.getElementById('messageContainer');
    const wishMessage = document.getElementById('wishMessage');
    const savedBadge = document.getElementById('savedBadge');
    const wishesList = document.getElementById('wishesList');

    // Load wishes on page load
    loadWishes();

    // Generate wish
    generateBtn.addEventListener('click', async function() {
        const name = nameInput.value.trim();
        const birthday = birthdayInput.value.trim();

        if (!name || !birthday) {
            alert('Please enter your name and birthday (MM/DD)');
            return;
        }

        if (!/^\d{1,2}\/\d{1,2}$/.test(birthday)) {
            alert('Please enter birthday in MM/DD format (e.g., 12/25)');
            return;
        }

        generateBtn.disabled = true;
        generateBtn.textContent = '✨ Generating...';
        messageContainer.style.display = 'none';
        savedBadge.classList.remove('show');

        try {
            const genResponse = await fetch('generate.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, birthday })
            });

            if (!genResponse.ok) {
                throw new Error('Failed to generate message');
            }

            const genData = await genResponse.json();

            if (genData.error) {
                throw new Error(genData.error);
            }

            const message = genData.message;
            wishMessage.textContent = message;
            messageContainer.style.display = 'block';

            const saveResponse = await fetch('save.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, birthday, message })
            });

            const saveData = await saveResponse.json();

            if (saveData.success) {
                savedBadge.classList.add('show');
                loadWishes();
            }

        } catch (error) {
            alert('Failed to generate wish. Please try again.');
            console.error(error);
        } finally {
            generateBtn.disabled = false;
            generateBtn.textContent = '🎁 Generate My Wish';
        }
    });

    // Enter key support
    [nameInput, birthdayInput].forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                generateBtn.click();
            }
        });
    });

    // Load wishes function
    async function loadWishes() {
        try {
            const response = await fetch('get-wishes.php');
            
            if (!response.ok) {
                throw new Error('Failed to fetch wishes');
            }
            
            const wishes = await response.json();

            if (wishes.error) {
                throw new Error(wishes.error);
            }

            if (wishes.length === 0) {
                wishesList.innerHTML = '<p class="empty-text">No wishes yet. Be the first! 🎉</p>';
                return;
            }

            let html = '';
            wishes.forEach(wish => {
                const date = new Date(wish.created_at);
                const formattedDate = date.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });

                html += `
                    <div class="wish-item">
                        <div>
                            <span class="wish-name">${escapeHtml(wish.name)}</span>
                            <span class="wish-birthday">🎂 ${escapeHtml(wish.birthday)}</span>
                        </div>
                        <div class="wish-text">${escapeHtml(wish.message)}</div>
                        <div class="wish-date">${formattedDate}</div>
                    </div>
                `;
            });

            wishesList.innerHTML = html;

        } catch (error) {
            wishesList.innerHTML = '<p class="empty-text">Failed to load wishes. Please refresh.</p>';
            console.error(error);
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});