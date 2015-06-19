<?php
namespace ctur\sdk\rest\ripple\lib;
use ctur\sdk\rest\ripple\Ripple;

/**
 * ripple-rest provides access to ripple-lib‘s robust transaction submission processes.
 * This means that it will set the fee, manage the transaction sequence numbers, sign the transaction with your secret,
 * and resubmit the transaction up to 10 times if rippled reports an initial error that can be solved automatically.
 * @see https://ripple.com/build/ripple-rest/#prepare-payment
 *
 * @package app\modules\ripple\components
 *
 * @author Cyril Turkevich
 */
class Payment extends Ripple
{
    /**
     * Get quotes for possible ways to make a particular payment.
     * @see https://ripple.com/build/ripple-rest/#prepare-payment
     *
     * @param string $fromAddress The Ripple address for the account that would send the payment.
     * @param string $toAddress The Ripple address for the account that would receive the payment.
     * @param string $amount (URL-formatted Amount) The amount that the destination account should receive.
     * @param array $data Optionally, you can also include the following as a query parameter:
     *
     * string  source_currencies Comma-separated list of source currencies. Each should be an ISO 4217 currency code, or a {:currency}+{:counterparty} string.
     * Filters possible payments to include only ones that spend the source account’s balances in the specified currencies.
     * If a counterparty is not specified, include all issuances of that currency held by the sending account.
     *
     * @return array Response. See api documentation.
     */
    public function preparePayment($fromAddress, $toAddress, $amount, array $data = [])
    {
        return $this->request('GET', "accounts/{$fromAddress}/payments/paths/{$toAddress}/{$amount}", $data);
    }

    /**
     * Submit a payment object to be processed and executed.
     * @see https://ripple.com/build/ripple-rest/#submit-payment
     *
     * @param string $address The Ripple account address of the account whose settings to retrieve.
     * @param string $secret A secret key for your Ripple account. This is either the master secret, or a regular secret, if your account has one configured.
     * @param array $data The JSON body of the request includes the following parameters:
     *
     * array   payment	            Payment object	The payment to send. You can generate a payment object using the Prepare Payment method.
     * string  client_resource_id   A unique identifier for this payment. You can generate one using the GET /v1/uuid method.
     * string  secret	            A secret key for your Ripple account. This is either the master secret, or a regular secret, if your account has one configured.
     * string  last_ledger_sequence	(Optional) A string representation of a ledger sequence number. If this parameter is not set, it defaults to the current ledger sequence plus an appropriate buffer.
     * string  max_fee	            (Optional) The maximum transaction fee to allow, as a decimal amount of XRP.
     * string  fixed_fee            (Optional) The exact transaction fee the payer wishes to pay to the server, as a decimal amount of XRP.
     *
     * @param bool $validated If true, the server waits to respond until the payment has been successfully validated by the network and returns the payment object.
     * Otherwise, the server responds immediately with a message indicating that the transaction was received for processing
     *
     * @return array Response. See api documentation.
     */
    public function submitPayment($address, $secret, array $data, $validated = true)
    {
        return $this->request('POST', "accounts/{$address}/payments?validated={$this->getBool($validated)}", $this->getPostData($data, $secret));
    }

    /**
     * Retrieve the details of a payment, including the current state of the transaction and the result of transaction processing.
     * @see https://ripple.com/build/ripple-rest/#confirm-payment
     *
     * @param string $address The Ripple account address of an account involved in the transaction.
     * @param string $id A unique identifier for the transaction: either a client resource ID or a transaction hash.
     *
     * @return array Response. See api documentation.
     */
    public function confirmPayment($address, $id)
    {
        return $this->request('GET', "/accounts/{$address}/payments/{$id}");
    }

    /**
     * Retrieve a selection of payments that affected the specified account.
     * @see https://ripple.com/build/ripple-rest/#get-payment-history
     *
     * @param string $address The Ripple account address of an account involved in the transaction.
     * @param array $data Optionally, you can also include the following query parameters:
     *
     * string  source_account	   (Address) If provided, only include payments sent by a given account.
     * string  destination_account (Address) If provided, only include payments received by a given account.
     * bool    exclude_failed	   If true, only include successful transactions. Defaults to false.
     * string  direction	       If provided, only include payments of the given type. Valid values include "incoming" (payments received by this account) and "outgoing" (payments sent by this account).
     * bool    earliest_first	   If true, sort results with the oldest payments first. Defaults to false (sort with the most recent payments first).
     * int     start_ledger	       (Ledger sequence number)	If provided, exclude payments from ledger versions older than the given ledger.
     * int     end_ledger	       (Ledger sequence number)	If provided, exclude payments from ledger versions newer than the given ledger.
     * int     results_per_page	   The maximum number of payments to be returned at once. Defaults to 10.
     * int     page	               The page number for the results to return, if more than results_per_page are available. The first page of results is page 1, the second page is number 2, and so on. Defaults to 1.
     *
     * @return array Response. See api documentation.
     */
    public function getPaymentHistory($address, array $data = [])
    {
        return $this->request('GET', "/accounts/{$address}/payments", $data);
    }
}
