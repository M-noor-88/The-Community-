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

📊 Dashboard Screenshots
---
Admin Dashboard Overview (Livewire Version , not Completed Yet)

# The Initaives with filtering by category , and top voting - المبادرات المجتمعية

<img width="1920" height="868" alt="1" src="https://github.com/user-attachments/assets/e1ecb3ac-175e-4fd7-b0ae-2d3bf3213d46" />
<img width="1920" height="869" alt="2" src="https://github.com/user-attachments/assets/0c783fca-001b-48aa-8a1e-3ce64b0ef189" />

---

# Complaint Tracking System - الشكاوي 
<img width="1914" height="881" alt="7" src="https://github.com/user-attachments/assets/a9a33516-9738-4e7d-8402-5110de1c78d8" />
<img width="1896" height="897" alt="8" src="https://github.com/user-attachments/assets/0bc6fd59-b2c9-4b5b-9302-69da4c45c24a" />
<img width="1892" height="859" alt="9" src="https://github.com/user-attachments/assets/3ba862b4-d38e-4576-835b-69358e3f0fbf" />
<img width="1557" height="861" alt="11" src="https://github.com/user-attachments/assets/9f8d65f2-8eee-4f0b-94d1-7cbe37751ad9" />
<img width="1567" height="807" alt="10" src="https://github.com/user-attachments/assets/c1b674cb-42d0-4bbb-bd04-749eb9693df1" />
<img width="1503" height="803" alt="12" src="https://github.com/user-attachments/assets/1d534a6d-2517-4e3e-8c50-923581d21649" />

---

# Campagins - الحملات الرسمية

<img width="1911" height="869" alt="3" src="https://github.com/user-attachments/assets/28028d0b-ebde-465b-9bea-95210ff97aa0" />
<img width="1920" height="870" alt="4" src="https://github.com/user-attachments/assets/cf18afac-aaec-45f5-89b1-6153e9db566d" />
<img width="1920" height="875" alt="5" src="https://github.com/user-attachments/assets/5f61bdb5-b3d1-4e37-8b90-9c803158e01e" />
<img width="1908" height="874" alt="6" src="https://github.com/user-attachments/assets/7fbb269f-1b75-4b91-bd48-c31ce7b60109" />



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



