# Human Resource Information System (HRIS)

A comprehensive, web-based HRIS application built with Laravel 11, designed to manage employee data, organizational structure, attendance, and leave requests for multi-branch organizations.

## Features

### 🌟 Core HR Management
- **Organization Structure**: Manage multiple branches (Yayasan, Malaka, ITBU), departments, and positions.
- **Employee Management**: Complete employee lifecycle management with multi-assignment support (History, Transfer, Promotion).
- **Dashboard**: specialized dashboards for HR Administrators and standard Employees.

### 🔐 Role-Based Access Control (RBAC)
- **Super Admin / HR Staff**: Full access to employee data, attendance uploads, and configuration.
- **Division Manager**: View team data and approve leave requests.
- **Employee**: Self-service portal to view profile, attendance history, and request leave.

### 📅 Attendance & Leave
- **Attendance Monitoring**:
  - **Upload Module**: HR uploads attendance logs (CSV/Excel) from fingerprint devices.
  - **History View**: Employees can view their daily attendance status (Present, Late, Absent).
  - **Validation**: Prevents duplicate entries and verifies employee existence during upload.
- **Leave Management** (In Progress):
  - Annual, Sick, and Unpaid leave tracking.
  - Balance calculation and history.

### 🛠 Tech Stack
- **Framework**: Laravel 11.x
- **Frontend**: Blade + Livewire + TailwindCSS (Enterprise Design System)
- **Database**: MySQL 8.0
- **Authentication**: Laravel Sanctum with Spatie Permission for Roles.

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- Docker (for MySQL database)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd hris
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Update `.env` with your database credentials.

4. **Start Database (Docker)**
   ```bash
   docker start hris-mysql
   # Or create a new container if needed
   ```

5. **Run Migrations & Seeders**
   This project uses a robust seeding strategy to populate the database with essential data.
   ```bash
   php artisan migrate:fresh --seed
   ```
   **Note**: The default seeder (`DatabaseSeeder`) runs:
   - `OrganizationSeeder`: Creates Branches, Departments, Positions.
   - `LeaveTypeSeeder`: Creates standard leave types.
   - `RolePermissionSeeder`: Sets up Roles (Super Admin, HR, Manager, Employee) and Permissions.
   - `UpdateAdminEmployeeSeeder`: Creates the default Admin employee profile.

6. **Serve Application**
   ```bash
   npm run build
   php artisan serve
   ```

## Usage Guide

### 1. HR Dashboard (Admin)
- **URL**: `/dashboard/hr`
- **Login**: `admin@hris.test` / `password`
- **Key Actions**:
  - **Upload Attendance**: Go to Dashboard > click "Upload Attendance". Upload a CSV file with format `EmployeeNumber,Date,ClockIn,ClockOut`.
  - **Manage Employees**: Create, edit, and assign employees to branches/positions.

### 2. Employee Dashboard
- **URL**: `/dashboard/employee`
- **Login**: Use employee credentials.
- **Key Actions**:
  - **My Attendance**: View read-only history of attendance records uploaded by HR.
  - **Leave Request**: (Coming Soon) Request time off.

## Architecture

This project follows a **Modular Monolith** approach:
- **Models**: Usage of `BaseModel` trait for Audit Logs and Soft Deletes.
- **Services/Controllers**: Logic separated by domain (Attendance, Employee, Organization).
- **Design System**: Custom CSS variables for enterprise-grade UI consistency.

## Contributing

Please follow the PSR-12 coding standard and ensure all new features include appropriate migrations and seeders.

## License

Private / Proprietary Software.
