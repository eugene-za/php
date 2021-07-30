<?php


namespace core;


trait Singleton
{

    private static $instance;


    public static function instance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}