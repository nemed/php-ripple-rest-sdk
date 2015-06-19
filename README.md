# PHP Ripple REST SDK
See Ripple REST API documentation https://ripple.com/build/rest-tool/
## Installation

Installation with Composer

Add in composer.json
~~~
    "require": {
        ...
        "turkevich/php-ripple-rest-sdk":"dev-master"
    }
~~~

Well done!

## Example call
~~~
    $result = \ctur\sdk\rest\ripple\Ripple::factory(\ctur\sdk\rest\ripple\lib\Enum::ACCOUNT, 'https://api.ripple.com/v1')->generateWallet();
~~~

Enjoy, guys!
