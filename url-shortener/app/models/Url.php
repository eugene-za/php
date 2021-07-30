<?php

namespace models;


class Url extends \core\Model
{

    /**
     * Database table name
     */
    const TABLE = 'urls';

    /**
     * @var string Original url
     */
    public string $url;

    /**
     * @var int Hits total count
     */
    public int $hits = 0;


    /**
     * Get Url instance
     * @param int $id ID of row in database
     * @return bool|object Returns Url object or FALSE if not exists in database
     */
    public static function read(int $id): object|bool
    {
        return parent::selectRow($id);
    }


    /**
     * Creating new Url
     * @param string $url Original URL string
     */
    public function create(string $url)
    {
        $this->url = $url;
        $this->id = $this->insertRow();
    }


    /**
     * Increment total Hits count
     */
    public function incrementHits()
    {
        $this->hits++;
        $this->updateRow(['hits']);
    }

}