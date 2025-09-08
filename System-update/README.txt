README - Volunteer Coordination Web Application
------------------------------------------------------

This project is a plain PHP + MySQL web application (no frameworks) 
that demonstrates user login/logout, role-based access, and volunteer 
coordination functionalities.

------------------------------------------------------
Login Information
------------------------------------------------------
1. Default Ordinary User (as required by assignment):
   Username: uoc
   Password: uoc
   Role: Volunteer

2. Admin User (if already created in DB or by running commented insert in db_connect.php):
   Username: admin
   Password: admin (or as defined in database)
   Role: Admin

------------------------------------------------------
Pages
------------------------------------------------------
1. login.php      - Login page (first page)
2. index.php      - Home page (default if not logged in)
3. admin.php      - Admin-only page (protected by role check)
4. events.php     - Manage and view events
5. event_register.php - Register for events
6. volunteer.php  - Volunteer dashboard
7. organization_dashboard.php - Organization dashboard
8. reports.php    - Reports (Admin only)
9. help.php       - Help page

------------------------------------------------------
Notes
------------------------------------------------------
- Unauthorized users cannot directly access admin.php or reports.php.
- Database connection settings can be modified in db_connect.php.
- Import dbc.sql into MySQL (via phpMyAdmin or CLI) before running.

------------------------------------------------------
Assignment Compliance
------------------------------------------------------
- User login/logout ✅
- Roles: Admin / Volunteer (ordinary user) ✅
- Default user 'uoc/uoc' ✅
- Unauthorized access blocked ✅
- Required pages (login, home, admin, functionalities, help) ✅
