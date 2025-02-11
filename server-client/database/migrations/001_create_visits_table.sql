CREATE TABLE IF NOT EXISTS visits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255) NOT NULL,
    referrer VARCHAR(255) DEFAULT NULL,
    visitor_id VARCHAR(64) NOT NULL,  -- Unique identifier for a visitor (browser fingerprint or assigned ID)
    user_id VARCHAR(64) DEFAULT NULL, -- If identified, links to an actual user
    ip_address VARCHAR(45) NOT NULL,  -- Stores IPv4/IPv6
    browser VARCHAR(100) NOT NULL,    -- Browser name/version
    device VARCHAR(100) NOT NULL,     -- Device type (mobile, desktop, tablet)
    os VARCHAR(50) NOT NULL,          -- Operating system (Windows, macOS, Linux, etc.)
    user_agent TEXT NOT NULL,         -- Full user-agent string for debugging
    fingerprint VARCHAR(255) DEFAULT NULL, -- Unique browser/device fingerprint
    timestamp INT UNSIGNED NOT NULL,  -- UNIX timestamp for efficient time-based queries

    INDEX idx_visitor_url (visitor_id, url), -- For fast unique visit tracking per visitor per page
    INDEX idx_user (user_id),  -- Allows efficient user-based analytics
    INDEX idx_timestamp (timestamp) -- Indexing for time-based analytics
);
