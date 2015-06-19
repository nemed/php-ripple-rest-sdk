<?php
namespace ctur\sdk\rest\ripple\lib;
use ctur\sdk\rest\ripple\Ripple;

/**
 * Trustlines
 * @see https://ripple.com/build/ripple-rest/#get-trustlines
 *
 * @package app\modules\ripple\components
 *
 * @author Cyril Turkevich
 */
class Trustline extends Ripple
{

    /**
     * Retrieves all trustlines associated with the Ripple address.
     * @see https://ripple.com/build/ripple-rest/#get-trustlines
     *
     * @param string $address The Ripple account address whose trustlines to look up.
     * @param array $data Optionally, you can also include the following query parameters:
     *
     * string      currency	    (ISO4217 currency code)	Filter results to include only trustlines for the given currency.
     * string      counterparty	(Address)	Filter results to include only trustlines to the given account.
     * string      marker	    Start position in response paging.
     * string|int  limit	    (Integer or ‘all’) (Defaults to 200) Max results per response. Cannot be less than 10. Cannot be greater than 400. Use ‘all’ to return all results
     * string      ledger	    (ledger hash or sequence, or ‘validated’, ‘current’, or ‘closed’) (Defaults to ‘validated’) Identifying ledger version to pull results from.
     *
     * @return array Response. See api documentation.
     */
    public function getTrustline($address, array $data = [])
    {
        return $this->request('GET', "accounts/{$address}/trustlines", $data);
    }

    /**
     * Creates or modifies a trustline.
     * @see https://ripple.com/build/ripple-rest/#grant-trustline
     *
     * @param string $address The Ripple account address of the account whose settings to retrieve.
     * @param string $secret A secret key for your Ripple account. This is either the master secret, or a regular secret, if your account has one configured.
     * @param array $trustlines From the perspective of an account on one side of the trustline, the trustline has the following fields:
     *
     * string  account	                      (Address)	This account
     * string  counterparty	                  (Address)	The account at the other end of the trustline
     * string  currency	                      Currency code for the type of currency that is held on this trustline.
     * string  limit	                      (Quoted decimal)	The maximum amount of currency issued by the counterparty account that this account should hold.
     * string  reciprocated_limit	          (Quoted decimal)	(Read-only) The maximum amount of currency issued by this account that the counterparty account should hold.
     * bool    account_allows_rippling	      If set to false on two trustlines from the same account, payments cannot ripple between them. (See the NoRipple flag for details.)
     * bool    counterparty_allows_rippling	  (Read-only) If false, the counterparty account has the NoRipple flag enabled.
     * bool    account_trustline_frozen	      Indicates whether this account has frozen the trustline. (account_froze_trustline prior to v1.4.0)
     * bool    counterparty_trustline_frozen  (Read-only) Indicates whether the counterparty account has frozen the trustline. (counterparty_froze_line prior to v1.4.0)
     *
     * @param bool $validated true or false. When set to true, will force the request to wait until the trustline transaction has been successfully validated by the server.
     * A validated transaction will have the state attribute set to "validated" in the response.
     *
     * @return array Response. See api documentation.
     */
    public function grantTrustline($address, $secret, array $trustlines, $validated = true)
    {
        return $this->request('POST', "accounts/{$address}/trustlines?validated={$this->getBool($validated)}", $this->getPostData(['trustlines' => $trustlines], $secret));
    }
}
