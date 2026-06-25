<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚡ Zeus Wisher</title>
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card main-card">
            <h1>⚡ Zeus Wisher</h1>
            <p class="subtitle">Enter your name and birthday to get a personalized wish!</p>

            <div class="form-group">
                <input type="text" id="name" placeholder="Your Name" />
                <input type="text" id="birthday" placeholder="Birthday (MM/DD, no year)" />
                <button id="generateBtn">🎁 Generate My Wish</button>
            </div>

            <div id="messageContainer" style="display: none;">
                <div id="messageBox">
                    <p id="wishMessage"></p>
                    <span id="savedBadge">✅ Wish saved!</span>
                </div>
            </div>
        </div>

        <div class="card wishes-card">
            <h2>💖 Recent Birthday Wishes</h2>
            <div id="wishesList">
                <div class="loading-spinner"></div>
                <p class="loading-text">Loading wishes...</p>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>