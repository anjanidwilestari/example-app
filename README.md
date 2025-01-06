# Example-App

This is a learning project built with **Laravel 10**, **Vue.js**, and **Inertia.js**. It is an exploration into creating a fullstack-web application with a clean architecture, handling dynamic content, and integrating maps for visualizing data. (Learning to create an admin website that can manage the user's website display).

## Features

- **Dynamic Product Display**: (CRUD) Show product details, including books, testimonials, and reasons for choosing the service.
- **Map Integration**: Displays an interactive map showing distributor locations across various provinces and islands.
- **Responsive Design**: The application is designed to be responsive, adapting seamlessly to different screen sizes.
- **State Management**: Utilizes Vue’s reactive features for real-time updates and dynamic data display.
- **Tailwind CSS**: The app uses Tailwind CSS for styling, ensuring a modern, clean, and customizable UI.

## Technologies Used

- **Backend**: Laravel 10
- **Frontend**: Vue.js, Inertia.js, Tailwind CSS, Laravel-Breeze
- **Map**: D3.js for creating the interactive map, integrated with the app to display distributor data.
- **Database**: (Mysql) Custom database models for products, testimonials, reasons, and distributors.

## Installation

1. **Clone the repository**:

   ```bash
   git clone https://github.com/anjanidwilestari/example-app.git
   cd example-app

2. **Install dependencies**:

   ```bash
   composer install
   npm install

3. **Set up the environment**:

   ```bash
   cp .env.example .env
   <!-- Update the .env file with your database information -->
   php artisan key:generate

4. **Run the migrations**:
   
   ```bash
   php artisan migrate

5. **Set up symlink (symbolic link)**:
   
   ```bash
   php artisan storage:link

6. **Seeding**:

   ```bash
   <!-- (optinonal) -->
   php artisan db:seed 
  

7. **Run the app**:

   ```bash
   npm run dev
   php artisan serve