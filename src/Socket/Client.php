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


        $client = $this->getClient(true, 2);

        if ($this->isServerOn()) {
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
    }


    public function getClient($isPost = true, $timeout = 5)
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
        return $client;
    }

    public function isServerOn()
    {
        $ch = $this->getClient(false, 2);
        $response = curl_exec($ch);
        $error = curl_errno($ch);
        curl_close($ch);

        if ($error == 0) {
            return true; // Port is open
        } else {
            return false; // Port is closed or unreachable
        }
    }
}
