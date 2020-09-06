<p align="center">
 <img align="center" src="https://github.com/Yarob50/LaravelServiceGenerator/blob/master/assets/logo.png" />
</p>
<h1 align="center"> :star: Laravel Service Generator 🚀</h1>

 <h3 align="center"> Generate the service layer like you do for models, controllers.. etc 🤩</h3>

## Quick Look
It's common in many Laravel projects to introduce a new layer to the MVC model and to the project structure which is primarily used for doing the business logic of the app and to make the job of the controller limited on receiving the request and returning the response. One solution for achieving this is by using the Service layer. While you have artisan commands for creating migrations, models, controllers.. etc, you don't have one for creating the service classes as it's not part of the original Laravel project structure. Creating a service and making an interface for it (to prevent tight coupling) is a task that you would do again and again in your service-layer-based projects and **Laravel Service Generator** is here to save you some time. 🥳
**NOTE: I know that it's also common to use the Repository layer instead or even with the Service layer, however this solution is not supported in this package yet and your contribution is always welcome 😄**

## Installation
### Using Composer:
```
composer require yarooob/laravel-service-generator
```

## Usage
As you do for making a controller, you should use the following command:
```
php artisan make:service <ServiceName>
```
Example:
```
php artisan make:service ItemsService
```
The above command will create two classes in `app\Http\Services` directory and these are:
A. `ItemsService.php` which is the class of the service.
B. `ItemsServiceInterface.php` which is the class of the interface of that service to help you avoiding the tight coupling with the controller and mocking your service for testing.

If you don't want to generate the Interface along with the service and limit the generation to the service only you can use `--no-interface`` option with the command.
```
php artisan make:service ItemsService --no-interface
```
Or you can make this to be the default behavior of the command by:
1- publishing the config: `php artisan vendor:publish --provider="Yarob\LaravelServiceGenerator\LaravelServiceGeneratorServiceProvider" --tag=config` file.
2- changing the value of `create_interface_enabled` to be `false` in the published config file which you can find in: `config/laravelService.php`.
After making this change, whenever you run `php artisan make:service <ServiceName>`, only the Service class will be generated without the interface.

## Customization
To Customize the stubs used for generating the files you can publish them by calling: `php artisan vendor:publish --provider="Yarob\LaravelServiceGenerator\LaravelServiceGeneratorServiceProvider" --tag=stubs ` which will publish two files in the `stubs` directory:
A. **service.stub**
B. **serviceInterface.stub**
