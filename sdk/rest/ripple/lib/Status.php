<?php
namespace ctur\sdk\rest\ripple\lib;
use ctur\sdk\rest\ripple\Ripple;

/**
 * Rippled Server Status
 * The following two endpoints can be used to check if the ripple-rest API is currently connected to a rippled server,
 * and to retrieve information about the current status of the API.
 * @see https://ripple.com/build/ripple-rest/#check-connection
 *
 * @package ctur\sdk\rest\ripple\lib
 *
 * @author Cyril Turkevich
 */
class Status extends Ripple
{
    /**
     * Perform a simple ping to make sure that the server is working properly.
     * @see https://ripple.com/build/ripple-rest/#check-connection
     *
     * @return array Response. See api documentation.
     */
    public function checkConnection()
    {
        return $this->request('GET', 'server/connected');
    }

    /**
     * Retrieve information about the current status of the Ripple-REST API and the rippled server it is connected to.
     * @see https://ripple.com/build/ripple-rest/#get-server-status
     *
     * @return array Response. See api documentation.
     */
    public function getServerStatus()
    {
        return $this->request('GET', 'server');
    }
}
