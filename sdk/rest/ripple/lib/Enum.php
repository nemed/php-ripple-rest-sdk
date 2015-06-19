<?php
namespace ctur\sdk\rest\ripple\lib;

/**
 * Enum Ripple REST API Components.
 *
 * @package ctur\sdk\rest\ripple\lib
 *
 * @author Cyril Turkevich
 */
class Enum extends \ctur\base\Enum
{
    const ACCOUNT = 'Account';
    const NOTIFICATION = 'Notification';
    const ORDER = 'Order';
    const PAYMENT = 'Payment';
    const STATUS = 'Status';
    const TRUSTLINE = 'Trustline';
    const UTILITY = 'Utility';

    protected static $list = [
        self::ACCOUNT      => 'Account',
        self::NOTIFICATION => 'Notification',
        self::ORDER        => 'Order',
        self::PAYMENT      => 'Payment',
        self::STATUS       => 'Status',
        self::TRUSTLINE    => 'Trustline',
        self::UTILITY      => 'Utility',
    ];
}