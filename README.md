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
