Laravel 11-Based Web for Point of Sale Management (Admin & Cashier Only)
This is a Laravel 11-based Point of Sale (POS) web application designed to provide a role-based user experience for Admin and Cashier. It includes features such as product and category management, transaction processing, report generation, and CSV export functionality. The following guide will walk you through setting up the application from scratch, including authentication setup, database relationships, route configuration, controller logic, views, and advanced features like dynamic filtering and exporting reports.

🛠️ Step-by-Step Setup and Usage Guide
1. Create a New Laravel Project
Ensure your development server (e.g., XAMPP) is running with MySQL and Apache services enabled.
Then, open your terminal or command prompt and run the following:
    a) Install Laravel globally via Composer:
    composer global require laravel/installer
    b) Create a new Laravel project:
    laravel new pos_alfihra
This will generate a fresh Laravel 11 project in a folder named 'pos_alfihra'.

3. Configure the Database
Open the '.env' file located in your project root and configure your database credentials:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=pos_laravell //fill this based on your database name
    DB_USERNAME=root
    DB_PASSWORD=
Make sure to create a database named 'pos_laravell' using a tool like phpMyAdmin or directly via MySQL CLI.

3. Install Laravel Breeze for Authentication
Laravel Breeze provides lightweight authentication scaffolding.
Run the following commands:
    composer require laravel/breeze --dev
    php artisan breeze:install
    npm install && npm run dev
    php artisan migrate
This will generate the user auth system using Blade templates, and create the default users table.

5. Generate Models, Migrations, and Controllers
    Use the Artisan command to create models with migrations and resourceful controllers:
        php artisan make:model Product -mcr
        php artisan make:model Transaction -mcr
        php artisan make:model Category -mcr
        php artisan make:model TransactionDetail -m
            -m: creates migration file
            -c: creates controller file
            -r: makes it a resource controller with CRUD method stubs
   
5. Define Model Relationships
   Example in app/Models/Product.php:
        use Illuminate\Database\Eloquent\Model;
        class Product extends Model {
        protected $fillable = ['name', 'description', 'price', 'stock', 'category_id', 'image'];
        public function category() {
        return $this->belongsTo(Category::class);
        }
        }
        6. Define Database Migrations
        Example for 'products' table in migration file:
        
        Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->decimal('price', 10, 2);
        $table->integer('stock');
        $table->timestamps();
        });
Then run: php artisan migrate

7. Implement Controller Logic
    In ProductController, implement methods for CRUD operations and image handling.
    Use validation, file upload logic with 'store' and 'update', and file deletion logic with 'destroy'.
    Pass required data to views using compact(), e.g., compact('products', 'categories').
   
9. Create Blade Views
    Create the following view files under 'resources/views/admin/products/':
    - xindex.blade.php
    - create.blade.php
    - edit.blade.php
    Create 'dashboard.blade.php' to show admin panel with links to product/category management.
    Use Blade syntax and Bootstrap/Tailwind for styling.

9. Configure Web Routes
    In 'routes/web.php':
    Use middleware to restrict access:
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    });
    Similar group for cashier with TransactionController.
   
11. Implement Report and CSV Export
    In TransactionController, create a 'report' method to filter data by date and category:
    Use 'when()' and 'whereHas()' to dynamically filter based on request inputs.
    Create a Blade view (laporan.blade.php) with a form for start_date, end_date, and category_id.
    For CSV export, define 'exportCsv' method using response()->stream().
    Loop through each transaction and detail, formatting rows as CSV with fputcsv(). To make the CSV table looks tidied up, don't forget to add 'Content-Type' => 'text/csv; charset=UTF-     8', //based in Indonesia
    
13. Run and Test Your Application
    Run: php artisan optimize
    Run: php artisan serve
    Visit: http://localhost:8000
        a)  Register as Admin → Manage products & categories
        b)  Register as Cashier (Log out first if you’re logged in) → Make transactions → View & export reports
        c)  Test filtering by date/category and exporting to CSV
        d)  Log out and shut down server as needed
