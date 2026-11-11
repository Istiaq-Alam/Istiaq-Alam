You are an expert Full-Stack PHP & Laravel Engineer. Your task is to convert my existing static portfolio website (located in `./static`) into a complete, dynamic PHP Laravel + SQLite application (located in `./portfolio`) with an interactive Admin Dashboard, database seeding of all existing static content, and full Vercel Serverless PHP deployment configuration.

---

### 1. WORKSPACE & DIRECTORY CONTEXT
- **Source Static Website (`./static`)**: Contains my existing HTML (`index.html`), CSS, JavaScript, and images/icons for `https://www.istiaq-alam.me/`.
- **Target Laravel Application (`./portfolio`)**: An initialized Laravel project already configured with SQLite (`./portfolio/database/database.sqlite`).
- **Rule**: Do NOT modify or delete files inside `./static`. Copy and adapt everything into `./portfolio`.

---

### 2. STEP-BY-STEP EXECUTION PLAN

#### PHASE 1: Inspect `./static` & Migrate Frontend Assets
1. Read `./static/index.html` and inspect all asset directories (`assets/css`, `assets/js`, `assets/images`, etc.) inside `./static`.
2. Copy all static assets (CSS, JS, images, icons, resume PDFs) from `./static/` into `./portfolio/public/assets/` (preserving their relative folder structure so all existing styles, client-side tab switching, modals, and category filtering work identically).
3. Convert `./static/index.html` into `./portfolio/resources/views/portfolio.blade.php`:
   - Replace hardcoded relative asset links with Laravel `{{ asset('...') }}` helpers (while also supporting Base64 Data URI strings or external URLs for newly uploaded database images).
   - Keep all HTML classes, `data-*` attributes (`data-filter-item`, `data-category`, `data-nav-link`, `data-page`, modal attributes), and Ionicons intact so the vanilla JS tab navigation (`About`, `Resume`, `Projects`, `Research`, `Contact`) and category filtering (`All`, `CyberSecurity`, `Applications`, `Web development`, `Learn`) work without any regressions.

#### PHASE 2: Database Schema & Models (SQLite)
Create migrations and Eloquent models inside `./portfolio` for the following tables:
1. **`projects` table (`Project` model)**:
   - `id`
   - `title` (string)
   - `category` (string — e.g., `CyberSecurity`, `Applications`, `Web development`, `Learn`)
   - `sub_category` (string, nullable — e.g., `Web Applications` if displayed on card)
   - `description` (text, nullable — for Github Projects showcase / modal details)
   - `project_url` (string, nullable — GitHub or live link)
   - `thumbnail` (longText — stores either `assets/images/...` path for seeded items OR `data:image/...;base64,...` for new admin uploads)
   - `is_github_featured` (boolean, default false — whether it also appears in the "Github Projects" section under the About tab)
   - `sort_order` (integer, default 0)
   - `timestamps`
2. **`researches` table (`Research` model)**:
   - `id`
   - `title` (string)
   - `category` (string — e.g., `Machine Learning`, `Networking`, `Learn`, `Microprocessor`, `Hardware`)
   - `published_date` (string — e.g., `June 21, 2026`, `June 03, 2025`)
   - `description` (text)
   - `research_url` (string, nullable)
   - `thumbnail` (longText — stores asset path or Base64 image data)
   - `sort_order` (integer, default 0)
   - `timestamps`
3. **`skills` table (`Skill` model)**:
   - `id`
   - `name` (string — e.g., `Graphics designing`, `Shell`, `Ethical Hacking`, `Burp Suite`, `Nmap`, etc.)
   - `percentage` (integer — e.g., 85, 70, 80, 60)
   - `sort_order` (integer, default 0)
   - `timestamps`
4. **`certificates` table (`Certificate` model)**:
   - `id`
   - `title` (string)
   - `image` (longText — stores asset path or Base64 image data)
   - `credential_url` (string, nullable)
   - `sort_order` (integer, default 0)
   - `timestamps`
5. **`messages` table (`Message` model)**:
   - `id`
   - `fullname` (string)
   - `email` (string)
   - `message` (text)
   - `is_read` (boolean, default false)
   - `timestamps`

Add a helper accessor (e.g., `$project->thumbnail_url`) on `Project`, `Research`, and `Certificate` models:
- If the value starts with `data:image` or `http`, return it directly.
- Otherwise, return `asset($value)`.

#### PHASE 3: Seed All Existing Data from `./static/index.html`
Create a comprehensive `DatabaseSeeder` in `./portfolio/database/seeders/DatabaseSeeder.php` that parses and seeds **100% of the existing content** from `./static/index.html`:
- Seed an Admin User into the `users` table:
  - Email: `istiak.apk@gmail.com`
  - Password: `Hash::make(env('ADMIN_PASSWORD', 'Admin@12345'))`
- Seed all existing **Projects** (both the Github Projects on the About tab and all items in the Projects tab grid, matching their exact titles, categories, descriptions, links, and existing image paths).
- Seed all existing **Research** items (exact titles, categories, dates, descriptions, and image paths).
- Seed all existing **Skills** and **Certificates**.
- Use `updateOrCreate` in the seeder so running `php artisan db:seed` is idempotent and never creates duplicates.
- Run `php artisan migrate:fresh --seed` on `./portfolio/database/database.sqlite` and verify all records exist.

#### PHASE 4: Public Portfolio Controller & Contact Form
1. Create `PortfolioController@index` at route `GET /` that loads `projects`, `githubProjects` (`where('is_github_featured', true)`), `researches`, `skills`, and `certificates` ordered by `sort_order` and passes them to `portfolio.blade.php`.
2. Create `PortfolioController@sendMessage` at route `POST /contact` with CSRF protection and validation (`fullname`, `email`, `message`) that saves inquiries to the `messages` table and redirects back with a success flash banner.

#### PHASE 5: Build the Interactive Admin Dashboard
Build a clean, dark-themed, responsive Admin Dashboard (matching the portfolio's dark cybersecurity aesthetic) under `/admin`:
1. **Authentication**:
   - Create simple session-based login/logout routes (`GET /admin/login`, `POST /admin/login`, `POST /admin/logout`) protected by Laravel `auth` middleware.
2. **Dashboard Overview (`GET /admin`)**:
   - Show total counts for Projects, Research Papers, Skills, Certificates, and Unread Contact Messages.
   - Quick-action buttons to add a new Project or Research item.
3. **Full CRUD Management**:
   - **Projects CRUD (`/admin/projects`)**: Create, Edit, Delete projects. Include a file input for `thumbnail` with live image preview, category dropdown (`CyberSecurity`, `Applications`, `Web development`, `Learn`, or custom), `project_url`, `description`, and an `is_github_featured` checkbox.
   - **Research CRUD (`/admin/researches`)**: Create, Edit, Delete research papers with thumbnail upload, category, published date, URL, and description.
   - **Skills & Certificates CRUD (`/admin/skills`, `/admin/certificates`)**: Add, update, or delete skills (name + percentage slider) and certificates.
   - **Contact Messages Inbox (`/admin/messages`)**: View messages sent from the portfolio contact form, mark as read, or delete.
4. **Serverless-Safe Image Upload Handling**:
   - Whenever an image is uploaded in the Admin Dashboard (`thumbnail` or `image`), validate it (`image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048`) and encode it as a Base64 Data URI (`data:<mime>;base64,<encoded_data>`) before saving it into the SQLite `longText` column. This guarantees uploaded images persist inside `database.sqlite` and never break on Vercel's read-only filesystem.

#### PHASE 6: Configure Vercel Serverless PHP + SQLite Deployment
Configure `./portfolio` so it can be deployed directly to my existing Vercel project without Docker:
1. **Create `./portfolio/api/index.php`**:
   ```php
   <?php
   // If running on Vercel's read-only filesystem, copy the bundled SQLite DB to /tmp so SQLite can create lock/journal files without read-only errors
   if (isset($_ENV['VERCEL']) \vert{}\vert{} isset($_SERVER['VERCEL']) || is_dir('/var/task')) {
       $sourceDb = __DIR__ . '/../database/database.sqlite';$tmpDb = '/tmp/database.sqlite';
       if (file_exists($sourceDb) && !file_exists($tmpDb)) {
           copy($sourceDb,$tmpDb);
       }
   }
   require __DIR__ . '/../public/index.php';

(Check ./portfolio/composer.json PHP version constraint and ensure platform.php or require.php is compatible with PHP 8.3 used by vercel-php@0.7.3, adjusting composer.json if it was locked to 8.4).

Update ./portfolio/.gitignore and .vercelignore:

Ensure database/database.sqlite is NOT ignored in .gitignore or .vercelignore so the seeded and updated SQLite database is tracked by Git and deployed to Vercel.

2. Create ./portfolio/.vercelignore ignoring /node_modules, /vendor, and .env.

HTTPS Asset Enforcement:

In ./portfolio/app/Providers/AppServiceProvider.php, force HTTPS in production inside boot():

```PHP
if ($this->app->environment('production')) {
    \Illuminate\Support\Facades\URL::forceScheme('https');
}```

PHASE 7: Verification & Testing
Run php artisan migrate:fresh --seed inside ./portfolio.

Run feature/route tests or curl checks against php artisan serve to verify:

GET / renders 200 OK with all seeded Projects, Research items, Skills, and Certificates matching ./static/index.html.

GET /admin/login renders 200 OK and logs in with istiak.apk@gmail.com / Admin@12345.

Creating/editing a project in /admin/projects updates database/database.sqlite and immediately reflects on GET /.

Provide a clear summary of all created files, the admin login credentials, and the exact commands to push ./portfolio to my Vercel repository.