# User Management Plugin

A common theme when creating web applications, is registering users, changing password, verifying the email address. This plugin takes less than 2 minutes to add to your application. More features coming soon.

### Installation

Install the the User Management using the `plugin:install` command

```linux
$ bin/console plugin:install originphp/user_management
```

Load the `AuthComponent` in the `AppController` initialize method.

```php
class AppController extends Controller
{
    public function initialize()
    {
        $this->loadComponent('Auth', [
            'loginAction' => '/login',
            'loginRedirect' => '/home',
            'logoutRedirect' => '/login',
            'model' => 'UserManagement.User'
        ]);
    }
}
```

Load database schema for the User (you can change this later)

```linux
$ bin/console db:schema:load UserManagement.schema
```

Load the Queue schema, which use for sending reset password and email verification notices.

```linux
$ bin/console db:schema:load queue
```

Set the `App.name` value in your `config/application.php`

```php
Config::write('App.name','Web Application');
```

# Custom User Model

You will probably want to use a custom User model, if you do, just take out the model configuration when loading the `Auth Component`, this will then load your `App\User` model. All you need is the `beforeSave` callback to hash the password if it was modified.

```php
$this->loadComponent('Auth', [
    'loginAction' => '/login',
    'loginRedirect' => '/home',
    'logoutRedirect' => '/login'
]);
```

And then create `App/Model/User.php`

```php
namespace App\Model;

use Origin\Model\Entity;
use Origin\Utility\Security;

class User extends AppModel
{
    public function beforeSave(Entity $entity, array $options = [])
    {
        if (! empty($entity->password) and in_array('password', $entity->modified())) {
            $entity->password = Security::hashPassword($entity->password);
        }
    }
}
```

## Testing The Plugin

The controller integration test requires your Controller is configured first, but other tests will run fine without this.

If the User schema and queue schema is in your `database/schema.php` file then to run the tests run the following commands

```linux
$ bin/console db:test:prepare
$ cd plugins/user_management
$ phpunit
```

If your database and schema.php is empty, then 

```linux
$ bin/console db:create --datasource=test
$ bin/console db:schema:load --datasource=test UserManagement.schema
$ bin/console db:schema:load --datasource=test queue
$ cd plugins/user_management
$ phpunit
```