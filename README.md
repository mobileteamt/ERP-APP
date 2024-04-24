# ERP Application in CodeIgniter 4 Framework

- This is an ERP application built into CodeIgniter v4 for creating products with inventory.
- There are admin sections available in the application to create, update, or delete products with inventory.

- On the front-end section, you can do following actions:
1. See the product list.
2. Product details page, where you can add products to your cart by selecting quantity.
3. To make an order, you need to add products to your cart and go to the checkout page.
4. On the checkout page, you need to add billing information and place an order.

- Set your base url in app/Config/App.php.
- Set your database details in the /app/Config/Database.php file on the $default array.

- Front end URL: <base_url>/erp-app/
- Admin URL: <base_url>/admin/

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
