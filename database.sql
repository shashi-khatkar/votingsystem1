-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS evoting;
USE evoting;

-- Drop old tables (optional for reset)
DROP TABLE IF EXISTS voters;
DROP TABLE IF EXISTS candidates;

-- Voters table: allow open registration
CREATE TABLE voters (
  id INT AUTO_INCREMENT PRIMARY KEY,
  voter_name VARCHAR(100) NOT NULL,
  voter_id VARCHAR(100) UNIQUE NOT NULL, -- Voter's email/phone/student ID
  has_voted TINYINT DEFAULT 0
);

-- Candidates table
CREATE TABLE candidates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  party VARCHAR(100) NOT NULL,
  vote_count INT DEFAULT 0
);

-- Add sample candidates
INSERT INTO candidates (name, party) VALUES
('Alice', 'Team Alpha'),
('Bob', 'Team Bravo'),
('Charlie', 'Team Charlie');
