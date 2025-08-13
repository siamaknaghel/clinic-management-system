# Laravel Filament Starter Kit

A professional, secure, and reusable foundation for building modern Laravel applications with Filament Admin Panel.

Perfect for projects like travel platforms, clinics, HR systems, inventory management, and any admin-heavy application.

Built with:
- 🔧 Laravel 12
- 🎨 Filament 4
- 🔐 `spatie/laravel-permission` (Roles & Permissions)
- ✅ Email verification, password reset, full authentication
- 📁 Clean, scalable folder structure
- 🐳 Sail-ready (Docker)

---

## 🛠 Technologies

| Technology | Version |
|----------|---------|
| Laravel | ^12.0 |
| Filament | ^4.0 |
| PHP | ^8.2 |
| spatie/laravel-permission | ^6.0 |
| Composer | ^2.5 |

---

## 📦 Installation

### 1. Clone the project
```bash
git clone git@github.com:siamaknaghel/laravel-filament-starter-kit.git my-project
cd my-project
```

### 2. Install dependencies
```bash
composer install
npm install && npm run build
```

### 3. Configure environment
```bash
cp .env.example .env
```

> Edit `.env` and set your `DB_*`, `MAIL_*`, and other environment variables.

### 4. Generate app key and run migrations
```bash
php artisan key:generate
php artisan migrate --seed
```

### 5. Start the server
```bash
php artisan serve
```

> 🔗 Admin Panel: [http://localhost:8000/admin](http://localhost:8000/admin)

---

## 🔐 Authentication & Authorization

### ✅ Email Verification
- Enabled by default.
- Users must verify email to access the admin panel.

### ✅ Password Reset
- Built-in via Laravel and Filament.

### ✅ Roles & Permissions
- Powered by [`spatie/laravel-permission`](https://spatie.be/docs/laravel-permission).
- Predefined roles: `admin`, `staff`, `user`
- Example permissions: `manage-bookings`, `view-reports`, `manage-users`

#### Assign role in Tinker:
```bash
php artisan tinker
>>> $user = App\Models\User::first();
>>> $user->assignRole('admin');
```

---

## 🧩 Folder Structure
```bash
app/
├── Models/
├── Actions/ # Complex business logic
├── Services/ # Reusable service classes
├── Observers/ # Model event listeners
├── Enums/ # Status constants (e.g., BookingStatus)
├── Policies/ # Authorization logic
└── Filament/ # Admin panel resources, pages, widgets
```


This structure ensures scalability, testability, and reusability across all your projects.

---

## 🧑‍💼 Default Admin User (for testing)

| Field | Value |
|------|-------|
| Email | admin@example.com |
| Password | password |

> After login, verify the email via Mailpit or your configured mail driver.

---

## 🧪 Testing

Run tests:
```bash
php artisan test
```

Run with coverage:
```bash
php artisan test --coverage
```

---

## 🤝 Contributing

Contributions are welcome! Please read the [CONTRIBUTING.md](CONTRIBUTING.md) guide.

---

## 📄 License

MIT License. See [LICENSE](LICENSE) for details.
