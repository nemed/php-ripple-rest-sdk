<?php
namespace ctur\sdk\rest\ripple\lib;
use ctur\sdk\rest\ripple\Ripple;

/**
 * Notifications provide a mechanism to monitor for any kind of transactions that modify your Ripple account.
 * Unlike the Get Payment History method, notifications include all types of transactions, but each is described in less detail.
 * Notifications are sorted in order of when they occurred,
 * so you can save the most recently-known transaction and easily iterate forward to find any notifications that are newer than that.
 * @see https://ripple.com/build/ripple-rest/#check-notifications
 *
 * @package app\modules\ripple\components
 *
 * @author Cyril Turkevich
 */
class Notification extends Ripple
{
    /**
     * Get a notification for the specific transaction hash, along with links to previous and next notifications, if available.
     * @see https://ripple.com/build/ripple-rest/#check-notifications
     *
     * @param string $address The Ripple account address of an account involved in the transaction.
     * @param string $id A unique identifier for the transaction this notification describes — either a client resource ID or a Ripple transaction hash.
     *
     * @return array A notification for the specific transaction hash, along with links to previous and next notifications, if available.
     */
    public function checkNotifications($address, $id)
    {
        return $this->request('GET', "accounts/{$address}/notifications/{$id}");
    }
}
