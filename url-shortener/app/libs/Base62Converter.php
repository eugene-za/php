<?php
/**
 * Class for encode/decode shortcodes that are used for shortened URLs
 * Generating a base 62 number from a base 10 ID
 */


namespace libs;


class Base62Converter
{

    private static int $base = 62;
    private static string $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';


    /**
     * @param int $num
     * @return string
     */
    static function encode(int $num)
    {
        $r = $num % self::$base;
        $res = self::$chars[$r];
        $q = floor($num / self::$base);

        while ($q) {
            $r = $q % self::$base;
            $q = floor($q / self::$base);
            $res = self::$chars[$r] . $res;
        }

        return $res;
    }


    /**
     * @param string $num
     * @return int
     */
    static function decode(string $num)
    {
        $limit = strlen($num);
        $res = strpos(self::$chars, $num[0]);
        for ($i = 1; $i < $limit; $i++) {
            $res = self::$base * $res + strpos(self::$chars, $num[$i]);
        }
        return $res;
    }

}
