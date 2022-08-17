<?php

namespace src\oop\app\src\Transporters;

use GuzzleHttp\Client;

class GuzzleAdapter implements TransportInterface
{
    public Client $client;
    public ContentEncoder $encoder;
    
    public function __construct()
    {
        $this->client = new Client();
        $this->encoder = new ContentEncoder();
    }
    
    public function getContent(string $url): string
    {
        $res = $this->client->request('GET', $url);
        
        $content = $res->getBody();
        $contentType =$res->getHeader('content-type')[0];
        
        return $this->encoder->getEncodedContent( $content, $contentType);
    }
}