# 🏙️ The Community – Laravel REST API

**The Community** is a modern Laravel-based backend API designed for managing a social or local community platform. Built with clean architecture principles, real-time notifications, and secure role-based access, this backend powers the entire application with speed, scalability, and flexibility.

---

## 🚀 Features

- ✅ **RESTful API** built with Laravel 11
- 🧠 **3-Tier Architecture**: Controller → Service → Repository
- 🔐 **Sanctum Authentication** for secure token-based login
- 🧑‍⚖️ **Role-Based Access Control (RBAC)**
- 📧 **Email Verification** flow for account activation
- 🌍 **Cloudinary Integration** for image upload & storage
- 🔔 **Firebase Cloud Messaging (FCM)** for real-time push notifications
- 🧩 **Clean Eloquent Relationships** across models
- 📦 Well-structured codebase for easy maintenance & scalability

---

## 🛠️ Tech Stack

- **Framework:** Laravel 11
- **Authentication:** Sanctum
- **Cloud Storage:** Cloudinary
- **Notifications:** Firebase Cloud Messaging (FCM)
- **Database:** MySQL
- **Deployment:** DigitalOcean (Ubuntu + Nginx)
- **API Testing:** Postman

---

## 📂 Project Structure

app/
├── Http/
│ ├── Controllers/ # Route controllers
│ └── Middleware/
├── Models/ # Eloquent models
├── Services/ # Business logic layer
├── Repositories/ # Data access layer
routes/
├── api.php # API routes
config/
database/


---

## 🔐 Authentication Flow

- **User Registration + Email Verification**
- **Token-based login using Laravel Sanctum**
- **Role checking middleware to restrict access**

---

## ☁️ Cloudinary Upload

- Handles media uploads directly to **Cloudinary**
- Returns secure URL after upload

---

## 🔔 Firebase Notifications

- Push real-time notifications using **Firebase Cloud Messaging**
- Trigger notifications  like new post, etc.

---

## 📦 Installation

```bash
git clone https://github.com/your-username/the-community.git
cd the-community

# Install dependencies
composer install

# Set up environment
cp .env.example .env
php artisan key:generate

# Configure database and other credentials in .env

# Run migrations
php artisan migrate

# Run the server
php artisan serve
```


🔧 Configuration
.env keys you need:

# Database
```
DB_CONNECTION=mysql
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_pass
```
# Sanctum
```
SANCTUM_STATEFUL_DOMAINS=localhost
```
# Cloudinary
```
CLOUDINARY_CLOUD_NAME=xxxx
CLOUDINARY_API_KEY=xxxx
CLOUDINARY_API_SECRET=xxxx
```
# Firebase
```
FIREBASE_SERVER_KEY=xxxx
```



