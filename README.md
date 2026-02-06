# Beneficiary Registration and Project Tracking Module

## System Overview

This project is a **Beneficiary Registration and Project Tracking module** built on **CodeIgniter 4**. It is designed for NGOs and social programs to:

- Register **beneficiaries and households** with demographic and socioeconomic information.
- Define **projects and interventions** (services, activities, trainings, etc.).
- Record **attendance and events** for interventions and beneficiaries.
- Track **beneficiary progress** over time via baseline and follow-up data.
- Manage **case notes, referrals, and alerts** for high-risk or overdue follow-ups.
- Provide a **dashboard** summarizing key information for logged-in users.

### Main Functional Areas

- **Beneficiaries & Households**
  - CRUD for beneficiaries.
  - Household linkage with code, vulnerability status, income level, and family size.
  - Photo upload for beneficiaries.
  - Baseline data: education, health, livelihood, nutrition, income, baseline date.

- **Projects & Interventions**
  - Projects with basic metadata (name, description, timeline).
  - Interventions linked to projects, representing concrete services/activities.
  - Beneficiary–intervention associations to track who received what.

- **Attendance & Events**
  - Events for interventions (dates, locations, etc.).
  - Attendance records linking beneficiaries to events.
  - Progress updates related to events and/or interventions.

- **Case Management**
  - Case notes per beneficiary with risk level, follow-up dates, and status.
  - Referrals to other services, with follow-up dates and high-risk flags.
  - Alerts screen that surfaces:
    - Overdue case notes.
    - Pending referrals past follow-up date.
    - High-risk cases and referrals.

- **Users & Authentication**
  - Basic user accounts (see the `CreateUsersTable` migration).
  - Session-based authentication with a login form.
  - Simple “my dashboard” view tied to the logged-in user.

---

## Deployment and Setup Instructions

### Requirements

- **PHP** 8.2+ with:
  - `intl`, `mbstring`, `json`, `curl`, `mysqlnd`.
- **Database**: MySQL
- **Composer** for dependency management.
- Web server pointing to the `public` directory (Apache, Nginx, IIS, etc.).

### 1. Install Dependencies

From the project root:

```bash
composer install
```

### 2. Configure Environment

1. Copy the example env file:

   ```bash
   cp .env .env
   ```

2. Edit `.env` and set at minimum:

   - **Base URL** (required for production): Set this to your real site URL so redirects and links use the correct host. For local dev use `http://localhost:8080/`.

     ```ini
     app.baseURL = 'https://yourdomain.com/'
     ```

   - **Database** (example for MySQL):

     ```ini
     database.default.hostname = localhost
     database.default.database = your_database_name
     database.default.username = your_username
     database.default.password = your_password
     database.default.DBDriver = MySQLi
     ```

3. Set environment:

   ```ini
   CI_ENVIRONMENT = development
   ```

### 3. Run Database Migrations

From the project root:

```bash
php spark migrate
```

This will create tables such as:

- `users`
- `households`
- `beneficiaries`
- `projects`
- `interventions`
- `beneficiary_interventions`
- `beneficiary_attendance`
- `beneficiary_progress_updates`
- `case_notes`
- `events`
- `referrals`
- `beneficiary_baselines`
- and related tables.

### 4. Seed Demo Data (Optional)

```bash
php spark db:seed DemoSeeder
```

This populates:

- Demo user accounts.
- Sample projects and interventions.
- Example households and beneficiaries.
- Example events, attendance, progress, case notes, and referrals.

Check `DemoSeeder` for default credentials and sample data.

### 5. Run the Application

```bash
php spark serve
```

Then open in your browser:

```text
http://localhost:8080/
```

Log in using the seeded demo user credentials, then navigate through:

- `/dashboard` – main user dashboard.
- `/beneficiaries` – beneficiary list and registration.
- `/projects` – project and intervention lists.
- `/attendance` – events and attendance.
- `/alerts` – high-risk/overdue alerts and follow-ups.

---

## Key Technical and Architectural Decisions

### Framework and Structure

- **CodeIgniter 4 MVC**:
  - Controllers in `app/Controllers` handle HTTP requests and prepare data.
  - Models in `app/Models` handle database operations using CI4’s `Model` base class.
  - Views in `app/Views` provide HTML/PHP templates.

- **Database-first design with migrations**:
  - All core tables are defined via migration files in `app/Database/Migrations`.
  - This supports reproducible, versioned schema across environments.

- **Seeded demo environment**:
  - `DemoSeeder` creates a realistic dataset for quick demos and testing.

### Domain Modelling

- **Households and Beneficiaries**
  - Separate `households` and `beneficiaries` tables, linked by `household_id`.
  - Beneficiaries can be registered with or without full household details; minimal household data is supported.

- **Projects and Interventions**
  - `projects` for higher-level initiatives.
  - `interventions` for specific services within a project.
  - `beneficiary_interventions` as a junction table for many-to-many relationships.

- **Case Management and Alerts**
  - `case_notes` and `referrals` track qualitative data, risk levels, and follow-up dates.
  - `Alerts` controller composes “overdue” and “high risk” lists from those tables.
  - Beneficiary lookup table is built in memory per request to efficiently map IDs to names/UIDs on the alerts screen.

- **Attendance and Progress Tracking**
  - `events` represent dated activities (e.g., sessions, meetings, trainings).
  - `beneficiary_attendance` links beneficiaries to events.
  - `beneficiary_progress_updates` stores periodic progress snapshots.

- **Identifiers**
  - Beneficiaries get a generated UID like `BEN-YYYY-XXXXXX`.
  - Households can have generated codes like `HH-YYYY-XXXXXX`.

### Application Concerns

- **Authentication**
  - Session-based login via an `Auth` controller.
  - A `role` field in `users` is available for future access control.

- **File Uploads**
  - Beneficiary photos uploaded to `public/uploads/beneficiaries`.
  - Paths are stored in the database; directories are created on demand.

- **Validation**
  - Server-side validation uses CodeIgniter’s validation rules within controllers and models.
  - Various fields use `integer`, `in_list`, or `permit_empty` rules as appropriate.

---

## Assumptions, Limitations, and Known Issues

### Assumptions

- **Single organization context**:
  - The system assumes one implementing organization; no multi-tenant separation is implemented.
- **Trusted internal users**:
  - Intended for trained staff within an organization, not for public self-registration.
- **Basic security model**:
  - HTTPS, secure cookies, and session hardening are expected to be configured at the environment/framework level.

### Limitations

- **Role-based access control is minimal**:
  - The `users` table has a `role` field, but there is no full, fine-grained authorization layer yet.
- **No advanced reporting/analytics**:
- **File storage**:
  - Photos are stored locally in `public/uploads`; there is no built-in cloud storage integration.
- **Internationalization (i18n)**:
  - UI text is primarily English; language packs are not fully developed.

### Known Issues / To-Do

- **Tighten validation** for some fields (identification numbers, contact details, etc.).
- **Improve soft-delete workflows** in the UI where models support soft deletes.
- **Enhance auditability** if per-field change history is required in the future.
