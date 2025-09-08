CREATE DATABASE IF NOT EXISTS volunteer_connect_db;
USE volunteer_connect_db;

-- Users table (Volunteers, Organizations, Admins)
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Volunteer','Organization','Admin') NOT NULL DEFAULT 'Volunteer',
    
    -- For volunteers
    nic VARCHAR(20) DEFAULT NULL,
    
    -- For organizations
    registration_number VARCHAR(50) DEFAULT NULL,
    is_verified TINYINT(1) DEFAULT 0,  -- 0 = not verified, 1 = verified
    
    phone VARCHAR(15) NOT NULL,
    profile_pic VARCHAR(255),
    is_new TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- Events table (created by organizations)
CREATE TABLE IF NOT EXISTS events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    organization_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    location VARCHAR(255),
    event_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (organization_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Event registrations (volunteers join events)
CREATE TABLE IF NOT EXISTS event_registrations (
    registration_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    volunteer_id INT NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Registered','Completed','Cancelled') DEFAULT 'Registered',
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE,
    FOREIGN KEY (volunteer_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Volunteer requests (organizations request volunteers for programs)
CREATE TABLE IF NOT EXISTS volunteer_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    organization_id INT NOT NULL,               -- FK to users.user_id
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    volunteers_needed INT,
    event_datetime DATETIME,
    status ENUM('Pending','Approved','Completed') DEFAULT 'Pending',
    file_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (organization_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Impact table for reporting volunteer contributions
CREATE TABLE IF NOT EXISTS impact (
    impact_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    volunteer_id INT NOT NULL,
    contribution VARCHAR(255) NOT NULL, -- e.g., "10 hours volunteering"
    feedback TEXT,
    date_recorded DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE,
    FOREIGN KEY (volunteer_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;







