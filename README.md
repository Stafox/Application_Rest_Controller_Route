Application_Rest_Controller_Route
============================
[![Build Status](https://secure.travis-ci.org/aporat/Application_Rest_Controller_Route.png)](http://travis-ci.org/aporat/Application_Rest_Controller_Route) [![Coverage Status](https://coveralls.io/repos/aporat/Application_Rest_Controller_Route/badge.png)](https://coveralls.io/r/aporat/Application_Rest_Controller_Route)


## Requirements ##

* PHP >= 5.3
* Zend Framework >= 1.11

## Getting Started ##

The easiest way to work with this package is when it's installed as a
Composer package inside your project. Composer isn't strictly
required, but makes life a lot easier.

If you're not familiar with Composer, please see <http://getcomposer.org/>.

1. Add the package to your application's composer.json.

        {
            ...
            "require": {
                "aporat/application_rest_controller_route": "dev-master"
            },
            ...
        }

2. Run `php composer install`.

3. If you haven't already, add the Composer autoload to your project's
   initialization file. (example)

        require 'vendor/autoload.php';

4. Register namespace `Application` in Bootstrap.

        ```php
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->registerNamespace('Application');
        ```

## Quick Example ##

Setting up custom routes in the bootstrap:

```php

$frontController = Zend_Controller_Front::getInstance();
$frontController->getRouter()->addRoute('users-messages', new Application_Rest_Controller_Route($frontController, 'users/:user_id/messages', ['controller' => 'users-messages']));

```

Extend Zend_Rest_Controller as needed. Zend_Controller_Front will forward the requests to either indexAction, postAction or putAction as you expected from Zend_Rest_Route.


```php

<?php

class Api_UsersMessagesController extends Zend_Rest_Controller
{
    /**
     * GET /users/:user_id/messages
     */
    public function indexAction()
    {
    
       ...
    }
    
    /**
     * POST /users/:user_id/messages
     */
    public function postAction()
    {
    
        ...
    }
    
}

```
