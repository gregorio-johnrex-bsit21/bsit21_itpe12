# Project Setup Guide

Welcome! This guide will walk you through everything you need to get the project running on your local machine. Please follow each step carefully and in order.

For better experince, turn the student dashboard into a mobile view using the inspect option, choose either Iphone SE or Microsoft Lumia 950, since our student dashboard is solely focused on mobile view.




skip the installation process if already done and proceed to account setup after the no. 10

---

## Requirements

Please make sure the following are installed on your machine before proceeding:

- [PHP 8.1+](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/) or [XAMPP](https://www.apachefriends.org/)
- [Node.js & NPM](https://nodejs.org/) *(required for frontend assets)*
- [Git](https://git-scm.com/)

---

## Installation Steps

### 1. Clone the Repository
```bash
git clone https://github.com/gregorio-johnrex-bsit21/bsit21_itpe12.git
cd bsit21_itpe12
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node Dependencies
```bash
npm install
```

### 4. Set Up the Environment File
Copy the example environment file:
```bash
cp .env.example .env
```

Then open the `.env` file and update the database configuration:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```
> 💡 If you are using XAMPP, the default username is `root` and the password field can be left empty.

### 5. Generate the Application Key
```bash
php artisan key:generate
```

### 6. Create the Database
Open **phpMyAdmin** and create a new database. Make sure the database name matches the value you set for `DB_DATABASE` in your `.env` file.

### 7. Run the Migrations
```bash
php artisan migrate
```

> ⚠️ **Note:** If a migration fails with a "table already exists" error, it means the table is present in the database but has not been recorded in Laravel's migration history. To resolve this, run the following in Tinker:
> ```bash
> php artisan tinker
> ```
> ```php
> DB::table('migrations')->insert([
>     ['migration' => 'the_migration_filename_here', 'batch' => 1],
> ]);
> ```
> Then run `php artisan migrate` again. Repeat as needed for any other conflicting tables.

### 8. Seed the Database *(optional)*
To populate the database with sample data:
```bash
php artisan db:seed
```

### 9. Build Frontend Assets
```bash
npm run dev
```

### 10. Start the Application
```bash
php artisan serve
```

The application should now be accessible at [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## First-Time Account Setup

Once the application is running, please follow the steps below to set up the initial accounts.

---

### Step 1 — Log In as Admin

Navigate to:
```
http://127.0.0.1:8000/admin
```
Since there's no login, you can just directly go to admin

---

### Step 2 — Create a Company

1. Go to the **Company** page from the admin dashboard.
2. Click **Add New Company** and fill in the required details.
3. After saving, the system will generate a **Company Code**.
4. Please **take note of this code** — it will be needed during student registration.

If you ever forgot about the supervisor id, you can just check the table for references, and if you didnt save the temporary password, you can just reset and regenerate a new one and make sure you save it. You can also check the company id on the table if you have not saved it, just make sure you have assigned a supervisor to that company first so that it appears on the table. It is always required to have a supervisor on each company since they will be the one to accept the student's registration later. To create a supervisor and assign it to a company, see Step 3.

---

### Step 3 — Create a Supervisor

1. Still on the company page find the **Add Supervisor**, create a **Supervisor** account and assign them to the company created in Step 2.
2. Upon saving, the system will display:
   - **Supervisor ID**
   - **Generated Temporary Password**
3. Please **save these credentials** — they will be used to log in as the supervisor.

Take note: you can only assign one supervisor per company.

---

### Step 4 — Log In as Supervisor

Navigate to:
```
http://127.0.0.1:8000/supervisor
```
Log in using the **Supervisor ID** and **Generated Temporary Password** from Step 3.

You can also set a new password to replace your temporary password on the account security on the profile icon on the right just click and a modal will show up, click account security and fill in the requirements such as previous password and new password. 

---

### Step 5 — Student Registration

The student should navigate to:
```
http://127.0.0.1:8000/student
```

1. On the landing page, select **Register**.
2. Complete the registration form with the following details:

   | Field | Description |
   |---|---|
   | Full Name | Student's full name |
   | Student ID | Any preferred ID, maximum 10 characters |
   | Company Code | The code generated in Step 2 |
   | Password | Minimum 6 characters |

3. After submitting, the page will enter a loading state briefly — this is expected behavior.

> ⚠️ **Please ensure the student enters the correct Company Code.** If a student is rejected, they will not be able to register under the same company again.

---

### Step 6 — Supervisor Reviews the Student Request

1. Return to the **Supervisor** panel.
2. Navigate to **Student Directory** — the student's request will appear as **Pending**.
3. The supervisor may either:
   - ✅ **Accept** — grants the student access to the system
   - ❌ **Reject** — permanently blocks the student from that company

> ⚠️ **Please verify** that the student belongs to the correct company before making a decision. A rejected student cannot re-register under the same company.

---

### Step 7 — Student Logs In

Once approved by the supervisor, the student may return to:
```
http://127.0.0.1:8000/student
```

Sometimes it redirects to login and it auto fill the id and pass

If not then go and,

Select **Login**, enter their credentials, and they will have full access to the system — including the ability to communicate with their assigned supervisor.

That's it!


---

## Troubleshooting

**"Table already exists" error during migration**
The table exists in the database but is not recorded in Laravel's migration history. Please refer to the note in Step 7 of the Installation section.

**`.env` file not found**
Run `cp .env.example .env` and fill in the appropriate database credentials.

**"Application key not set" error**
Run `php artisan key:generate` to resolve this.

**`composer` or `npm` command not recognized**
Please ensure Composer and Node.js are properly installed and added to your system's PATH.

---

## Notes

- **Migrations** define the database structure. Always run `php artisan migrate` after cloning the repository or pulling new changes.
- **Seeders** provide sample data for testing purposes and are optional.
- Database records are stored locally and are not shared through Git — only the code and structure are version-controlled.

---
