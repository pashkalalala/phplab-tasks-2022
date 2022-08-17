<?php

namespace src\oop\app\src\Parsers;

class FilmixParserStrategy implements ParserInterface
{
    /**
     * @param  string  $siteContent
     * @return mixed
     */
    public function parseContent(string $siteContent)
    {
        preg_match('/<h1.*?>(.*?)<\/h1>/su', $siteContent, $res);
        $movieData['title'] = $res[1];
        preg_match('/<a\sclass="fancybox".*?href="(.+?)"/su', $siteContent, $res);
        $movieData['poster'] = $res[1];
        preg_match('/<div\sclass="full-story">(.+?)<\/div>/su', $siteContent, $res);
        $movieData['description'] = $res[1];
        
        return $movieData;
    }
}