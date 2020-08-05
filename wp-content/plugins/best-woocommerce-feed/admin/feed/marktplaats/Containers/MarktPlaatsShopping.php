<?php

namespace RexTheme\MarktPlaatsShoppingFeed\Containers;

use RexTheme\MarktPlaatsShoppingFeed\Feed;

class MarktPlaatsShopping
{
    /**
     * Feed container
     * @var Feed
     */
    public static $container = null;

    /**
     * Feed namespace
     * @var Feed
     */
    public static $namespace = 'http://admarkt.marktplaats.nl/schemas/1.0';

    /**
     * Feed rss version
     * @var Feed
     */
    public static $version = '';

    /**
     * Feed products wrapper
     * @var Feed
     */
    public static $wrapper = false;

    /**
     * Feed product item wrapper
     * @var Feed
     */
    public static $itemName = 'item';


    public static $rss = 'rss';

    /**
     * Return feed container
     * @return Feed
     */
    public static function container()
    {
        if (is_null(static::$container)) {
            static::$container = new Feed( static::$wrapper, static::$itemName, static::$namespace, static::$version , static::$rss );
        }

        return static::$container;
    }

    /**
     * Init Feed Configuration
     * @return Feed
     */
    public static function init( $wrapper = false, $itemName = 'item', $namespace = null, $version = '' , $rss = 'rss')
    {
        static::$namespace = $namespace;
        static::$version   = $version;
        static::$wrapper   = $wrapper;
        static::$itemName  = $itemName;
        static::$rss       = $rss;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array(array(static::container(), $name), $arguments);
    }
}
