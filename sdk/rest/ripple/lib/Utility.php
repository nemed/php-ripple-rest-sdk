<?php
namespace ctur\sdk\rest\ripple\lib;
use ctur\sdk\rest\ripple\Ripple;

/**
 * Ripple Utility
 * @see https://ripple.com/build/ripple-rest/#retrieve-ripple-transaction
 *
 * @package ctur\sdk\rest\ripple\lib
 *
 * @author Cyril Turkevich
 */
class Utility extends Ripple
{
    /**
     * Returns a Ripple transaction, in its complete, original format.
     * @see https://ripple.com/build/ripple-rest/#retrieve-ripple-transaction
     *
     * @param string $hash A unique identifier for the Ripple transaction to retrieve — either a client resource ID or a Ripple transaction hash.
     *
     * @return array Response. See api documentation.
     */
    public function retrieveRippleTransaction($hash)
    {
        return $this->request('GET', "transactions/{$hash}");
    }

    /**
     * Retrieve the current transaction fee, in XRP, for the rippled server Ripple-REST is connected to.
     * If Ripple-REST is connected to multiple rippled servers, returns the median fee among the connected servers.
     * @see https://ripple.com/build/ripple-rest/#retrieve-transaction-fee
     *
     * @return array Response. See api documentation.
     */
    public function retrieveTransactionFee()
    {
        return $this->request('GET', 'transaction-fee');
    }

    /**
     * Generate a universally-unique identifier suitable for use as the Client Resource ID for a payment.
     * @see https://ripple.com/build/ripple-rest/#create-client-resource-id
     *
     * @return array Response. See api documentation.
     */
    public function generateUUID()
    {
        return $this->request('GET', 'uuid');
    }
}
