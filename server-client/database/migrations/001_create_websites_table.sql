CREATE TABLE IF NOT EXISTS websites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255) NOT NULL,
    api_key VARCHAR(255) DEFAULT NULL,
    created_at INT UNSIGNED NOT NULL,

    INDEX idx_url (url),
    INDEX idx_created_at (created_at) -- Indexing for time-based analytics
);
