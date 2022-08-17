<?php

namespace src\oop\app\src;

use src\oop\app\src\Models\Movie;
use src\oop\app\src\Parsers\ParserInterface;
use src\oop\app\src\Transporters\TransportInterface;

/**
 * Create Class - Scrapper with method getMovie().
 * getMovie() - should return Movie Class object.
 *
 * Note: Use next namespace for Scrapper Class - "namespace src\oop\app\src;"
 * Note: Dont forget to create variables for TransportInterface and ParserInterface objects.
 * Note: Also you can add your methods if needed.
 */

class Scrapper
{
    private TransportInterface $transporter;
    private ParserInterface $parser;
    
    /**
     * @param  TransportInterface  $transporter
     * @param  ParserInterface  $parser
     */
    public function __construct(TransportInterface $transporter, ParserInterface $parser)
    {
        $this->transporter = $transporter;
        $this->parser = $parser;
    }
    
    /**
     * @param  string  $url
     * @return Movie
     */
    public function getMovie(string $url) : Movie
    {
        $getData = $this->transporter->getContent($url);
        $data = $this->parser->parseContent($getData);

        $movie = new Movie();
        
        $movie->setTitle($data['title']);
        $movie->setPoster($data['poster']);
        $movie->setDescription($data['description']);
        
        return $movie;
    }
}