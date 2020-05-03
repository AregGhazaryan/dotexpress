
# DotExpress

DotExpress is a public ecommerce application template, ready to be branded and designed.

## Getting Started

1. Copy `.env.example` file and rename it to `.env`, also insert the database credentials there.
2. Run `php artisan key:generate` to generate a key for the app. 
3. (Optional) Run `php artisan migrate:fresh && php artisan db:seed` to seed tables with dummy data

The Users seeder contains the following users 

1. Admin (`id:1`, `name:Admin`, `email:admin@dotexpress.com`, `password:admin`)
2. Seller (`id:2`, `name:Seller`, `email:seller@dotexpress.com`, `password:seller`)
3. Customer (`id:3`, `name:Customer`, `email:customer@dotexpress.com`, `password:customer`)

The Roles seeder contains the following roles 
1. Admin (`id:1`, `name:Admin`, `machine_name:admin`)
2. Seller (`id:2`, `name:Seller`, `machine_name:seller`)
3. Customer (`id:3`, `name:Customer`, `machine_name:customer`)

There's also an optional Products seeder which is just using faker to generate fake info.

## Built With

* [Laravel 7.0](https://laravel.com)
* [Bootstrap](https://getbootstrap.com/)

## Authors

* **Areg Ghazaryan**

See also the list of [contributors](https://github.com/AregGhazaryan/dotexpress/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details


