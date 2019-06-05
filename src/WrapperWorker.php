<?php
/**
 * Created by PhpStorm.
 * User: Meklis
 * Date: 04.06.2019
 * Time: 20:52
 */

namespace SnmpWrapper;


class WrapperWorker
{
    protected $wrapperAddress;
    protected $client;

    /**
     * SnmpWrapper constructor.
     * @param string $wrapperAddress
     */
    function __construct($wrapperAddress = "http://127.0.0.1:83")
    {
        $this->wrapperAddress = $wrapperAddress;
        $this->client = new \GuzzleHttp\Client(
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]
        );
    }

     /**
      * @param Request\PoollerRequest[] $req
      * @return Response\PoollerResponse[]
     */
    function get(array $req)
    {
        $data = $this->client->post($this->wrapperAddress . "/api/get", [\GuzzleHttp\RequestOptions::JSON => $req]);
        return \GuzzleHttp\json_decode($data->getBody()->getContents());
    }

    /**
     * @param Request\PoollerRequest[] $req
     * @return Response\PoollerResponse[]
     */
    function set(array $req)
    {
        $data = $this->client->post($this->wrapperAddress . "/api/set", [\GuzzleHttp\RequestOptions::JSON => $req]);
        return \GuzzleHttp\json_decode($data->getBody()->getContents());
    }

    /**
     * @param Request\PoollerRequest[] $req
     * @return Response\PoollerResponse[]
     */
    function walk(array $req)
    {
        $data = $this->client->post($this->wrapperAddress . "/api/walk", [ \GuzzleHttp\RequestOptions::JSON => $req]);
        return \GuzzleHttp\json_decode($data->getBody()->getContents());
    }

    /**
     * @param Request\PoollerRequest[] $req
     * @return Response\PoollerResponse[]
     */
    function walkBulk(array $req)
    {
        $data = $this->client->post($this->wrapperAddress . "/api/bulk_walk", [\GuzzleHttp\RequestOptions::JSON => $req]);
        return \GuzzleHttp\json_decode($data->getBody()->getContents());
    }

}