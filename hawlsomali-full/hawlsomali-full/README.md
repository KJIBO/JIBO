# HawlSomali Full Version

A full PHP + MySQL job portal for Somalia with public pages, admin dashboard, employer dashboard, and job seeker dashboard.

## Main features
- Public homepage, jobs listing, job details, companies, about, contact
- Employer registration and login
- Job seeker registration and login
- Admin login and moderation
- Employer job posting, editing, closing, applicant review
- Job seeker applications, saved jobs, profile management
- Admin management for jobs, employers, seekers, categories, locations, and messages
- CV upload and company logo upload
- Responsive Bootstrap UI

## Setup on XAMPP or Laragon
1. Extract the zip into your web root:
   - XAMPP: `htdocs/hawlsomali-full`
   - Laragon: `www/hawlsomali-full`
2. Create a MySQL database named `hawlsomali_full`
3. Import `database.sql`
4. Update `config/db.php` if your MySQL username or password is different
5. Open:
   - `http://localhost/hawlsomali-full/`

## Default logins
- Admin: `admin@hawlsomali.com` / `admin123`
- Employer: `employer@hawlsomali.com` / `admin123`
- Job Seeker: `seeker@hawlsomali.com` / `admin123`

## Important note
This package is a working PHP/MySQL website and is much more complete than the starter version. It is still a lightweight custom app, not a full Laravel framework project. You can extend it with email notifications, multilingual UI, PDF export, and advanced reporting later.
