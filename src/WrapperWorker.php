<?php
/**
 * Created by PhpStorm.
 * User: Meklis
 * Date: 04.06.2019
 * Time: 20:52
 */

namespace SnmpWrapper;


use GuzzleHttp\Psr7\Response;
use Karriere\JsonDecoder\JsonDecoder;
use Psr\Http\Message\ResponseInterface;
use SnmpWrapper\Response\PoollerResponse;
use SnmpWrapper\Response\SnmpResponse;

class WrapperWorker
{
    protected $wrapperAddress;
    /**
     * @var \GuzzleHttp\Client
     */
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
      * @param \SnmpWrapper\Request\PoollerRequest[] $req
      * @return \SnmpWrapper\Response\PoollerResponse[]
     */
    function get(array $req)
    {
        $data = $this->client->post($this->wrapperAddress . "/api/get", [\GuzzleHttp\RequestOptions::JSON => $req]);
        return $this->prepareResp($data);
    }

    /**
     * @param \SnmpWrapper\Request\PoollerRequest[] $req
     * @return \SnmpWrapper\Response\PoollerResponse[]
     */
    function set(array $req)
    {
        $data = $this->client->post($this->wrapperAddress . "/api/set", [\GuzzleHttp\RequestOptions::JSON => $req]);
        return $this->prepareResp($data);
    }

    /**
     * @param \SnmpWrapper\PoollerRequest[] $req
     * @return \SnmpWrapper\PoollerResponse[]
     */
    function walk(array $req) {

        $data = $this->client->post($this->wrapperAddress . "/api/walk", [ \GuzzleHttp\RequestOptions::JSON => $req]);
        return $this->prepareResp($data);
    }

    /**
     * @param \SnmpWrapper\Request\PoollerRequest[] $req
     * @return \SnmpWrapper\Response\PoollerResponse[]
     */
    function walkBulk(array $req)
    {
        $data = $this->client->post($this->wrapperAddress . "/api/bulk_walk", [\GuzzleHttp\RequestOptions::JSON => $req]);
        return $this->prepareResp($data);
    }
    protected function prepareResp(ResponseInterface $data) {
        $decoder = new JsonDecoder(true);
        if(!in_array($data->getStatusCode(), [200,201,400] )) {
            throw new \Exception("Incorrect response from snmp walker: " . $data->getReasonPhrase());
        }
        $result = $decoder->decodeMultiple($data->getBody()->getContents(), PoollerResponse::class);
        if ($result->error) {
            throw new \Exception("Returned error from walker: {$result->error}");
        }
        foreach ($result as $num=>$pool) {
            $responses = [];

            foreach ($pool->response as $resp) {
                $responses[] = $decoder->decodeArray($resp, SnmpResponse::class);
            }
            $result[$num]->response = $responses;
        }
        return $result;
    }
}