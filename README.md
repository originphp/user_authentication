# User Authentication Plugin

The User Authentication plugin, provides user registration, sending a welcome emails, changing passwords, verifying user email addresses using email notifications. This plugin takes less than 2 minutes to add to your application and provides you with everything you need to get started.

## Installation

Install the the `UserAuthentication` plugin

```linux
$ composer require originphp/user_authentication
```

## Setup

Load the `AuthComponent` in the `AppController` initialize method.

```php
class AppController extends Controller
{
    protected function initialize() : void
    {
        $this->loadComponent('Auth', [
            'loginAction' => '/login',
            'loginRedirect' => '/profile', # Set this to something valid
            'logoutRedirect' => '/login',
            'model' => 'UserAuthentication.User'
        ]);
    }
}
```

Load database schema for the User (you can change this later)

```linux
$ bin/console db:schema:load UserAuthentication.schema
```

Load the Queue schema, which use for sending reset password and email verification notices.

```linux
$ bin/console db:schema:load queue
```

Set the `App.name` value in your `config/application.php`

```php
Config::write('App.name','Web Application');
```
## Usage

To signup

[http://localhost:8000/signup](http://localhost:8000/signup)

To login

[http://localhost:8000/login](http://localhost:8000/login)

> This will take you to the  `loginRedirect` setting you setup in your AppController

To start the password reset process

[http://localhost:8000/forgot_password](http://localhost:8000/forgot_password)

To view or edit your user profile

[http://localhost:8000/profile](http://localhost:8000/profile)

To view the API token

[http://localhost:8000/token](http://localhost:8000/token)

> If you are not going to be using API tokens then you can remove the route from `config/routes.php`

## Creating App Source

To install the source into your app, and rename the namespaces, type in

```linux
$ bin/console user-authentication:install
```
> You will need to copy the routes from the `routes.php` file

Then you can delete the plugin and remove the `Plugin::load` command from your bootstrap.

## What Next

Now its all working fine, it is time to copy the schema for the User Authentication plugin and the queues into your `application/schema.php`.

## Testing The Plugin

The controller integration test requires your `AppController` loads the `AuthComponent`, but other tests will run fine without this.

Load the schema for the `UserAuthentication` plugin and queues into the test database

```linux
$ bin/console db:schema:load --connection=test UserAuthentication.schema
$ bin/console db:schema:load --connection=test queue
```
