<h1 align="center">Masterzeye</h1>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


Masterzeye is a global project management system that allows the company to manage projects.


## Running the project

- Clone project than start the container

```
sail up -d
```

- Create a test user by executing
```
sail artisan tin
```
and paste the follow code (change `<YOUR-PASSWORD>` for whatever you want, such as the name and email):

```
    User::factory()->create([
        'name' => 'Jane Doe',
        'email' => 'jane.doe@masterzeye.com',
        'password' =>  Hash::make('<YOUR-PASSWORD>'),
    ]);
```

- Open `http://localhost/` on browser, go to login and fill with those credentials;

## License

This project is an open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
