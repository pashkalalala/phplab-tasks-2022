<?php

namespace src\oop\app\src\Parsers;

use Symfony\Component\DomCrawler\Crawler;

class KinoukrDomCrawlerParserAdapter implements ParserInterface
{
    /**
     * @param  string  $siteContent
     * @return mixed
     */
    public function parseContent(string $siteContent)
    {
        $crawler = new Crawler($siteContent);
        
        $movieData['title'] = $crawler->filter('h1')->text();
        $movieData['poster'] = $crawler->filter('.fposter a')->link()->getUri();
        $movieData['description'] = $crawler->filter('.fdesc')->text();
        
        return $movieData;
    }
}