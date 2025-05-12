CREATE TABLE students (
    student_id INT PRIMARY KEY,
    full_name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    status ENUM('poor', 'disabled', 'low-income') NOT NULL,
    approved BOOLEAN DEFAULT TRUE
);

CREATE TABLE meals (
    meal_id INT PRIMARY KEY,
    meal_type VARCHAR(50),
    ingredients TEXT,
    meal_day VARCHAR(20),
    pickup_location VARCHAR(100)
);

CREATE TABLE volunteers (
    volunteer_id INT  PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(255),
    notes TEXT
);

CREATE TABLE meal_prep (
    prep_id INT PRIMARY KEY,
    meal_id INT,
    volunteer_id INT,
    prep_date DATE,
    FOREIGN KEY (meal_id) REFERENCES meals(meal_id),
    FOREIGN KEY (volunteer_id) REFERENCES volunteers(volunteer_id)
);

