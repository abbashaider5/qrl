-- QLR MySQL schema

DROP TABLE IF EXISTS admins;
CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS login_attempts;
CREATE TABLE login_attempts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ip_address VARCHAR(64) NOT NULL,
  email VARCHAR(255) NOT NULL,
  success TINYINT(1) NOT NULL DEFAULT 0,
  attempted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX (ip_address),
  INDEX (attempted_at)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS contacts;
CREATE TABLE contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  ip_address VARCHAR(64),
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE INDEX idx_contacts_email ON contacts (email);
CREATE INDEX idx_contacts_created ON contacts (created_at);

DROP TABLE IF EXISTS blogs;
CREATE TABLE blogs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  slug VARCHAR(255) NOT NULL UNIQUE,
  content MEDIUMTEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE INDEX idx_blogs_created ON blogs (created_at);

-- Seed admin (replace hash with a bcrypt generated value)
-- INSERT INTO admins (email, password_hash) VALUES ('admin@example.com', '$2y$10$replace_with_real_hash_____________');

-- Dummy seed data
INSERT INTO admins (email, password_hash)
VALUES ('admin@example.com', '$2y$10$VcA.1uWNHsH0pQe4zq1sAuQvHcZJrS4a5fHfD1oVYcIhQeYI1k5lW'); -- bcrypt for 'Admin@123' (example)

INSERT INTO blogs (title, slug, content, created_at) VALUES
('Executive Travel Tips for NYC', 'executive-travel-tips-nyc', 'Planning executive travel in NYC requires precision. In this guide, we cover airport timing, vehicle selection, and route planning for reliable arrivals across JFK, LGA, and EWR...', NOW()),
('Sedan vs SUV: Which to Choose?', 'sedan-vs-suv-which-to-choose', 'Choosing between a sedan and an SUV depends on passenger count, luggage, comfort preferences, and itinerary. Sedans are discreet and refined, while SUVs offer space and flexibility...', NOW()),
('Roadshow Logistics: A Practical Checklist', 'roadshow-logistics-practical-checklist', 'Roadshows demand coordination, staging plans, and radio support. We provide a practical checklist to ensure vehicles, chauffeurs, and venues are aligned for a smooth event...', NOW());
