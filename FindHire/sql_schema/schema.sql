-- CREATE TABLE users (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     username VARCHAR(255) NOT NULL,
--     first_name VARCHAR(255) NOT NULL,
--     last_name VARCHAR(255) NOT NULL,
--     email VARCHAR(255) NOT NULL UNIQUE,
--     password VARCHAR(255) NOT NULL,
--     role ENUM('applicant', 'hr') NOT NULL, -- Role-based access
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );


-- CREATE TABLE job_posts (
--     job_posts_id INT AUTO_INCREMENT PRIMARY KEY,
--     title VARCHAR(255) NOT NULL,
--     description TEXT NOT NULL,
--     created_by INT NOT NULL, -- Foreign key (HR ID)
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
-- );


-- CREATE TABLE applications (
--     applications_id INT AUTO_INCREMENT PRIMARY KEY,
--     job_post_id INT NOT NULL, -- Foreign key (Job Post ID)
--     applicant_id INT NOT NULL, -- Foreign key (Applicant ID)
--     status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending', -- Application status
--     resume_path VARCHAR(255) NOT NULL, -- Path to uploaded resume
--     submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (job_post_id) REFERENCES job_posts(id) ON DELETE CASCADE,
--     FOREIGN KEY (applicant_id) REFERENCES users(id) ON DELETE CASCADE
-- );


-- CREATE TABLE messages (
--     messages_id INT AUTO_INCREMENT PRIMARY KEY,
--     sender_id INT NOT NULL, -- Foreign key (User ID)
--     receiver_id INT NOT NULL, -- Foreign key (User ID)
--     content TEXT NOT NULL, -- Message content
--     timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Message timestamp
--     FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
--     FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
-- );

-- CREATE TABLE notifications (
--     notification_id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each notification
--     user_id INT NOT NULL,                           -- ID of the user receiving the notification
--     job_post_id INT DEFAULT NULL,                  -- ID of the related job post (optional)
--     message TEXT NOT NULL,                         -- Content of the notification
--     status ENUM('Unread', 'Read') DEFAULT 'Unread', -- Status of the notification
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Time the notification was created
--     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, -- Ensure user deletion removes notifications
--     FOREIGN KEY (job_post_id) REFERENCES job_posts(job_posts_id) ON DELETE CASCADE -- Optional link to job posts
-- );



-- CREATE INDEX idx_role ON users(role);
-- CREATE INDEX idx_job_post ON applications(job_post_id);
-- CREATE INDEX idx_applicant ON applications(applicant_id);
-- CREATE INDEX idx_sender_receiver ON messages(sender_id, receiver_id);

-- -- Cascade Delete: Ensures that related entries (e.g., applications/messages) are automatically deleted if a parent record (e.g., user or job post) is removed.


-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY, -- User ID
    username VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE, -- User email
    password VARCHAR(255) NOT NULL, -- User password
    role ENUM('applicant', 'hr') NOT NULL, -- Role-based access
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Account creation timestamp
);

-- Job Posts Table
CREATE TABLE job_posts (
    job_posts_id INT AUTO_INCREMENT PRIMARY KEY, -- Job post ID
    title VARCHAR(255) NOT NULL, -- Job title
    description TEXT NOT NULL, -- Job description
    created_by INT NOT NULL, -- Foreign key (HR ID)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Creation timestamp
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE -- Deletes job posts if HR is deleted
);

-- Applications Table
CREATE TABLE applications (
    applications_id INT AUTO_INCREMENT PRIMARY KEY, -- Application ID
    job_post_id INT NOT NULL, -- Foreign key (Job Post ID)
    applicant_id INT NOT NULL, -- Foreign key (Applicant ID)
    status ENUM('Pending', 'Accepted', 'Rejected') DEFAULT 'Pending', -- Application status
    messages VARCHAR(255),
    resume_path VARCHAR(255) NOT NULL, -- Path to uploaded resume
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Submission timestamp
    FOREIGN KEY (job_post_id) REFERENCES job_posts(job_posts_id) ON DELETE CASCADE, -- Deletes applications if job post is deleted
    FOREIGN KEY (applicant_id) REFERENCES users(id) ON DELETE CASCADE -- Deletes applications if user is deleted
);

-- Messages Table
CREATE TABLE messages (
    messages_id INT AUTO_INCREMENT PRIMARY KEY, -- Message ID
    sender_id INT NOT NULL, -- Foreign key (Sender ID)
    receiver_id INT NOT NULL, -- Foreign key (Receiver ID)
    content TEXT NOT NULL, -- Message content
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Message timestamp
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE, -- Deletes messages if sender is deleted
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE -- Deletes messages if receiver is deleted
);

-- Notifications Table
CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY, -- Notification ID
    user_id INT NOT NULL, -- Foreign key (User ID)
    job_post_id INT DEFAULT NULL, -- Foreign key (Job Post ID, optional)
    message TEXT NOT NULL, -- Notification content
    status ENUM('Unread', 'Read') DEFAULT 'Unread', -- Notification status
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Creation timestamp
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, -- Deletes notifications if user is deleted
    FOREIGN KEY (job_post_id) REFERENCES job_posts(job_posts_id) ON DELETE CASCADE -- Deletes notifications if job post is deleted
);

-- Indexes
CREATE INDEX idx_role ON users(role); -- For faster role-based queries
CREATE INDEX idx_job_post ON applications(job_post_id); -- For faster lookups by job post
CREATE INDEX idx_applicant ON applications(applicant_id); -- For faster lookups by applicant
CREATE INDEX idx_sender_receiver ON messages(sender_id, receiver_id); -- For sender-receiver queries
CREATE INDEX idx_job_applicant ON applications(job_post_id, applicant_id); -- Composite index for job-applicant queries

ALTER TABLE messages
ADD COLUMN job_post_id INT NULL AFTER content, -- Add the job_post_id column after content
ADD CONSTRAINT fk_job_post_id FOREIGN KEY (job_post_id) REFERENCES job_posts(job_posts_id) ON DELETE CASCADE;

