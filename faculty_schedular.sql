
-- Table for Courses
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Table for Sections
CREATE TABLE sections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    semester INT NOT NULL
);

CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL  
);

-- Table for Faculty
CREATE TABLE faculty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role ENUM('Professor', 'Associate Professor', 'Assistant Professor') NOT NULL,
    email VARCHAR(100) NOT NULL ,
    phone_number VARCHAR(15) NOT NULL

);

-- Table for Schedule
CREATE TABLE schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    day ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday') NOT NULL,
    time_slot VARCHAR(20) NOT NULL,
    course_id INT,
    section_id INT,
    subject_id INT,
    faculty_id INT,
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (section_id) REFERENCES sections(id),
    FOREIGN KEY (subject_id) REFERENCES subjects(id),
    FOREIGN KEY (faculty_id) REFERENCES faculty(id)
);



 CREATE TABLE batch (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE day_classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    section_id INT NOT NULL,
    day ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday') NOT NULL,
    classes INT NOT NULL CHECK (classes >= 0),
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (section_id) REFERENCES sections(id)
);


INSERT INTO courses(name) VALUES('AI'),('ISE'),('ECE'),('CS');
INSERT INTO sections(name ,semester) VALUES('A',1),('A',3),('B',1),('B',3),('A',5),('A',7),('B',7),('B',5);
INSERT INTO subjects(name) VALUES('Maths'),('English'),('Python'),('Java');
-- INSERT INTO faculty(name ,role) VALUES('Dr.Bhuvaneshwari','Professor'),('Dr.Poornima','Professor'),
-- ('Chaitra','Associate Professor'),('Madhuri','Assistant Professor');




-- Modify the schedule table to store the day and time slot
ALTER TABLE schedule
    MODIFY COLUMN day ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday') NOT NULL,
    MODIFY COLUMN time_slot VARCHAR(20) NOT NULL;

-- Add a table to store configuration for the maximum number of classes per day
CREATE TABLE class_schedule_config (
    id INT AUTO_INCREMENT PRIMARY KEY,
    day ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday') NOT NULL,
    max_classes INT NOT NULL
);

-- Populate the default values for class_schedule_config
INSERT INTO class_schedule_config (day, max_classes)
VALUES
    ('Monday', 7),
    ('Tuesday', 7),
    ('Wednesday', 7),
    ('Thursday', 7),
    ('Friday', 7),
    ('Saturday', 3);

-- Update the faculty table to manage their roles for class allocation
ALTER TABLE faculty
    ADD COLUMN max_classes_per_day INT NOT NULL DEFAULT 0;

-- Populate max_classes_per_day based on the roles (Professor = 1, Associate Professor = 2, Assistant Professor = 2)
UPDATE faculty
SET max_classes_per_day = CASE
    WHEN role = 'Professor' THEN 1
    WHEN role = 'Associate Professor' THEN 2
    WHEN role = 'Assistant Professor' THEN 2
    ELSE 0
END;

-- Ensure faculty assignments don't repeat on the same day for a section
CREATE UNIQUE INDEX unique_schedule
ON schedule (course_id, section_id, day, time_slot)