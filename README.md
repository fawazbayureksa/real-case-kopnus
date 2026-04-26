## Arsitektur Sistem

Sistem ini menggunakan Laravel 12 dan beberapa library:

- **Laravel 12**: Framework utama untuk membangun aplikasi web.
- **Laravel Fortify**: Library laravel untuk Authentication,Support untuk Login page, Register,Forgot Password, 2FA
- **Spatie**: Untuk access dan permission untuk Admin dan User (set up di seeder) Authorization.
- **Laravel Excel**: Untuk menangani upload data menggunakan background processing (Queue) support Chunk dan batch process.
- **Dashboard**: Dashboard Chart.js.
- **Bootstrap** UI Framework.

---

## Setup Project

### Requirement

- PHP 8.2+
- Composer
- Node.js & NPM
- Database (MySQL)
- Git CLI

### Step Installasi

1. **Clone & Install Dependencies**

    ```bash
    git clone https://github.com/fawazbayureksa/real-case-kopnus.git
    ```

    ```bash
    composer install
    npm install && npm run build
    ```

2. **Environment Setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    _Atur konfigurasi database di file `.env`._

3. **Run Database Migration & Seed**

    ```bash
    php artisan migrate --seed
    ```

4. **Run Queue**
   Upload data diproses di background. Jalankan worker ini:

    ```bash
    php artisan queue:work
    ```

5. **Start Application**
    ```bash
    php artisan serve
    ```

---

## Default Akun

**Admin (Full Access)**

- Email: `superadmin@mail.com`
- Pass: `12345678`

**User (Read Only)**

- Email: `user@mail.com`
- Pass: `12345678`
