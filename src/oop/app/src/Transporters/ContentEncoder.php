<?php

namespace src\oop\app\src\Transporters;

class ContentEncoder
{
    public function getEncodedContent(string $content, string $contentType)
    {
        preg_match('/charset=(.+)/', $contentType, $matches);
    
        if (mb_strtolower($matches[1]) !== 'utf-8') {
            return iconv($matches[1], mb_detect_encoding($content), $content);
        }
    
        return $content;
    }
}