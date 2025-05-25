# Scoreboard App

## Overview

This is a simple LAMP stack web application designed for a competition scoring system.  
- Admins can add judges via an Admin Panel.  
- Judges can assign scores to participants through a Judge Portal.  
- A public scoreboard displays participants ranked by their total points with dynamic highlighting and auto-refresh.  

---

## Features

- Admin Panel for managing judges  
- Judge Portal to submit scores  
- Public scoreboard with real-time updates (auto-refresh every 10 seconds)  
- Prevents duplicate scoring by the same judge for the same participant  
- Bootstrap 5 styling for a modern, responsive UI  

---

## Technologies Used

- **Linux** (Development on WSL Ubuntu)  
- **Apache** (HTTP server)  
- **MySQL** (Database)  
- **PHP** (Server-side scripting)  
- **Bootstrap 5** (Frontend CSS framework)

---

## Setup & Installation

1. **Clone the repository**

```bash
git clone https://github.com/yourusername/scoreboard_app.git
cd scoreboard_app
```
## Create the database and tables
CREATE DATABASE scoreboard_app;
USE scoreboard_app;

CREATE TABLE judges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    display_name VARCHAR(100) NOT NULL
);

CREATE TABLE participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judge_id INT NOT NULL,
    participant_id INT NOT NULL,
    score INT NOT NULL,
    FOREIGN KEY (judge_id) REFERENCES judges(id),
    FOREIGN KEY (participant_id) REFERENCES participants(id)
);

