<?php

namespace Peek\Probe\Socket;

use Peek\Probe\Settings\Configuration;

class Client
{

    public $configuration = null;
    public function __construct(Configuration $_configuration)
    {
        $this->configuration = $_configuration;
    }
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

        $client = $this->getClient(true);

        if ($client) {
            curl_setopt($client, CURLOPT_POSTFIELDS, $data);
            $response = curl_exec($client);
            if (curl_errno($client)) {
                echo 'Error:' . curl_error($client);
            } else {
                echo "Response from server: $response\n";
            }
        }
    }


    public function getClient($isPost = true)
    {
        $host  = $this->configuration->_get('host');
        $port  = $this->configuration->_get('port');
        $url = "$host:$port";

        $client = curl_init();
        curl_setopt($client, CURLOPT_URL, $url);
        curl_setopt($client, CURLOPT_PORT, $port);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        if ($isPost) {
            curl_setopt($client, CURLOPT_POST, true);
        }
        return $client;
    }
}
