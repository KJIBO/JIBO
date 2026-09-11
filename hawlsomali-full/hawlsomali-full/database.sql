CREATE DATABASE IF NOT EXISTS hawlsomali_full CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hawlsomali_full;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS saved_jobs;
DROP TABLE IF EXISTS applications;
DROP TABLE IF EXISTS jobs;
DROP TABLE IF EXISTS contact_messages;
DROP TABLE IF EXISTS job_seekers;
DROP TABLE IF EXISTS employers;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS locations;
DROP TABLE IF EXISTS admins;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE employers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  phone VARCHAR(30) DEFAULT NULL,
  address VARCHAR(255) DEFAULT NULL,
  website VARCHAR(150) DEFAULT NULL,
  description TEXT,
  logo VARCHAR(255) DEFAULT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'active',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE job_seekers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  phone VARCHAR(30) DEFAULT NULL,
  gender VARCHAR(20) DEFAULT NULL,
  location VARCHAR(120) DEFAULT NULL,
  education VARCHAR(150) DEFAULT NULL,
  skills TEXT,
  experience VARCHAR(150) DEFAULT NULL,
  cv_file VARCHAR(255) DEFAULT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'active',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

CREATE TABLE locations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

CREATE TABLE jobs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  employer_id INT NOT NULL,
  category_id INT NOT NULL,
  location_id INT NOT NULL,
  title VARCHAR(180) NOT NULL,
  job_type VARCHAR(50) NOT NULL DEFAULT 'Full Time',
  salary_min DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  salary_max DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  experience_level VARCHAR(100) DEFAULT NULL,
  education_level VARCHAR(100) DEFAULT NULL,
  vacancy_count INT NOT NULL DEFAULT 1,
  deadline DATE DEFAULT NULL,
  description TEXT,
  requirements TEXT,
  responsibilities TEXT,
  status VARCHAR(20) NOT NULL DEFAULT 'active',
  is_approved TINYINT(1) NOT NULL DEFAULT 0,
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_jobs_employer FOREIGN KEY (employer_id) REFERENCES employers(id) ON DELETE CASCADE,
  CONSTRAINT fk_jobs_category FOREIGN KEY (category_id) REFERENCES categories(id),
  CONSTRAINT fk_jobs_location FOREIGN KEY (location_id) REFERENCES locations(id)
);

CREATE TABLE applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  seeker_id INT NOT NULL,
  cover_letter TEXT,
  status VARCHAR(20) NOT NULL DEFAULT 'pending',
  applied_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_app_job FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
  CONSTRAINT fk_app_seeker FOREIGN KEY (seeker_id) REFERENCES job_seekers(id) ON DELETE CASCADE
);

CREATE TABLE saved_jobs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  seeker_id INT NOT NULL,
  job_id INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_saved_seeker FOREIGN KEY (seeker_id) REFERENCES job_seekers(id) ON DELETE CASCADE,
  CONSTRAINT fk_saved_job FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE
);

CREATE TABLE contact_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(150) NOT NULL,
  subject VARCHAR(200) NOT NULL,
  message TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admins (full_name, email, password) VALUES
('System Admin', 'admin@hawlsomali.com', '$2y$12$KH1nvJcNfMOcZ7aj0s5C7eRW.SH3vCVzdl7A8n9pLJ29KXOkp5vAC');

INSERT INTO employers (company_name, email, password, phone, address, website, description, status) VALUES
('SomTech Solutions', 'employer@hawlsomali.com', '$2y$12$KH1nvJcNfMOcZ7aj0s5C7eRW.SH3vCVzdl7A8n9pLJ29KXOkp5vAC', '+25261111222', 'Mogadishu, Somalia', 'https://somtech.example', 'A digital company focused on software, web systems, and IT services.', 'active'),
('Barwaaqo Logistics', 'hr@barwaaqo.so', '$2y$12$KH1nvJcNfMOcZ7aj0s5C7eRW.SH3vCVzdl7A8n9pLJ29KXOkp5vAC', '+25290777888', 'Bosaso, Somalia', 'https://barwaaqo.example', 'A logistics, transport, and supply chain company hiring across Somalia.', 'active');

INSERT INTO job_seekers (full_name, email, password, phone, gender, location, education, skills, experience, cv_file, status) VALUES
('Abdalle Hassan', 'seeker@hawlsomali.com', '$2y$12$KH1nvJcNfMOcZ7aj0s5C7eRW.SH3vCVzdl7A8n9pLJ29KXOkp5vAC', '+25261555123', 'Male', 'Bosaso', 'Bachelor Degree', 'Accounting, Excel, Administration', '2 Years', NULL, 'active'),
('Amina Ali', 'amina@example.com', '$2y$12$KH1nvJcNfMOcZ7aj0s5C7eRW.SH3vCVzdl7A8n9pLJ29KXOkp5vAC', '+25261777000', 'Female', 'Mogadishu', 'Bachelor Degree', 'Customer service, Reporting, Office support', '1 Year', NULL, 'active');

INSERT INTO categories (name) VALUES
('Accounting'),
('IT'),
('Engineering'),
('Health'),
('Education'),
('NGO'),
('Government'),
('Business Administration'),
('Marketing'),
('Security');

INSERT INTO locations (name) VALUES
('Mogadishu'),
('Bosaso'),
('Garowe'),
('Hargeisa'),
('Kismayo'),
('Galkayo'),
('Remote');

INSERT INTO jobs (employer_id, category_id, location_id, title, job_type, salary_min, salary_max, experience_level, education_level, vacancy_count, deadline, description, requirements, responsibilities, status, is_approved, is_featured) VALUES
(1, 2, 1, 'Junior Web Developer', 'Full Time', 400, 700, '1-2 Years', 'Bachelor Degree', 2, '2026-05-20', 'Build and maintain web pages, dashboards, and internal tools for the company.', 'PHP, MySQL, HTML, CSS, JavaScript', 'Develop features, fix bugs, and support deployment', 'active', 1, 1),
(1, 8, 7, 'Office Administrator', 'Remote', 350, 550, '2 Years', 'Diploma', 1, '2026-05-25', 'Support office operations, records, and reporting in a remote environment.', 'Administration, communication, reporting', 'Manage files, schedules, and coordination', 'active', 1, 0),
(2, 1, 2, 'Account Assistant', 'Full Time', 300, 500, '1 Year', 'Diploma', 1, '2026-05-28', 'Assist with bookkeeping, reconciliations, and finance records.', 'Accounting basics, Excel, reporting', 'Prepare records and support finance team', 'active', 1, 0),
(2, 9, 1, 'Marketing Officer', 'Contract', 450, 700, '2-3 Years', 'Bachelor Degree', 1, '2026-06-02', 'Plan campaigns, coordinate social media, and support customer growth.', 'Digital marketing, analytics, communication', 'Run campaigns and report on results', 'active', 0, 0);

INSERT INTO applications (job_id, seeker_id, cover_letter, status) VALUES
(1, 1, 'I am interested in this web developer role and have practical PHP and MySQL skills.', 'pending'),
(3, 2, 'I have accounting training and experience using Excel and bookkeeping systems.', 'shortlisted');

INSERT INTO saved_jobs (seeker_id, job_id) VALUES
(1, 3),
(1, 2);

INSERT INTO contact_messages (name, email, subject, message) VALUES
('Farah', 'farah@example.com', 'Need help posting a job', 'Please guide me on how to create an employer account and publish a vacancy.');
