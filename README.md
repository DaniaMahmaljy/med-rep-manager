# MedRep Manager

A multi-tiered administration system for medical sales teams, built with Laravel. The platform enables admins to manage hierarchies of supervisors and representatives, track doctor visits, manage inventory, and facilitate communication through a live ticketing system.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

## 🏗️ System Architecture

- **User Hierarchy:** Superadmin → Admins → Supervisors → Medical Representatives.
- **Service Layer Pattern:** Core business logic (user management, visit scheduling, ticket handling) is encapsulated in dedicated service classes, ensuring clean, maintainable, and testable code.
- **RESTful API:** A dedicated API suite allows representatives to manage their visits and tickets on the go.

## ⚙️ Core Features

### 👥 User & Permission Management
- **Automated Onboarding:** System-generated credentials are sent via email; users must change password on first login.
- **Role-Based Access Control (RBAC):** Tailored dashboards and permissions for Superadmins, Admins, Supervisors, and Representatives.
- **Resource Assignment:** Admins assign doctors to supervisors and representatives to supervisors.

### 🩺 Visit & Sample Management
- **Dynamic Visit Scheduling:** Representatives schedule visits with doctors. The form dynamically loads assigned samples.
- **Inventory Tracking:** System tracks sample quantities given to doctors during visits.
- **Profile Statistics:** Detailed profiles for reps and doctors show visit history and analytics with interactive charts.

### 📊 Dynamic Data Handling
- **AJAX-Powered DataTables:** All data tables (for users, visits, tickets) are powered by DataTables with server-side processing via AJAX, ensuring fast performance with large datasets.
- **Dynamic Charts:** Analytics and statistics charts are rendered asynchronously by fetching data from Laravel API endpoints, providing live visualizations of system data.

### 💬 Live Operations
- **Real-Time Notifications:** Instant browser alerts for new tickets, assignments, and messages using Laravel Echo and Pusher.
- **Live Ticketing System:** A chat-like support system where tickets and replies appear in real-time without page refresh.

### 📱 Mobile-Friendly API
- **Representative Portal:** APIs allow reps to:
  - View their schedule and today's visits.
  - Update visit statuses.
  - Create and respond to support tickets.
  - View their notifications.

## 🛠️ Technical Stack

*   **Backend:** Laravel, PHP
*   **Database:** MySQL
*   **Real-Time:** Laravel Echo, Pusher
*   **Frontend:** Bootstrap (Customized Admin Template), JavaScript, Chart.js, DataTables
*   **Architecture:** Service Layer Pattern, RESTful API, MVC

## 📦 Installation

1.  Clone the repo and install dependencies:
    ```bash
    git clone https://github.com/DaniaMahmaljy/med-rep-manager.git
    cd med-rep-manager
    composer install
    npm install
    ```
2.  Setup environment:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
3.  Configure your `.env` file with database and Pusher credentials.
4.  Run migrations and seeders:
    ```bash
    php artisan migrate --seed
    ```
5.  Compile assets and serve:
    ```bash
    npm run build
    php artisan serve
    ```

## 👤 Author

**Dania Mahmaljy**

*   GitHub: [@DaniaMahmaljy](https://github.com/DaniaMahmaljy)
*   LinkedIn: (www.linkedin.com/in/dania-mahmaljy-b78880372)

This project was developed as a capstone to demonstrate advanced Laravel backend development skills.
