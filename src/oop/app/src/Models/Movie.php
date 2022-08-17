<?php

namespace src\oop\app\src\Models;

class Movie implements MovieInterface
{
    private string $title;
    private string $poster;
    private string $description;
    
    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    
    public function getPoster(): string
    {
        return $this->poster;
    }
    
    public function setPoster(string $poster): void
    {
        $this->poster = $poster;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}