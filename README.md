# Racitelcom - Payroll Management System Website

## Overview 📌
The **Racitel Payroll Management System** is a comprehensive solution designed for **Racitelcom Inc.** to streamline payroll processing and employee attendance management. This system automates payroll calculations, ensuring accuracy and efficiency in salary generation. Integrated with biometric attendance tracking, the system simplifies recording employee work hours by importing CV files. By automating critical processes, Racitel reduces manual errors, saves time, and ensures seamless management of the workforce.

---

## Sample Website Design Highlight
![Sample Design](overview.png)

---

## Features 📌

### **Admin Dashboard**
- **Total Employee Count**: View the total number of employees.
- **Total Departments**: View the number of active departments.
- **Total Allowances**: Display total allowances across all employees.
- **Total Deductions**: Display total deductions across all employees.
- **Leave Summary**: View the total number of leave requests for today.
- **Monthly Report**: number of report monthly.
- **Upcoming Holidays**: Track any upcoming holidays.

### **Employee Management**
- **CRUD Operations**: Create, read, update, and delete employee listings.

### **Attendance Management**
- **CRUD Operations**: Manage employee attendance records (create, read, update, delete).

### **Payroll Management**
- **CRUD Operations**: Manage payroll records.
- **Download PDF**: Generate and download payroll reports as PDFs.

### **Allowance and Deduction Management**
- **CRUD Operations**: Manage employee allowances and deductions.

### **Maintenance**
- **Department Management**: Create, update, and delete departments.
- **Position Management**: Manage employee positions.
- **Schedule Management**: Set employee schedules.
- **Holiday Management**: Define and manage holidays.
- **Allowance & Deduction Management**: Add or remove allowances and deductions.
- **Leave Management**: Manage employee leave records.

### **Leave Management**
- **Employee Leave**: View and manage the list of employee leave requests.

### **Reports**
- **CRUD Operations**: Create, read, update, delete, and download reports in PDF format.

### **User Management**
- **Role Management**: Update user roles, create new accounts, and disable accounts.

### **HR Account**
- **Limited Access**: HR accounts cannot access maintenance features, ensuring they only manage employee-related functions.

### **Login/Logout**
- **Secure Login**: Allows users to securely log in and log out of the system.

---

## Tech Stack 📌
- **Frontend**: HTML, CSS, Tailwind CSS
- **Backend**: PHP
- **Database**: MySQL

---

## Design Patterns 📌

This system utilizes the following design patterns to ensure maintainability, scalability, and separation of concerns:

### **MVC (Model-View-Controller)**
- The **MVC pattern** divides the application into three interconnected components:
  - **Model**: Responsible for handling the data and business logic, including interactions with the database.
  - **View**: Represents the user interface (UI), presenting the data to users.
  - **Controller**: Acts as an intermediary between the Model and View, processing user input and managing interactions.

### **Facade**
- The **Facade pattern** provides a simplified interface to a complex subsystem, making the system easier to use and maintain. By providing a higher-level interface to the underlying system, it hides the complexity of interactions with various components (like database queries or business logic), improving the ease of use and reducing dependencies.

### **Dependency Injection**
- **Dependency Injection (DI)** is used to manage the dependencies between classes and components. Instead of creating instances of dependencies within classes, objects are passed as dependencies. This improves flexibility, makes the code more testable, and promotes loose coupling between components, allowing easier changes and unit testing.

By combining **MVC**, **Facade**, and **Dependency Injection**, the system maintains a high level of modularity, flexibility, and maintainability, enabling efficient management of employee data and payroll processes.

---

## Additional Features

### **Security** 🔒
The system employs industry-standard security practices to ensure the protection of sensitive information and prevent unauthorized access:

- **JWT (JSON Web Tokens)**: Used for secure user authentication, ensuring each user is validated and authorized to access the system.
- **Password Hashing**: User passwords are securely stored using modern hashing techniques (e.g., bcrypt), preventing the storage of plain-text passwords in the database.
- **Base64 Encoding**: Used for encoding certain data to ensure safe transmission over the network.
- **CSRF Protection**: Implements **Cross-Site Request Forgery (CSRF)** protection to prevent unauthorized requests and ensure that all sensitive actions are secure and originate from authenticated users.
- **Secure Login**: User credentials are transmitted securely over **SSL/TLS** encryption, ensuring that login data is protected from man-in-the-middle attacks.

### **Scalability** 📈
- The system is designed to scale efficiently as your organization grows. It can handle an increasing number of employees, departments, and transactions without compromising performance.
- The **database** structure and backend architecture ensure that the system can be scaled horizontally or vertically to meet growing demands, providing flexibility for future expansion.

---

## Installation Instructions (Racitelcom Project)

1. **Clone the repository:**
    - Clone the Racitelcom repository to your local machine:
        ```bash
        git clone [https://github.com/Ejxzdevs/Racitelcom.git](https://github.com/Ejxzdevs/Racitelcom.git)
        ```

2. **Navigate to the project directory:**
    - Change your current directory to the Racitelcom directory:
        ```bash
        cd Racitelcom
        ```

3. **Install Composer dependencies:**
    - Ensure Composer is installed. If not, download and install it from [getcomposer.org](https://getcomposer.org/download/).
    - Install the required packages:
        ```bash
        composer install
        ```

4. **Configure environment variables:**
    - Create a `.env` file in the project's root directory.
    - Copy and paste the following content into your `.env` file, **adjusting the values to match your specific environment**:
        ```ini
        DB_HOST=localhost       # Change to your database host (e.g., localhost, 127.0.0.1, your server IP)
        DB_USERNAME=root        # Change to your database username
        DB_PASSWORD=            # Change to your database password
        DB_NAME=payroll          # Change to your database name if different
        SECRET_KEY=16f8f95c72e374aed31280e1aad535c159f3be70d91a0875f6ced3ee97de84e2b6d65d77002d254106103986e3c9d1f30ff7093dd7dd73f876a4a4d0d8a748f761fb32826b36334c78c983a08d5262f82087862b8326d07915817578a6617e13ad5ad64370105b6eb5edd4b63cfff8ec409912ce9852a4f4e6e68dc5d199f0af3625a27caa293f3b4913ed7fd658e23e9389fdbeff7bba39e5fa9047bd83d8ab36dd4e82af1ad02b987e6f007a17cdfd7e73a976a98b913d8f3bb37b1ad5cb5b8c4b5396361760f287e4b0ecff4e122fe8e896b9691207b9c5ba344cdc92241e5406d3bb1c6902b79aafc7f5725660ce0f05b6ab8089a3d437d78643981a227d # Use a strong, unique secret key of your choice.
        AES_SECRET_KEY=d5eeb8c8a8f4d3c0e48d75969d57bde731bc22f6f9468fd3e7b8d7aaf63b81c6 # Use a strong, unique AES secret key of your choice.
        ```
    - **Important:** Ensure your PHP code uses a library like `vlucas/phpdotenv` to load these variables.

5. **Database setup:**
    - Since your database file (`payroll`) is in the root directory of the project, you likely have a `.sql` file there.
    - Open your database client (e.g., phpMyAdmin, SQLyog, HeidiSQL, or command-line MySQL client).
    - Create a database named `payroll` on your MySQL server.
    - Import the `payroll` database from the `.sql` file located in your project's root directory.

6. **Web server configuration (Laragon/XAMPP):**
    - **Laragon:**
        - Move the `Racitelcom` folder into your Laragon's `www` directory.
        - Laragon should automatically detect the new project. If not, restart Laragon.
        - Access the application via `http://racitelcom.test` (or the URL you've configured in Laragon).
    - **XAMPP:**
        - Move the `Racitelcom` folder into your XAMPP's `htdocs` directory.
        - Access the application via `http://localhost/Racitelcom/public` (if your public directory is in a subdirectory called public) or `http://localhost/Racitelcom/` if the index.php is in the root of the racitelcom folder.

7. **Access the application:**
    - Open your web browser and navigate to the configured URL (e.g., `http://racitelcom.test` for Laragon, or `http://localhost/Racitelcom/public` or `http://localhost/Racitelcom/` for XAMPP).