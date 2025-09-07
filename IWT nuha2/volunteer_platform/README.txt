Volunteer Coordination Platform (IS1207) — Vanilla PHP + MySQL
=============================================================

This is a minimal, framework-free starter project that satisfies the IS1207 spec:
- Login/Logout with roles (admin, ordinary user)
- Default ordinary user: uoc / uoc
- Admin area for user and event management
- Home page tailored by role
- Functionalities page
- Help page
- Event listing + volunteer sign-up
- Block unauthorized access to protected pages
- All SQL queries included in init.sql

-----------------------------------
1) Requirements
-----------------------------------
- PHP 7.4+ (or PHP 8.x)
- MySQL 5.7+ / MariaDB 10+
- Apache or similar
- No frameworks, libraries, or external APIs are used.

-----------------------------------
2) Setup (MySQL)
-----------------------------------
- Create the database and tables + seed users/events:

  mysql -u root -p < init.sql

  (Edit 'db.php' if your DB user/password/host/dbname differ.)

-----------------------------------
3) Run
-----------------------------------
- Copy this whole folder to your Apache document root or a virtual host.
- Ensure PHP sessions are enabled.
- Visit: http://localhost/volunteer_platform/index.php

-----------------------------------
4) Default Logins
-----------------------------------
- Admin:    admin / admin
- Ordinary: uoc   / uoc

-----------------------------------
5) Files
-----------------------------------
- index.php         : Login page
- logout.php        : Logout
- home.php          : Role-based dashboard
- admin.php         : Admin panel (users, events, reports)
- events.php        : Browse events + sign-up
- signup_event.php  : Handles event sign-up / cancel
- functionalities.php: Lists all available system features
- help.php          : Help on how to use the system
- db.php            : DB connection
- auth.php          : Session + role guard
- header.php        : Top navigation
- styles.css        : Basic styles
- init.sql          : Database schema + seed data

-----------------------------------
6) Notes
-----------------------------------
- Passwords are stored with MD5 (for simplicity in a no-framework context).
  DO NOT use MD5 in production — use password_hash()/password_verify() instead.
- Input checks are basic; extend validation as needed.
- All core SQL queries used by the app are shown in init.sql.
