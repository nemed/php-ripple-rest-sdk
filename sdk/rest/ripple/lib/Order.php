<?php
namespace ctur\sdk\rest\ripple\lib;
use ctur\sdk\rest\ripple\Ripple;

/**
 * Class Order implements REST method for get orders data.
 * @see https://ripple.com/build/ripple-rest/#place-order
 *
 * @package ctur\sdk\rest\ripple\lib
 *
 * @author Cyril Turkevich
 */
class Order extends Ripple
{
    /**
     * Places an order to exchange currencies.
     * @see https://ripple.com/build/ripple-rest/#place-order
     *
     * @param string $address The Ripple account address the account creating the order.
     * @param string $secret A secret key for your Ripple account. This is either the master secret, or a regular secret, if your account has one configured.
     * @param array $order The order to place.
     * @param bool $validated true or false. When set to true, will force the request to wait until the trustline transaction has been successfully validated by the server.
     * A validated transaction will have the state attribute set to "validated" in the response.
     *
     * @return array Response data. See api documentation.
     */
    public function placeOrder($address, $secret, array $order, $validated = true)
    {
        return $this->request('POST', "accounts/{$address}/orders?validated={$this->getBool($validated)}", $this->getPostData(['order' => $order], $secret));
    }

    /**
     * Deletes a previous order to exchange currencies.
     * @see https://ripple.com/build/ripple-rest/#cancel-order
     *
     * @param string $address The Ripple account address of an account involved in the transaction.
     * @param string $secret A secret key for your Ripple account. This is either the master secret, or a regular secret, if your account has one configured.
     * @param int $order The sequence number of the order to cancel.
     * @param bool $validated true or false. When set to true, will force the request to wait until the trustline transaction has been successfully validated by the server.
     * A validated transaction will have the state attribute set to "validated" in the response.
     *
     * @return array Response data. See api documentation.
     */
    public function cancelOrder($address, $secret, $order, $validated = true)
    {
        return $this->request('DELETE', "accounts/{$address}/orders/{$order}?validated={$this->getBool($validated)}", ['secret' => $secret]);
    }

    /**
     * Retrieves all open currency-exchange orders associated with the Ripple address.
     * @see https://ripple.com/build/ripple-rest/#get-account-orders
     *
     * @param string $address The Ripple account address whose orders to look up.
     * @param array $data Optionally, you can also include the following query parameters:
     * string	    marker  Start position in response paging.
     * string|int   limit   (Defaults to 200) Max results per response. Cannot be less than 10. Cannot be greater than 400.
     * string	    ledger  Ledger to request paged results from. Use the ledger’s hash.
     *
     * @return array The response is an object with a orders array, where each member is a order object.
     */
    public function getAccountOrders($address, array $data = [])
    {
        return $this->request('GET', "accounts/{$address}/orders", $data);
    }

    /**
     * Get the details of an order transaction. An order transaction either places an order or cancels an order.
     * @see https://ripple.com/build/ripple-rest/#get-order-transaction
     *
     * @param string $address The Ripple account address whose orders to look up.
     * @param string $hash The transaction hash for the order.
     *
     * @return array Response data. See api documentation.
     */
    public function getOrderTransaction($address, $hash)
    {
        return $this->request('GET', "accounts/{$address}/orders/{$hash}");
    }

    /**
     * Retrieves the top of the order book for a currency pair.
     * @see https://ripple.com/build/ripple-rest/#get-order-book
     *
     * @param string $address The Ripple account address whose orders to look up.
     * @param string $base The base currency as currency+counterparty (e.g., USD+)
     * @param string $counter The counter currency as currency+counterparty (e.g., BTC+)
     * @param array $data Optionally, you can also include the following query parameters:
     * string|int limit (Defaults to 200) Max results per response. Cannot be less than 10. Cannot be greater than 400.
     *
     * @return array The response includes bids and asks arrays that contain bid objects.
     */
    public function getOrderBook($address, $base, $counter, array $data)
    {
        return $this->request('GET', "accounts/{$address}/order_book/{$base}/{$counter}", $data);
    }
}
