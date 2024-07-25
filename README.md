# Rocket Management
    Rocket Management is a web application built with Laravel Jetstream and Inertia.js.

## Introduction

   This project was generated using Laravel Jetstream and Inertia.js  [ https://jetstream.laravel.com/introduction.html ].
   This README provides instructions on setting up and running the project using Docker.

## Prerequisites
 
     ```bash
   	• Docker
	• Docker Compose
     ```
 

## Development Environment Setup

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/YeeNweWynn/rocket-management.git
    cd rocket-management
    ```

2. **Create a .env File:**
    Copy the `.env.example` file to `.env` and modify it according to your environment:

    ```bash
    cp .env.example .env
    ```

3. **Build and Start Docker Containers:**

    ```bash
    docker-compose up -d
    ```

4. **Install PHP Dependencies:**

    ```bash
    docker-compose exec laravel bash
    composer install
    ```

5. **Install Node.js Dependencies:**

    ```bash
    docker-compose exec node bash
    npm install
    npm run dev
    ```

6. **Run Laravel Migrations:**

    ```bash
    docker-compose exec laravel bash
    php artisan migrate
    ```

7. **Accessing the Application:**

    Open [http://localhost:8080](http://localhost:8080) in your web browser.

## Troubleshooting

- **Database Connection:** Verify `.env` file settings.
- **File Permissions:**

    ```bash
    docker-compose exec laravel bash
    chmod -R 775 storage
    ```

- **Rebuild Containers:**

    ```bash
    docker-compose down
    docker-compose up -d
    ```
            
## Number of Implemented User Scenarios

    1.	User Registration: Users can create a new account by providing their details.
	2.	User Login: Registered users can log in to their accounts using their email and password.
	3.	Profile Management: Users can update their profile information, including their name, email address, and password.
	4.	Rocket Management:
    	•	List Rockets: Display a list of all available rockets.
    	•	Deploy Rocket: Prepare rockets for launch by initiating the deployment process.
    	•	Launch Rocket: Launch a rocket that has been deployed.
    	•	Cancel Rocket: Cancel a scheduled or in-progress rocket mission.
        •	Check Status in Real-Time: Monitor the real-time status of rockets during deployment, launch, and mission phases.
	5.	Weather Feature: Provide weather information for rocket launches, including current conditions and forecasts.

        
    

        
        
    
    
    
