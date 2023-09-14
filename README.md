<div align='center'>

# PeopleProSAAS (Landlord)
</div>

## Visit
- Demo : http://smarthishab.com/

- Super Admin : smarthishab.com/super-admin
- Super Admin Credentials : Username & Password both "admin"


## About
Empower Your Business with PeoplePro: The Ultimate SAAS-Based Solution for HRM, Payroll, and Project Management

Experience the next evolution in organizational management with PeoplePro, a cutting-edge SAAS-based application designed to revolutionize HRM, Payroll, and Project Management. Developed on the robust Laravel framework, PeoplePro offers a seamless and intuitive platform that empowers businesses of all sizes to efficiently manage their workforce and projects with unprecedented convenience.

## SASS Features

- Multi-tenancy based
- Separate sub-domain/tenant
- Separate database/tenant
- Customizable frontend CMS
- Multiple Payment Gateway
- Powerfull Add-ons

## System Requirements
- cPanel based server. Shared hosting will do, but not recommended.
- cPanel API
- SSL certificate for main domain and all sub-domains (wildcard)
- PHP 8.1

## Technologies 
- PHP - 8.1
- Laravel - 10 
- jQuery 
- Ajax 
- MySQL 
- Bootstrap - 4 
- HTML 
- CSS

## Composer Packages Used
- barryvdh/laravel-dompdf
- intervention/image
- joedixon/laravel-translation
- maatwebsite/excel
- spatie/laravel-permission
- stancl/tenancy
- yajra/laravel-datatables-oracle
- laravel/pin
- pestphp/pest
- sven/artisan-view

<div align='center'>

# Multi Tenancy Setup Guideline
</div>
<br><br><br><br>




<div align='center'>

# Step-1 : Linux Virtualhost Setup
</div>

## Primary Setup

1. Modify the Hosts File
    ```bash
    sudo nano /etc/hosts
    ```

2. Add the following line to the hosts file
    ```bash
    127.0.0.1 peopleprosjaas.test
    ```
3. Configure the Virtual Host (Apache)
    ```bash
    sudo nano /etc/apache2/sites-available/peopleprosaas.conf
    ```
4. Add the following configuration to the file
    ```bash
    <VirtualHost *:80>
        ServerName peoplepro.test
        DocumentRoot /path/to/your/laravel/project/public

        <Directory /path/to/your/laravel/project/public>
            Options Indexes FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/peoplepro.test_error.log
        CustomLog ${APACHE_LOG_DIR}/peoplepro.test_access.log combined
    </VirtualHost>
    ```

5. Enable the Virtual Host
    ```bash
    sudo a2ensite peopleprosaas.conf
    ```

6. Restart Apache
    ```bash
    sudo service apache2 restart
    ```

7. Clear Config
    ```
    php artisan config:clear
    ```

## Return Back Default

1. Remove the Custom Domain from the Hosts File
    ```
    sudo nano /etc/hosts
    ```

2. Disable the Virtual Host (Apache)
    ```
    sudo a2dissite peopleprosaas.conf
    ```

3. Restart Apache
    ```
    sudo service apache2 restart
    ```

4. Clear Laravel Configuration Cache (Optional)
    ```
    php artisan config:clear
    ```

## Rename the Configuration File

1. Run this command
    ```
    sudo mv /etc/apache2/sites-available/peoplepro.test.conf /etc/apache2/sites-available/newname.conf
    ```

2. Update the Virtual Host Configuration
    ```
    sudo nano /etc/apache2/sites-available/newname.conf
    ```

3. Enable the Updated Virtual Host
    ```
    sudo a2ensite newname.conf
    ```

4. Restart Apache
    ```
    sudo service apache2 restart
    ```



<div align='center'>

# Step - 2 : Multi Tenancy Setup in Laravel App
</div>

## What is multi-tenancy ? 
Multi-tenancy is a software architecture and design approach that allows a single software application to serve multiple, separate, and independent clients, known as "tenants." Each tenant typically operates in isolation from one another, with their own data, configurations, and user accounts, despite using the same underlying software instance. This approach is commonly used in various types of software, including web applications, databases, and cloud services. This is the ability to provide your service to multiple users (tenants) from a single hosted instance of the application. This is contrasted with deploying the application separately for each user. 

## Virtual Host Setup
Before setup the SaaS in your project, please setup the virtual host first.

- For linux machine, please follow this article : [Linux Virtualhost Setup](https://github.com/Irfan-Chowdhury/DevProTips/blob/main/pages/virtualhost.md)

- For windows, there are so many resources on youtube, google. Please check.

## Package Installation
First, require the package using composer:
```bash
composer require stancl/tenancy
```

Then, run the tenancy:install command:
```bash
php artisan tenancy:install
```

Let's run the migrations:
```bash
php artisan migrate
```

Register the service provider in `config/app`.php. Make sure it's on the same position as in the code snippet below:
```php
/*
 * Application Service Providers...
 */
 ...
App\Providers\TenancyServiceProvider::class, 
```

## Creating a tenant model
Now you need to create a Tenant model. Create the file using `php artisan make:model Tenant`.

```php
<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;
}
```
Please note: if you have the models anywhere else, you should adjust the code and commands of this tutorial accordingly.


But if want to customize the tenant table then you can follow this - 
<img src="https://snipboard.io/WvbRyY.jpg">


## PeopleProSAAS - Setup Guideline

### (.env) file setup
I was added and modified the environment variable.
```bash
CENTRAL_DOMAIN=peopleprosaas.test
CPANEL_API_KEY=
CPANEL_USER_NAME=

DB_PREFIX=
DB_CONNECTION=peopleprosaas_landlord
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=root
DB_PASSWORD=irfan95

LANDLORD_DB=peoplepro_landlord
```
API_KEY, USER_NAME, PREFIX and othres modification will be applicable during deploy on the cPanel Server.

### config/database.php
Goto `config/database.php` then create two more connections like <b>mysql</b>.

1. One is for Landlord
```php
'peopleprosaas_landlord' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('LANDLORD_DB', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => false,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
```

2. Another is for tenant.
```php
'peopleprosaas_tenant' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => false,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
```

### config/tenancy.php
Now we need to tell the package to use this custom model. Open the `config/tenancy.php` file and modify the line below:

<img src="https://snipboard.io/9Urm6R.jpg">

Please look the `#Modified` word. I have to update these line.


### Kernel.php
Goto `app/Http/Kernel.php` and then add `universel` array in `middlewareGroups` 

```php
protected $middlewareGroups = [
    'web' => [
        ...
    ],

    'api' => [
        ...
    ],
    'universal' => [], // <---This line
];
```

### TenancyServiceProvider

Goto `app/Provider/TenancyServiceProvider.php`. In the initial stage you will see the `Jobs\SeedDatabase::class` in comment. If you want to use Seeder then comment out.


then update the `mapRoutes()` method.
```php
protected function mapRoutes()
{
    if (file_exists(base_path('routes/tenant.php'))) {
        Route::namespace(static::$controllerNamespace)
            ->group(base_path('routes/tenant.php'));
    }
}
```

### RouteServiceProvider
Goto `app/Provider/RouteServiceProvider.php` and then configure your code like below - 

```php
public function boot()
{
    $this->mapApiRoutes();
    $this->mapWebRoutes();
}

protected function centralDomains(): array
{
    return config('tenancy.central_domains', []);
}

protected function mapWebRoutes()
{
    foreach ($this->centralDomains() as $domain) {
        Route::middleware('web')
            ->domain($domain)
            ->group(base_path('routes/web.php'));

        Route::middleware('web')
            ->domain($domain)
            ->group(base_path('routes/general.php'));
    }
}

protected function mapApiRoutes()
{
    foreach ($this->centralDomains() as $domain) {
        Route::prefix('api')
            ->domain($domain)
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }
}
```

### ViewComposerServiceProvider

This is my another custom service provider. The GeneralSeting exists in both landlord and tenant. So need identify the host first and then fetch the actual data and share with anothers necessary files. Otherwise it'll give errors.

```php
public function boot(): void
{
    if (Schema::hasTable('general_settings') && in_array(request()->getHost(), config('tenancy.central_domains'))) {
        $generalSetting = GeneralSetting::latest()->first();
        view()->composer([
            'landlord.public-section.layouts.master',
            'landlord.public-section.pages.landing-page.index',
        ], function ($view) use ($generalSetting) {
            $view->with('generalSetting', $generalSetting);
        });
    }
}
```

### routes/tenant.php
During install the package, a route file name `routes/tenant.php` will be created automatically. Just move your `web.php` file code to `tenant.php`. But before use this codes (already some codes will exists) and paste your code in group block. 

```php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


Route::middleware(['XSS', 'web',InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class])->group(function () {
    
    // Your existing route code
    ...
});
```

### main.blade.php (Tenant)
Goto `resources/views/layout/main.blade.php`. Here your all existing includes file path have to be changed. Just add `../../` before your original path. Example :

```php
# Normal Image File
<link rel="icon" type="image/png" href="{{asset('../../images/logo/'.$general_settings->site_logo)}}"/>


# CSS File
<link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('../../vendor/bootstrap/css/bootstrap.min.css') }}">

# Script File
<script type="text/javascript" src="{{ asset('../../vendor/datatable/datatable.responsive.boostrap.min.js') }}"></script>
```

By the you don't worry about Landlord part. It will work as usual a Laravel app work.

## Usages
In any controller just use this piece of codes.

```php
public function create()
{
    //creating tenant
    $tenant = Tenant::create(['id' => $request->tenant]);
    $tenant->domains()->create(['domain' => $request->tenant.'.'.env('CENTRAL_DOMAIN')]); // This Line

    $tenant->run(function ($tenant) use ($request) { 
        
        // your code 
        // Here if you pass any default data to tenant related tables;
    });
}
```

## Some General Commands
### Tenant list
- To check all tenants list 
    ```bash
    php artisan tenants:list
    ```
### Rollback & Seed
- Rollback :  `php artisan tenants:rollback`
- Seed : `php artisan tenants:seed`

### Tenant Migrations 
- You can run tenant migrations using the command : 
    ```bash
    php artisan tenants:migrate
    ```

- You may specify the tenant(s) using the --tenants option.
    ```bash
    php artisan tenants:migrate --tenants=foo 
    ```

- If you have others directory, you have to mention with path also :
    ```bash  
    php artisan tenants:migrate --path=database/migrations/another_directory
    ```


<i>Note: Tenant migrations must be located base on your desired path which you mentioned it in "config/tenancy.php".</i>


- You can run migrations from outside the command line as well. To run migrations for a tenant in your code, use Artisan::call():

    ```php
    $tenant = Tenant::create('foo');

    Artisan::call('tenants:migrate', [
        '--tenants' => [$tenant->id]
    ]);
    ```


<div align='center'>

# Step - 3 : Deploye in cPanel
</div>

## General Setup
- Goto your cPanel and upload your app in <b>`public_html`</b>. Remember your project's  files should be exists in root directory I mean "public_html".

## API Setup
- Search or goto  <b>`Manage API Tokens`</b>

- Click on the `Create` button
 ![Manage API Token Page](https://snipboard.io/3sYbCP.jpg)

- Set a API token name and click on `Create` button.
 ![Create API Token](https://snipboard.io/DgLBF1.jpg)

- An API will be created. Copy the API Token and store it. And then click on `Yes, I saved my token` button.
 ![Saved API Token](https://snipboard.io/wReKb9.jpg)

- If you go back `Manage API Token` page, you will see the tokens detail which you created.
![Manage API Token Page](https://snipboard.io/i0IE84.jpg)

- Put the credentials in the `.env` file.
![Manage API Token Page](https://snipboard.io/J3EcUF.jpg)


## Wildcard Sub Domain
You can not create sub-domain through the Multi Tenancy but you can create a `Wild Card Sub Domain`. Follow the instruction - 

- Search and goto `Domains`. And create a new domain by clicking on `Create A New Domain` button.
![Domains Page](https://snipboard.io/ZstM8Q.jpg)

- (i) You have to set a domain name and according to this format : <b>`*.your-domain-name.com`</b>. <br>
(ii)  And also set "Document Root" name and you have to write <b>`public_html`</b>  <br>
(iii) After completing to do this, then click on `Submit` button.
![Domains Page](https://snipboard.io/WV5rpz.jpg)
 <br>

- A new domain will be created.
![New Domain Created](https://snipboard.io/vyzCMm.jpg)


<i>Note: You cannot create a wildcard addon domain. You must create a subdomain on an existing domain instead.</i>

## .env
Your value in `.env`  file will be look like this -
![New Domain Created](https://snipboard.io/Oft10q.jpg)


## Replace Code 

- Please goto `Stancl\Tenancy\TenantDatabaseManagers\MySQLDatabaseManager.php`. 
You will see the deafult code of Package.
![Old Code](https://snipboard.io/4edpjv.jpg)


- Now, you have to replace the code given below. Screenshot :
![New Code](https://snipboard.io/YRga4B.jpg)

Code
```
public function createDatabase(TenantWithDatabase $tenant): bool
{
    $database = $tenant->database()->getName();
    $charset = $this->database()->getConfig('charset');
    $collation = $this->database()->getConfig('collation');

    //setting the curl headers
    $headers = array(
        "Authorization: cpanel ".env('CPANEL_USER_NAME').":".env('CPANEL_API_KEY'),
        "Content-Type: text/plain"
    );

    //custom code for creating DB in a cPanel based server
    $url = "https://".env('CENTRAL_DOMAIN').":2083/execute/Mysql/create_database?name=".$database;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_exec($curl);
    curl_close($curl);

    //custom code for assigning user to DB in a cPanel based server
    $url = "https://".env('CENTRAL_DOMAIN').":2083/execute/Mysql/set_privileges_on_database?user=".env('DB_USERNAME')."&database=".$database."&privileges=ALL";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_exec($curl);
    curl_close($curl);

    return true;
}
```

## Credits
- Author : [LION CODERS](https://lion-coders.com/)
- Template Design : [Tarik Iqbal](https://www.linkedin.com/in/tarik-iqbal-51046b34/)
- Backend Developer : [Irfan Chowdhury](https://github.com/Irfan-Chowdhury)
- Reference : [Tenancy for Laravel](https://tenancyforlaravel.com/)
- Guided by : [Ashfaqur Rahman](https://github.com/ashfaqdev)



<br><br>
##### <p>[Note:  Due to copyright reasons, the migration files (tenant) have been kept hide]</p>
