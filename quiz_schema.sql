-- filename: quiz_schema.sql
-- Quiz System Database Schema and Sample Data

CREATE DATABASE IF NOT EXISTS quiz_system;
USE quiz_system;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Quiz topics table
CREATE TABLE quiz_topics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    topic_name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Questions table
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    topic_id INT,
    question_text TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_option CHAR(1) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (topic_id) REFERENCES quiz_topics(id) ON DELETE CASCADE
);

-- Quiz attempts table
CREATE TABLE quiz_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    topic_id INT,
    score INT NOT NULL,
    total_questions INT NOT NULL DEFAULT 10,
    attempt_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (topic_id) REFERENCES quiz_topics(id) ON DELETE CASCADE
);

-- Insert quiz topics
INSERT INTO quiz_topics (topic_name, description) VALUES
('Science', 'Questions related to Physics, Chemistry, Biology and General Science'),
('History', 'Questions about World History, Ancient Civilizations, and Historical Events'),
('General Knowledge', 'Mixed questions covering various topics and current awareness'),
('Current Affairs', 'Questions about recent events, news, and contemporary issues');

-- Insert admin user (password: Admin@123)
INSERT INTO users (username, email, password, is_admin) VALUES 
('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- Insert test user (password: User@123)
INSERT INTO users (username, email, password, is_admin) VALUES 
('testuser', 'user@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0);

-- Sample Science questions
INSERT INTO questions (topic_id, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES
(1, 'What is the chemical symbol for Gold?', 'Go', 'Gd', 'Au', 'Ag', 'c'),
(1, 'Which planet is known as the Red Planet?', 'Venus', 'Mars', 'Jupiter', 'Saturn', 'b'),
(1, 'What is the hardest natural substance on Earth?', 'Iron', 'Diamond', 'Quartz', 'Granite', 'b'),
(1, 'What gas do plants absorb from the atmosphere during photosynthesis?', 'Oxygen', 'Nitrogen', 'Carbon Dioxide', 'Hydrogen', 'c'),
(1, 'What is the speed of light in vacuum?', '300,000 km/s', '150,000 km/s', '450,000 km/s', '200,000 km/s', 'a'),
(1, 'Which organ in the human body produces insulin?', 'Liver', 'Kidney', 'Pancreas', 'Heart', 'c'),
(1, 'What is the smallest unit of matter?', 'Molecule', 'Atom', 'Cell', 'Electron', 'b'),
(1, 'Which blood type is considered the universal donor?', 'A+', 'B+', 'AB+', 'O-', 'd'),
(1, 'What is the process by which plants make their food?', 'Respiration', 'Photosynthesis', 'Digestion', 'Circulation', 'b'),
(1, 'Which gas makes up the majority of Earth\'s atmosphere?', 'Oxygen', 'Carbon Dioxide', 'Nitrogen', 'Argon', 'c'),
(1, 'What is the boiling point of water at sea level?', '90°C', '100°C', '110°C', '120°C', 'b'),
(1, 'Which scientist developed the theory of relativity?', 'Newton', 'Darwin', 'Einstein', 'Galileo', 'c');

-- Sample History questions
INSERT INTO questions (topic_id, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES
(2, 'In which year did World War II end?', '1944', '1945', '1946', '1947', 'b'),
(2, 'Who was the first President of the United States?', 'Thomas Jefferson', 'John Adams', 'George Washington', 'Benjamin Franklin', 'c'),
(2, 'Which ancient civilization built Machu Picchu?', 'Aztecs', 'Maya', 'Inca', 'Olmec', 'c'),
(2, 'The Great Wall of China was primarily built during which dynasty?', 'Han Dynasty', 'Tang Dynasty', 'Ming Dynasty', 'Qing Dynasty', 'c'),
(2, 'Who painted the ceiling of the Sistine Chapel?', 'Leonardo da Vinci', 'Michelangelo', 'Raphael', 'Donatello', 'b'),
(2, 'In which year did the Berlin Wall fall?', '1987', '1988', '1989', '1990', 'c'),
(2, 'Which empire was ruled by Julius Caesar?', 'Greek Empire', 'Roman Empire', 'Persian Empire', 'Ottoman Empire', 'b'),
(2, 'The French Revolution began in which year?', '1789', '1790', '1791', '1792', 'a'),
(2, 'Who was known as the Iron Lady?', 'Margaret Thatcher', 'Queen Elizabeth', 'Angela Merkel', 'Indira Gandhi', 'a'),
(2, 'Which battle marked the end of Napoleon\'s rule?', 'Battle of Austerlitz', 'Battle of Waterloo', 'Battle of Leipzig', 'Battle of Borodino', 'b'),
(2, 'The Renaissance period originated in which country?', 'France', 'Germany', 'Italy', 'Spain', 'c'),
(2, 'Who was the first man to walk on the moon?', 'Buzz Aldrin', 'Neil Armstrong', 'John Glenn', 'Alan Shepard', 'b');

-- Sample General Knowledge questions
INSERT INTO questions (topic_id, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES
(3, 'What is the capital of Australia?', 'Sydney', 'Melbourne', 'Canberra', 'Brisbane', 'c'),
(3, 'Which is the largest ocean on Earth?', 'Atlantic Ocean', 'Indian Ocean', 'Arctic Ocean', 'Pacific Ocean', 'd'),
(3, 'How many continents are there?', '5', '6', '7', '8', 'c'),
(3, 'Which country has the most time zones?', 'Russia', 'USA', 'China', 'Canada', 'a'),
(3, 'What is the currency of Japan?', 'Yuan', 'Won', 'Yen', 'Ringgit', 'c'),
(3, 'Which mountain range contains Mount Everest?', 'Alps', 'Andes', 'Rockies', 'Himalayas', 'd'),
(3, 'What is the smallest country in the world?', 'Monaco', 'Vatican City', 'San Marino', 'Liechtenstein', 'b'),
(3, 'Which river is the longest in the world?', 'Amazon', 'Nile', 'Mississippi', 'Yangtze', 'b'),
(3, 'How many sides does a hexagon have?', '5', '6', '7', '8', 'b'),
(3, 'Which sport is known as "The Beautiful Game"?', 'Basketball', 'Tennis', 'Football/Soccer', 'Cricket', 'c'),
(3, 'What is the largest mammal in the world?', 'African Elephant', 'Blue Whale', 'Giraffe', 'Polar Bear', 'b'),
(3, 'Which language has the most native speakers worldwide?', 'English', 'Spanish', 'Mandarin Chinese', 'Hindi', 'c');

-- Sample Current Affairs questions
INSERT INTO questions (topic_id, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES
(4, 'Which organization was awarded the Nobel Peace Prize in 2020?', 'WHO', 'World Food Programme', 'UNICEF', 'Red Cross', 'b'),
(4, 'What is the name of the COVID-19 vaccine developed by Pfizer?', 'Moderna', 'AstraZeneca', 'BioNTech', 'Johnson & Johnson', 'c'),
(4, 'Which country hosted the 2021 Olympics?', 'China', 'Japan', 'South Korea', 'Australia', 'b'),
(4, 'What is the name of the space telescope launched by NASA in 2021?', 'Hubble', 'James Webb', 'Kepler', 'Spitzer', 'b'),
(4, 'Which country left the European Union in 2020?', 'United Kingdom', 'Italy', 'Poland', 'Hungary', 'a'),
(4, 'What is the name of the electric car company founded by Elon Musk?', 'Rivian', 'Tesla', 'Lucid Motors', 'NIO', 'b'),
(4, 'Which social media platform was banned in several countries in 2020-2021?', 'Facebook', 'TikTok', 'Twitter', 'Instagram', 'b'),
(4, 'What is the name of the cryptocurrency created by Facebook (Meta)?', 'Bitcoin', 'Ethereum', 'Diem (Libra)', 'Dogecoin', 'c'),
(4, 'Which country became the first to land a rover on Mars in 2021?', 'USA', 'China', 'Russia', 'India', 'b'),
(4, 'What is the name of the climate summit held in 2021?', 'COP25', 'COP26', 'COP27', 'COP28', 'b'),
(4, 'Which streaming service released the popular series "Squid Game"?', 'Amazon Prime', 'Netflix', 'Disney+', 'HBO Max', 'b'),
(4, 'What is the name of the billionaire who went to space in 2021?', 'Elon Musk', 'Bill Gates', 'Jeff Bezos', 'Mark Zuckerberg', 'c');
