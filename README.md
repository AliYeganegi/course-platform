# Course Platform

A Laravel-based online course management platform that allows administrators to create and manage courses, institutions, quizzes, and enrollments, and enables students to browse courses, register, enroll, comment, and take quizzes.

## Features

- **Multi-Tenant**: Institutions and courses
- **User Roles**: Admin, Institution, Student
- **Course Catalog**: Create, edit, delete courses, with rich descriptions, media, and disciplines
- **Enrollment Workflow**: Students request enrollment; admins accept/reject
- **Quizzes/Examinations**: Define quizzes with links, schedules, durations, attempts, points
- **Comments & Likes**: Students can comment, reply, and like comments on courses
- **Notifications & Emails**: Auto emails on enrollment and quiz creation
- **Media Management**: Course images via Spatie Media Library
- **Internationalization**: English/Farsi support

## Requirements

- PHP 8.0+
- Composer 2.x
- MySQL 5.7+ (or MariaDB)
- Node.js 16+ & NPM
- Redis (optional, for queues)
- A web server (Apache/Nginx)

## Installation

1. **Clone the repository**:

   ```bash
   git clone https://github.com/your-username/course-platform.git
   cd course-platform
   ```

2. **Install PHP dependencies**:

   ```bash
   composer install --optimize-autoloader --no-dev
   ```

3. **Install JavaScript dependencies**:

   ```bash
   npm install
   ```

4. **Environment Configuration**:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Edit `.env` with your database and mail credentials:
   ```dotenv
   APP_NAME="CoursePlatform"
   APP_ENV=production
   APP_URL=https://your-domain.com

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=course_platform
   DB_USERNAME=dbuser
   DB_PASSWORD=secret

   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailgun.org
   MAIL_PORT=587
   MAIL_USERNAME=your_mail_username
   MAIL_PASSWORD=your_mail_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=no-reply@your-domain.com
   MAIL_FROM_NAME="CoursePlatform"
   ```

5. **Create database and run migrations & seeders**:

   ```bash
   php artisan migrate --seed
   ```

6. **Link storage**:

   ```bash
   php artisan storage:link
   ```

7. **Compile assets**:

   - For development:
     ```bash
     npm run dev
     ```
   - For production:
     ```bash
     npm run build
     ```

## Server Configuration

### Nginx Example

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/course-platform/public;

    index index.php;
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

### Apache Example

Enable mod_rewrite and set virtual host:
```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot "/var/www/course-platform/public"

    <Directory "/var/www/course-platform/public">
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/course-platform_error.log
    CustomLog ${APACHE_LOG_DIR}/course-platform_access.log combined
</VirtualHost>
```

## Queue Worker & Scheduler

- **Scheduler**: Add to crontab:
  ```cron
  * * * * * cd /var/www/course-platform && php artisan schedule:run >> /dev/null 2>&1
  ```

- **Queue Worker** (if using Redis/email jobs):
  ```bash
  php artisan queue:work --daemon --sleep=3 --tries=3
  ```

## Creating Admin User

By default, seeded users include an admin. To create another:

```bash
php artisan tinker
>>>
>>> \App\User::create([
...     'name' => 'Admin Name',
...     'email' => 'admin@domain.com',
...     'password' => bcrypt('strong-password'),
... ]);
>>>
>>> $user = \App\User::where('email','admin@domain.com')->first();
>>> $user->roles()->attach(1); // assuming role ID 1 = admin
```

## Usage

- **Public Pages**: Browse courses, view details, register, login, enroll, comment, take quizzes.
- **Admin Panel** (`/admin`): Manage users, roles, institutions, disciplines, courses, enrollments, examinations.

## Additional Notes

- **Localization**: Supported locales in `resources/lang/en` and `resources/lang/fa`.
- **Media Library**: Images & files stored in `storage/app/public`.

---

Happy teaching and learning!

