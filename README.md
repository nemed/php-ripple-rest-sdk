# PHP Ripple REST SDK
## Installation

Installation with Composer

Add in composer.json
~~~
    "require": {
        ...
        "turkevich/rest-client":"dev-master"
    }
~~~

Well done!

## Example call
~~~
    $result = (new Client(Client::POST, $url, $data))
        ->setContentType(Client::JSON)
        ->setUserAgent('Yah')
        ->setHttpAuth('aloha', '123123123')
        ->call();
~~~

Enjoy, guys!
