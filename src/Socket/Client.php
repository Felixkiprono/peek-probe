<?php

namespace Peek\Probe\Socket;

use Peek\Probe\Settings\Configuration;

class Client
{

    public $client;
    public $configuration = null;
    /**
     * __construct
     *
     * @param  mixed $_configuration
     * @return void
     */
    public function __construct(Configuration $_configuration)
    {
        $this->configuration = $_configuration;
    }

    public function __destruct()
    {
        if ($this->client) {
            curl_close($this->client);
            $this->client = null;
        }
    }
    /**
     * sendRequest
     *
     * @param  mixed $message
     * @return void
     */
    public function sendRequest($message)
    {


        $data = "";
        if (is_array($message)) {
            $data = json_encode($message);
        }
        if (is_object($message)) {
            $data = json_encode($message);
        }
        if (is_string($message)) {
            $data = $message;
        }
        if (is_numeric($message)) {
            $data = $message;
        }


        $this->getClient(true, 2);

        if (!$this->isServerOn()) {
            return;
        }
        if ($this->client) {
            curl_setopt($this->client, CURLOPT_POSTFIELDS, $data);
            $response = curl_exec($this->client);
            if (curl_errno($this->client)) {
                echo 'Error:' . curl_error($this->client);
            } else {
                echo "Response from server: $response\n";
            }
        }
    }



    /**
     * getClient
     *
     * @param  mixed $isPost
     * @param  mixed $timeout
     * @return void
     */
    public function getClient(bool $isPost = true, $timeout = 5)
    {
        $host  = $this->configuration->_get('host');
        $port  = $this->configuration->_get('port');
        $url = "$host:$port";
        $client = curl_init();
        curl_setopt($client, CURLOPT_USERAGENT, 'PeekProbe 1.0');
        curl_setopt($client, CURLOPT_URL, $url);
        curl_setopt($client, CURLOPT_HTTPHEADER, array_merge([
            'Accept: application/json',
            'Content-Type: application/json',
        ]));
        curl_setopt($client, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($client, CURLOPT_ENCODING, '');
        curl_setopt($client, CURLINFO_HEADER_OUT, true);
        curl_setopt($client, CURLOPT_FAILONERROR, true);
        if ($isPost) {
            curl_setopt($client, CURLOPT_POST, true);
        }
        $this->client =  $client;
    }

    /**
     * isServerOn
     *
     * @return bool
     */
    public function isServerOn(): bool
    {
        try {
            $this->getClient(false, 2);
            $response = curl_exec($this->client);
            $isOn = !(curl_errno($this->client) === CURLE_HTTP_NOT_FOUND);
            curl_close($this->client);
        } finally {
            return $isOn ?? false;
        }
    }
}
