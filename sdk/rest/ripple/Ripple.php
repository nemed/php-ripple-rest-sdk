<?php
namespace ctur\sdk\rest\ripple;

use Exception;
use ctur\rest\Client;
use ctur\sdk\rest\ripple\lib\Enum;

/**
 * Class Ripple. Base class for Ripple REST Module.
 * @package app\modules\ripple\components
 *
 * @author Cyril Turkevich
 */
abstract class Ripple
{
    /* @var string $serverUrl api server url. */
    public $serverUrl;

    /* @var array $_cloud ripple service cloud. */
    private static $_cloud = [];

    /* @var array $_methods RESTful methods */
    private $_methods = [
        'POST'   => Client::POST,
        'GET'    => Client::GET,
        'PUT'    => Client::PUT,
        'DELETE' => Client::DELETE
    ];

    /**
     * @param string $serverUrl api server url.
     */
    private function __construct($serverUrl)
    {
        $this->serverUrl = $serverUrl;
    }

    /**
     * Returns ripple component.
     * @param string $type Use const from ctur\sdk\rest\ripple\lib\Enum
     * @param string $serverUrl api server url.
     * @return Ripple ripple component.
     * @throws Exception Bad Ripple REST API Component. Use ctur\sdk\rest\ripple\lib\Enum
     */
    public static function factory($type, $serverUrl)
    {
        if (!isset(Enum::listData()[$type])) {
            throw new Exception('Bad Ripple REST API Component. Use ctur\sdk\rest\ripple\lib\Enum');
        }

        $type = Enum::listData()[$type];
        if (!isset(self::$_cloud[$type])) {
            $class = "\\ctur\\sdk\\rest\\ripple\\lib\\{$type}";
            self::$_cloud[$type] = new $class($serverUrl);
        }

        return self::$_cloud[$type];
    }

    /**
     * @param string $serverUrl url to server api.
     * @return $this
     */
    public function setServerUrl($serverUrl)
    {
        $this->serverUrl = $serverUrl;

        return $this;
    }

    /**
     * Returns absolute url for request.
     * @param string $url url get params.
     * @return string absolute url for request.
     */
    public function getUrl($url)
    {
        return "{$this->serverUrl}/$url";
    }

    /**
     * Request to Ripple REST api.
     * @param string $method RESTful methods.
     * @param string $url url get params.
     * @param array $data request data.
     * @return array response data.
     * @throws Exception
     */
    public function request($method, $url, $data = [])
    {
        return (new Client($this->getMethod($method), $this->getUrl($url), $data))
            ->setContentType(Client::JSON)
            ->setUserAgent('Ripple REST PHP Client/1.0')
            ->call();
    }

    /**
     * Replace REST method.
     * @param string $method RESTful mehtod.
     * @return string replaced method.
     * @throws Exception
     */
    public function getMethod($method)
    {
        if (!isset($this->_methods[$method])) {
            throw new Exception('Bad REST Method');
        }

        return $this->_methods[$method];
    }

    /**
     * Merge secret to request params.
     * @param array $data request params.
     * @param string|null $secret
     * @return array merged request params with secret key.
     */
    public function getPostData(array $data = [], $secret = null)
    {
        return $secret ? $data + ['secret' => $secret] : $data;
    }

    /**
     * Format bool in url format.
     * @param bool $bool true or false.
     * @return string true or false.
     */
    public function getBool($bool)
    {
        return $bool ? 'true' : 'false';
    }
}
