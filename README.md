## Overview

The Event Management System is a web-based application designed to facilitate the management of events. It enables three distinct types of users, each with their own set of permissions and functionalities:

- **Super Admin**: The highest level of access, with full control over the system. Super Admins can manage events, assign and update user roles, and delete users. They have complete oversight and administrative capabilities.
  
- **Admin**: Admins can manage events by performing CRUD (Create, Read, Update, Delete) operations through an intuitive admin dashboard. They have the authority to handle event logistics but do not have control over user roles.

- **Attendee**: Regular users who can register and sign up for events. Attendees can browse and join events based on their interests and availability.

## Setup Instructions

### 1. Clone the Repository
Clone the repository to your local machine:

```bash
git clone https://github.com/sheikhjaber0424/event-management.git
```

### 2. Configure Database
- Create a MySQL database named `event_management`.
- Add your MySQL server credentials (host, port, database name, username, and password) in `core/config.php`.

### 3. Run Seeder Script
Run the following command to create three tables (users, events, event_registration) and insert three users:

```bash
php core/seeder.php
```

| Role | Email | Password |
| :---         |     :---      |          :--- |
| Super Admin   | super@admin.com     | super1234    |
| Admin     | admin@gmail.com      | admin1234      |
| Attendee     | attendee@gmail.com       | attendee1234      |

### 4. Start the Server
Start a local PHP server using:

```bash
php -S localhost:8000
```
### 5. Access the Application
Open your browser and go to:

[http://localhost:8000/](http://localhost:8000/)

This will display the homepage.

### 6. JSON API Endpoints

- **Get All Events**  
  **Route**: `GET /api/events`  
  This endpoint returns a list of all events in JSON format.

- **Get Specific Event Details**  
  **Route**: `GET /api/events/{id}`  
  This endpoint returns the details of a specific event by its ID.


## Features

- **User Authentication**: Users can register and log in.
- **Event Management**: Admins can create, update, and delete events.
- **User Role Management**: Super Admin can upgrade attendees to admins and delete users.
- **Event Registration**: Attendees can register for events.
- **Max Capacity for Events**: After the event capacity is full, attendees won't be able to register.
- **Admin Report Generation**: Admins can generate reports in CSV format for events from the dashboard, including event details.
