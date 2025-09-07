-- init.sql — Database schema + seed data (with volunteers, organizations, admin)
DROP DATABASE IF EXISTS volunteer_db;
CREATE DATABASE volunteer_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE volunteer_db;

-- USERS (with user_type)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(64) UNIQUE NOT NULL,
  password_hash CHAR(32) NOT NULL,
  name VARCHAR(100) NOT NULL,
  role ENUM('admin','user') NOT NULL DEFAULT 'user',
  user_type ENUM('volunteer','organization','admin') NOT NULL DEFAULT 'volunteer',
  skills VARCHAR(255) DEFAULT NULL,
  availability VARCHAR(255) DEFAULT NULL,
  interests VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- EVENTS (linked to organization user)
CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  description VARCHAR(500) DEFAULT NULL,
  event_time DATETIME NOT NULL,
  location VARCHAR(150) NOT NULL,
  required_skills VARCHAR(255) DEFAULT NULL,
  slots INT NOT NULL DEFAULT 10,
  created_by INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

-- ASSIGNMENTS
CREATE TABLE assignments (
  event_id INT NOT NULL,
  user_id INT NOT NULL,
  signed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (event_id, user_id),
  FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- DEFAULT USERS
INSERT INTO users (username, password_hash, name, role, user_type, skills, availability, interests) VALUES
('admin', MD5('admin'), 'System Administrator', 'admin', 'admin', 'coordination,planning', 'weekdays', 'management'),
('uoc', MD5('uoc'), 'Default Volunteer', 'user', 'volunteer', 'general help', 'weekends', 'community'),
('org1', MD5('org1'), 'Helping Hands Org', 'user', 'organization', NULL, NULL, 'charity');

-- SAMPLE EVENTS (created by org1)
INSERT INTO events (title, description, event_time, location, required_skills, slots, created_by) VALUES
('Beach Cleanup', 'Join us to clean the beach area and raise awareness.', NOW() + INTERVAL 3 DAY, 'Galle Face', 'physical,teamwork', 20, 3),
('Blood Donation Camp', 'Assist with registration and refreshments.', NOW() + INTERVAL 7 DAY, 'Kurunegala Hospital', 'registration,communication', 12, 3);
