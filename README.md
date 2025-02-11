# **Yomali Visitor Tracker**

## **Overview**
Yomali Visitor Tracker is a PHP-based backend service that records and analyzes visitor interactions on a website. It includes:
- **API for tracking page visits**
- **Database storage with MySQL**
- **Unit testing with PHPUnit**
- **Dockerized environment for easy setup**

## **Installation Guide**
### **Prerequisites**
Ensure you have the following installed:
- **Docker & Docker Compose**
- **Composer (for dependency management)**

### **Step 1: Clone the Repository**
```sh
git clone https://github.com/vadimianisp/yomali-visitor-tracker.git
cd yomali-visitor-tracker/server-client
```

### **Step 2: Set Up Environment Variables**
Copy the `.env` file template and configure your database settings:
```sh
cp .env.example .env
```

### **Step 3: Start Docker Services**
```sh
docker-compose up -d --build
```
This will start the PHP application and MySQL database inside Docker containers.

### **Step 4: Run Database Migrations**
To create the required tables, run:
```sh
docker-compose exec app php database/migrate.php
```


### **Manually Test API with Postman or cURL**
#### **Track a Page Visit (POST /api/track)**
```sh
curl -X POST http://localhost:8080/api/track \
  -H "Content-Type: application/json" \
  -d '{
    "page_url": "https://mywebsite.com/blog/article-1",
    "referrer": "https://twitter.com",
    "visitor_id": "abc123def456",
    "user_id": null,
    "ip_address": "203.0.113.45",
    "visitor_ip": "192.168.1.20",
    "browser": "Firefox",
    "browser_version": "117.0",
    "device": "Mobile",
    "device_type": "iPhone",
    "os": "iOS",
    "os_version": "17.1",
    "user_agent": "Mozilla/5.0 (iPhone; CPU iPhone OS 17_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1",
    "fingerprint": "hashed_fingerprint_123456",
    "timestamp": 1739292535,
    "api_key": "your_generated_api_key"
  }'

```

#### **Retrieve Visitor Statistics (GET /api/stats)**
```sh
curl -X GET http://localhost:8080/api/visits
```
----------
## **JavaScript client plugin**
```
cd ../client-plugin
```

```
npm install
```

```
npm run build
```
#### Find *index.html* in client-plugin/example folder and double-click on it
(...)

------
## **Shutting Down the Services**
To stop the containers, run:
```sh
docker-compose down
```

