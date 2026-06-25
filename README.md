# Birthday Wisher

A beautiful, self-contained birthday wish generator that creates personalized messages without requiring any API keys. Built with PHP, vanilla JavaScript, and auto-detecting database support (MySQL/PostgreSQL/SQLite).

## Features

- **Personalized Messages** - Enter name and birthday to get unique wishes
- **AI-Like Generation** - 150+ unique messages with different tones (no API key needed!)
- **Smart Personalization** - Seasonal greetings + zodiac sign detection
- **Auto-Detecting Database** - Works with MySQL, PostgreSQL, or SQLite (no setup needed!)
- **Live Updates** - New wishes appear instantly without page refresh
- **Responsive Design** - Works perfectly on all devices
- **Zero Dependencies** - Pure PHP + vanilla JS, no frameworks
- **Secure** - SQL injection protection + XSS prevention
- **One-Click Setup** - Works immediately on Linux with `./setup.sh`

## Quick Start

### On Linux (One-Command Setup)

```bash
# Clone the repository
git clone https://github.com/yourusername/birthday-wishes.git
cd birthday-wishes

# Run the one-click setup
chmod +x setup.sh
./setup.sh

# Start the server
php -S localhost:8000
```

Open http://localhost:8000 in your browser.

### Using XAMPP/WAMP/MAMP

Copy the project folder to `htdocs/` (XAMPP) or `www/` (WAMP). Start Apache and MySQL. Visit http://localhost/birthday-wishes/.

### Database Options

The application automatically detects and uses the first available database:

- **PostgreSQL** - Used when `DATABASE_URL` environment variable is set
- **MySQL** - Used when local MySQL is installed and configured
- **SQLite** - Automatically creates a file-based database (no server needed!)

### Database Setup (Optional)

If you want to use MySQL instead of SQLite:

```sql
-- Create database
CREATE DATABASE birthday_wishes;
USE birthday_wishes;

-- Create table
CREATE TABLE wishes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    birthday VARCHAR(10) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO wishes (name, birthday, message) VALUES
('John', '12/25', 'Happy Birthday, John!'),
('Jane', '06/15', 'Happy Birthday, Jane!');
```

Update `config.php` with your MySQL credentials if needed.

## Project Structure

```
birthday-wishes/
├── index.php          # Main page
├── config.php         # Auto-detects database type
├── save.php           # Save wishes to database
├── get-wishes.php     # Fetch all wishes
├── generate.php       # Message generator with 150+ messages
├── style.css          # All styles
├── script.js          # Vanilla JavaScript
├── setup.sh           # One-click Linux setup script
├── database.sql       # MySQL/PostgreSQL schema
├── database.sqlite    # SQLite schema (fallback)
├── render.yaml        # Deployment config
├── .htaccess          # URL rewriting + CORS headers
├── .gitignore         # Git ignore file
└── README.md          # This file
```

## API Endpoints

### Generate a Wish

```http
POST /generate.php
Content-Type: application/json

{
    "name": "John",
    "birthday": "12/25"
}
```

Response:

```json
{
    "message": "Happy Birthday, John! May your day be filled with joy!"
}
```

### Save a Wish

```http
POST /save.php
Content-Type: application/json

{
    "name": "John",
    "birthday": "12/25",
    "message": "Happy Birthday, John!"
}
```

Response:

```json
{
    "success": true,
    "id": 1
}
```

### Get All Wishes

```http
GET /get-wishes.php
```

Response:

```json
[
    {
        "id": 1,
        "name": "John",
        "birthday": "12/25",
        "message": "Happy Birthday, John!",
        "created_at": "2024-01-01 12:00:00"
    }
]
```

## Message Categories

The generator includes 150+ unique messages across these categories:

- **Heartfelt & Warm** (25+ messages)
- **Playful & Fun** (20+ messages)
- **Inspirational** (20+ messages)
- **Short & Sweet** (15+ messages)
- **Funny** (20+ messages)
- **Romantic** (15+ messages)
- **Poetic** (15+ messages)
- **Pop Culture** (10+ messages)
- **Encouraging** (15+ messages)
- **Food-Related** (10+ messages)

### Smart Personalization

- **Seasonal Greetings**: Detects spring, summer, fall, winter from birthday
- **Zodiac Signs**: Mentions zodiac signs in 20% of messages
- **Random Emojis**: Adds unique emoji combinations to each message
- **Name Personalization**: Every message includes the user's name

## Technologies

| Component | Technology |
|-----------|------------|
| Backend | PHP 7.4+ (no frameworks) |
| Database | MySQL / PostgreSQL / SQLite (auto-detects) |
| Frontend | HTML5, CSS3, Vanilla JavaScript |
| Deployment | `render.yaml` |
| Version Control | Git + GitHub |

## Security Features

- **Prepared Statements** - SQL injection protection
- **HTML Escaping** - XSS prevention
- **Input Validation** - Both frontend and backend
- **Environment Variables** - Sensitive data protection
- **CORS Headers** - API security
- **Error Handling** - Proper error messages without exposing internals

## Browser Support

| Browser | Version |
|---------|---------|
| Chrome | Latest |
| Firefox | Latest |
| Safari | Latest |
| Edge | Latest |
| Mobile Browsers | All modern |

## Contributing

1. Fork the repository
2. Create your feature branch:

   ```bash
   git checkout -b feature/amazing-feature
   ```

3. Commit your changes:

   ```bash
   git commit -m 'Add some amazing feature'
   ```

4. Push to the branch:

   ```bash
   git push origin feature/amazing-feature
   ```

5. Open a Pull Request

### Contribution Guidelines

- Follow the existing code style
- Add comments for complex logic
- Test locally before submitting
- Update documentation if needed

## Bug Reports & Feature Requests

### Bug Reports

Open an issue with:

- Steps to reproduce
- Expected behavior
- Actual behavior
- Screenshots (if applicable)
- Environment details

### Feature Requests

Open an issue with:

- Feature description
- Use case
- Implementation ideas

## License

MIT License - Free to use, modify, and distribute!

```text
MIT License

Copyright (c) 2024 Birthday Wisher

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

## Acknowledgments

- Inspired by the need for personalized birthday wishes
- Built with love for everyone celebrating their special day
- Thanks to the PHP and open-source communities

## Contact & Support

- [GitHub Issues](https://github.com/yourusername/birthday-wishes/issues): Report a bug
- Email: your-email@example.com
- Twitter: @yourhandle

## Show Your Support

If you like this project, please consider:

- Starring the repository on GitHub
- Forking it for your own use
- Sharing it with others
- Contributing to the code

---

Happy Birthday Wishing! Made with love for everyone who loves celebrating birthdays!

## Quick Links

- [GitHub Repository](https://github.com/yourusername/birthday-wishes)
- [Report Bug](https://github.com/yourusername/birthday-wishes/issues)
- [Request Feature](https://github.com/yourusername/birthday-wishes/issues)

---

*Last Updated: June 2026*
*Version: 1.0.0*
*Status: Production Ready*
