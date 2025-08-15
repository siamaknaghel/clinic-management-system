# Clinic Management System

A modern, admin-ready clinic management system built with **Laravel 12** and **Filament 4**.

Manage patients, doctors, appointments, and medical records with a clean, secure, and professional interface — perfect for freelancers, clinics, or SaaS products.

![Filament Admin Panel](https://filamentphp.com/images/filament-v4-preview.png) *Example UI (replace with your own screenshot later)*

## ✨ Features

- **Patient Management**: Full CRUD for patient records with search and filters
- **Doctor Management**: Store specialties, fees, and contact details
- **Appointment Scheduling**: Date/time selection with conflict prevention
- **Medical Records**: Rich text notes, diagnosis, prescriptions, and file uploads (PDF, images)
- **Role-Based Access Control**: Admin, receptionist, doctor permissions via Spatie
- **Interactive Dashboard**: Real-time analytics with monthly revenue chart and upcoming appointments
- **Responsive Design**: Works perfectly on desktop and mobile
- **Upwork-Ready**: Clean code, English UI, and professional documentation

## 🛠 Tech Stack

- **Framework**: Laravel 12
- **Admin Panel**: Filament 4
- **Authorization**: Spatie Laravel Permission
- **Charts**: Flowframe Laravel Trend + Chart.js
- **Database**: MySQL
- **Frontend**: Tailwind CSS, Alpine.js
- **File Storage**: Laravel Filesystem (public disk)

## 🚀 Installation

```bash
# Clone the repository
git clone https://github.com/yourname/clinic-management-system.git
cd clinic-management-system

# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install && npm run build

# Create .env file and generate key
cp .env.example .env
php artisan key:generate

# Configure your database in .env
DB_DATABASE=clinic_management_system
DB_USERNAME=root
DB_PASSWORD=

# Run migrations and seed the database
php artisan migrate --seed

# Create storage link
php artisan storage:link
```

## 🔐 Admin Access

After seeding, use the following credentials to log in:

- **Email**: `admin@admin.com`
- **Password**: `password123!`

You will be redirected to the admin panel: [`/admin`](/admin)

## 🧪 Testing

```bash
php artisan test
```

## 📸 Screenshots (Optional)
You can add real screenshots here after deployment:

- **Dashboard**
- **Patient List**
- **Appointment Form**
- **Medical Record with File Upload**

## 🤝 Contributing

Pull requests are welcome! Please follow Laravel and Filament best practices.

## 📄 License
MIT License — feel free to use in personal or commercial projects.
