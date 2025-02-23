Gym Management System

📂 Project Structure
📌 Frontend (User Interface)
The frontend contains HTML and CSS files for both user and admin interfaces.

📁 frontend/
index.html – Landing page with options to Register or Login (common for users & admins).
registration.html – User sign-up form (Fields: Username, Email, Password, Height, Weight, Fitness Goals). Submits data to backend/user/register.php.
user-dashboard.html – Displays user profile, booked classes, and diet plans. Users can update their profile & book classes.
admin-dashboard.html – Admin dashboard to manage users, attendance, memberships, class schedules, and diet plans.
class-booking.html – Shows available gym classes (e.g., Zumba, CrossFit). Allows users to book/cancel classes. Sends booking requests to backend/user/class-booking.php.
diet-plan.html – Displays diet plans recommended by the admin based on user fitness goals.
📁 css/
style.css – General styling for all pages (buttons, forms, layout).
login.css – Specific styles for the login page.
📌 Backend (Server-side Logic)
Handles user authentication, class booking, profile management, and admin operations.

📁 backend/config/
db.php – Database connection file for MySQL.
📁 backend/functions/
Reusable functions for users, admins, and notifications:

user-functions.php – User registration, login, profile update, and class booking.
admin-functions.php – User management, attendance tracking, membership handling.
email-functions.php – Sends email notifications (class reminders, payments, profile updates).
sms-functions.php – Sends SMS notifications (class bookings, membership payments).
diet-plan-functions.php – Functions for admin to create/view diet plans.
📁 backend/user/
Handles user-related requests:

login.php – Authenticates user login, redirects to user-dashboard.html.
register.php – Registers new users in the database.
profile-update.php – Allows users to update height, weight, and fitness goals.
class-booking.php – Users can book/cancel gym classes (checks availability before confirming).
view-diet-plan.php – Fetches diet plan recommendations for the logged-in user.
📁 backend/admin/
Handles admin-related requests:

admin-login.php – Admin authentication, redirects to admin-dashboard.html.
user-management.php – Admin can view, edit, delete users, and track progress.
attendance-tracking.php – Admin can mark attendance for users and trainers.
membership-management.php – Create, update, or delete membership plans. Allows discounts for special events.
feedback.php – Fetches user feedback for gym facilities and trainers.
diet-plan-management.php – Admin can create/update diet plans, assign plans based on user goals.
📌 Database (MySQL Schema)
Stores users, classes, memberships, and diet plans.

📁 database/gym_management.sql
Defines database structure with the following tables:

users – Stores user details.
classes – Stores gym class schedules.
bookings – Tracks class bookings.
attendance – Logs gym check-ins.
memberships – Stores membership plans.
diet_plans – Stores admin-recommended diet plans.
🚀 How to Run the Project
Clone the repository:
git clone https://github.com/vinay0038/Gym_Managament_ateu.git
cd Gym_Managament_ateu
Import database/gym_management.sql into MySQL.
Configure database connection in backend/config/db.php.
Start XAMPP (Apache + MySQL) and place the project in htdocs.
Open http://localhost/Gym_management_system/frontend/index.html in a browser.
