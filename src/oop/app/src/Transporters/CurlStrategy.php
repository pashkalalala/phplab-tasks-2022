<?php

namespace src\oop\app\src\Transporters;

class CurlStrategy implements TransportInterface
{
    public ContentEncoder $encoder;
    
    public function __construct()
    {
        $this->encoder = new ContentEncoder();
    }
    
    public function getContent(string $url): string
    {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        
        $html = curl_exec($ch);

        curl_close($ch);
        
        return $this->encoder->getEncodedContent($html, curl_getinfo($ch, CURLINFO_CONTENT_TYPE));
    }
}