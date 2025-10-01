USE jason;

CREATE TABLE students (
    roll_no VARCHAR(20) PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    room_no VARCHAR(10) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roll_no VARCHAR(20) NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    status VARCHAR(20) DEFAULT 'Absent' NOT NULL,
    CONSTRAINT fk_attendance FOREIGN KEY (roll_no) REFERENCES students(roll_no) ON DELETE CASCADE
);

CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(20) NOT NULL
);
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
