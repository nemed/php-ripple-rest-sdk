<?php
namespace ctur\sdk\rest\ripple\lib;
use ctur\sdk\rest\ripple\Ripple;
/**
 * Accounts are the core unit of authentication in the Ripple Network.
 * Each account can hold balances in multiple currencies, and all transactions must be signed by an account’s secret key.
 * In order for an account to exist in a validated ledger version, it must hold a minimum reserve amount of XRP.
 * (The account reserve increases with the amount of data it is responsible for in the shared ledger.)
 * It is expected that accounts will correspond loosely to individual users.
 * @see https://ripple.com/build/rest-tool/#generate-wallet
 *
 * @package ctur\sdk\rest\ripple\lib
 *
 * @author Cyril Turkevich
 */
class Account extends Ripple
{
    /**
     * Randomly generate keys for a potential new Ripple account.
     * @see https://ripple.com/build/ripple-rest/#generate-wallet
     *
     * @return array Generated wallet data.
     */
    public function generateWallet()
    {
        return $this->request('GET', 'wallet/new');
    }

    /**
     * Retrieve the current balances for the given Ripple account.
     * @see https://ripple.com/build/ripple-rest/#get-account-balances
     *
     * @param string $address The Ripple account address of the account whose balances to retrieve.
     * @param array $data Optionally, you can also include any of the following query parameters:
     *
     * string currency	   (ISO 4217 Currency Code)	If provided, only include balances in the given currency.
     * string counterparty (Address) If provided, only include balances issued by the provided address (usually a gateway).
     * string marker	   Server-provided value that marks where to resume pagination.
     * string limit	       (Integer or all)	(Defaults to 200) Max results per response. Cannot be less than 10. Cannot be greater than 400. Use all to return all results
     * string ledger	   (ledger hash or sequence, or ‘validated’, ‘current’, or ‘closed’)(Defaults to ‘validated’) Identifying ledger version to pull results from.
     *
     * @return array The current balances for the given Ripple account.
     */
    public function getAccountBalances($address, array $data)
    {
        return $this->request('GET', "accounts/{$address}/balances", $data);
    }

    /**
     * Retrieve the current settings for the given Ripple account.
     * @see https://ripple.com/build/ripple-rest/#get-account-settings
     *
     * @param string $address The Ripple account address of the account whose settings to retrieve.
     *
     * @return array Response. See api documentation.
     */
    public function getAccountSettings($address)
    {
        return $this->request('GET', "accounts/{$address}/settings");
    }

    /**
     * Change the current settings for the given Ripple account.
     * @see https://ripple.com/build/ripple-rest/#update-account-settings
     *
     * @param string $address The Ripple account address of the account whose settings to retrieve.
     * @param string $secret A secret key for your Ripple account. This is either the master secret, or a regular secret, if your account has one configured.
     * @param array $settings The settings object can contain any of the following fields (any omitted fields are left unchanged):
     *
     * string transfer_rate	          (Quoted decimal number) If set, imposes a fee for transferring balances issued by this account. Must be between 1 and 2, with up to 9 decimal places of precision.
     * bool   require_destination_tag If true, require a destination tag to send payments to this account. (This is intended to protect users from accidentally omitting the destination tag in a payment to a gateway’s hosted wallet.)
     * bool   require_authorization	  If true, require authorization for users to hold balances issued by this account. (This prevents users unknown to a gateway from holding funds issued by that gateway.)
     * bool   disallow_xrp	          If true, XRP should not be sent to this account. (Enforced in clients but not in the server, because it could cause accounts to become unusable if all their XRP were spent.)
     * bool   disable_master	      If true, the master secret key cannot be used to sign transactions for this account. Can only be set to true if a Regular Key is defined for the account.
     * bool   no_freeze	              If true, the account has permanently given up the ability to freeze its trust lines. Cannot be set to false after being true.
     * bool   global_freeze	          If true, freeze all trust lines connected to the account.
     * bool   default_ripple	      If true, enables rippling on this account’s trustlines by default. (New in Ripple-REST v1.5.0)
     * string email_hash	          Hash of an email address to be used for generating an avatar image. Conventionally, clients use Gravatar to display this image.
     * string message_key	          A secp256k1 public key that should be used to encrypt secret messages to this account, as hex.
     * string domain	              The domain that holds this account, as lowercase ASCII. Clients can use this to verify the account in the ripple.txt or host-meta of the domain.
     *
     * @param bool $validated If true, the server waits to respond until the account transaction
     * has been successfully validated by the network.A validated transaction has state field of the response set to "validated".
     *
     * @return array Response. See api documentation.
     */
    public function updateAccountSettings($address, $secret, array $settings, $validated = true)
    {
        return $this->request('POST', "accounts/{$address}/settings?validated={$this->getBool($validated)}", $this->getPostData(['settings' => $settings], $secret));
    }
}
