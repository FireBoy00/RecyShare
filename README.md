# RecyShare

## About the Project

RecyShare is a recipe-sharing platform designed to bring people together through food and creativity. The platform allows users to discover and enjoy recipes, while registered members can contribute their own culinary ideas to inspire others. Our goal is to encourage sharing, reduce food waste, and make cooking a more collaborative and enjoyable experience.

**Tech Stack:** Laravel 12, Vite, SQLite

## Development Team

- **Adrian**
- **Gabija**
- **Aleksandra**
- **Dorina**
- **Jakub**
- **Tomass**

Web Technologies Project - SDU Sønderborg, Denmark

---

## Initial Setup (First Time)

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & npm
- Git

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd RecyShare
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Set up environment file**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Create database file** (for SQLite)
   ```bash
   # PowerShell
   New-Item -ItemType File -Path database/database.sqlite -Force
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the database (optional)**
   ```bash
   php artisan db:seed
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```

9. **Start the development server**
   ```bash
   npm run dev
   # Or use composer: composer run dev
   ```

The application will be available at `http://localhost:8000`

---

## When Someone Changes the Database

If migrations or database structure has been updated:

### Option 1: Fresh Migration (Recommended for Development)
```bash
# This will drop all tables and re-run all migrations
php artisan migrate:fresh

# With seeding
php artisan migrate:fresh --seed
```

### Option 2: Run New Migrations Only
```bash
# Pull latest changes
git pull

# Run any new migrations
php artisan migrate

# If there are conflicts or issues, reset:
php artisan migrate:reset
php artisan migrate
```

### Option 3: Complete Database Reset
```bash
# Delete the database file
rm database/database.sqlite

# Recreate it (PowerShell)
New-Item -ItemType File -Path database/database.sqlite -Force

# Run migrations
php artisan migrate --seed
```

---

## When .env or Authentication Changes

### If .env.example is Updated

1. **Check what changed**
   ```bash
   # Compare your .env with .env.example
   code .env.example
   ```

2. **Update your .env file**
   - Manually add new variables from `.env.example`
   - Update changed configuration values
   - Keep your local customizations

3. **Clear configuration cache**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

### If Authentication System Changes

```bash
# Clear all auth-related caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Re-run migrations if user table structure changed
php artisan migrate:fresh --seed
```

---

## Common Issues & Solutions

### "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Database errors after pulling changes
```bash
php artisan migrate:fresh --seed
```

### Frontend not updating
```bash
# Clear Vite cache and rebuild
npm run build
# Or restart dev server
npm run dev
```

### Permission errors on Windows
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### "Class not found" errors
```bash
composer dump-autoload
```

---

## Development Workflow

### Running the Application

**Start everything (Laravel + Vite + Queue):**
```bash
npm run dev
# or
composer run dev
```

**Run individually:**
```bash
# Laravel server only
php artisan serve

# Vite only (for frontend)
npm run runVite

# Queue worker (if using queues)
php artisan queue:listen
```

### Testing
```bash
# Run tests
composer test
# or
php artisan test
```

### Code Quality
```bash
# Format code with Laravel Pint
./vendor/bin/pint
```

---

## Project Structure

```
app/
├── Http/Controllers/    # Request handlers
├── Models/             # Database models (User, Recipe, Comment, Favorite)
└── Providers/          # Service providers

database/
├── factories/          # Model factories for testing
├── migrations/         # Database schema
└── seeders/           # Database seeders

resources/
├── css/               # Stylesheets
├── js/                # JavaScript files
└── views/             # Blade templates

routes/
└── web.php            # Web routes

public/
└── assets/            # Static assets (images, etc.)
```

---

## Important Files Not in Git

The following files are gitignored and need to be set up locally:

- `.env` - Environment configuration (copy from `.env.example`)
- `database/database.sqlite` - SQLite database file
- `node_modules/` - Node dependencies (run `npm install`)
- `vendor/` - PHP dependencies (run `composer install`)
- `public/build/` - Compiled assets (run `npm run build`)

---

## Quick Reference

| Command | Description |
|---------|-------------|
| `npm run dev` | Start all dev servers (Laravel + Vite + Queue) |
| `php artisan serve` | Start Laravel server only |
| `php artisan migrate:fresh --seed` | Reset database with seed data |
| `php artisan config:clear` | Clear configuration cache |
| `php artisan route:list` | List all routes |
| `php artisan tinker` | Open Laravel REPL |
| `npm run build` | Build production assets |

---

## Need Help?

Contact **Adrian** if you encounter issues not covered in this README.
- GitHub: [FireBoy](https://github.com/FireBoy)  
- Discord: @rinpyre