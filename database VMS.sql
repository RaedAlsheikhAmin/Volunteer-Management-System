Drop DATABASE volunteer_management;

CREATE DATABASE volunteer_management;

USE volunteer_management;


CREATE TABLE volunteers (
    volunteer_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,  -- This is the foreign key reference to the users table
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    email VARCHAR(100),
    phone_number VARCHAR(20),
    date_of_birth DATE,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);


CREATE TABLE events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    event_location VARCHAR(255),
    event_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE tasks (
    task_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    task_name VARCHAR(255) NOT NULL,
    task_description TEXT,
    start_time DATETIME,
    end_time DATETIME,
    max_volunteers INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE
);


CREATE TABLE assignments (
    assignment_id INT AUTO_INCREMENT PRIMARY KEY,
    volunteer_id INT,
    task_id INT,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('assigned', 'in_progress', 'completed') DEFAULT 'assigned',
    FOREIGN KEY (volunteer_id) REFERENCES volunteers(volunteer_id) ON DELETE CASCADE,
    FOREIGN KEY (task_id) REFERENCES tasks(task_id) ON DELETE CASCADE
);

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'volunteer') DEFAULT 'volunteer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


--Inserting VALUES

-- Insert sample volunteer
INSERT INTO volunteers (first_name, last_name, email, phone_number, date_of_birth, address)
VALUES ('Raed', 'Amin', 'raed.amin@gmail.com', '123456789', '2001-05-12', 'Alepo Azaz');

-- Insert sample event
INSERT INTO events (event_name, event_date, event_location, event_description)
VALUES ('Charity Run', '2024-11-15', 'Central Park', 'A charity marathon for raising funds.');

-- Insert sample task for the event
INSERT INTO tasks (event_id, task_name, task_description, start_time, end_time, max_volunteers)
VALUES (1, 'Water Station Setup', 'Set up water stations for runners.', '2024-11-15 07:00:00', '2024-11-15 09:00:00', 5);

-- Assign a volunteer to the task
INSERT INTO assignments (volunteer_id, task_id, status)
VALUES (1, 1, 'assigned');
