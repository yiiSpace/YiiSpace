<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/8
 * Time: 10:23
 */

namespace year\base;

/**
 * Class Singleton
 * @package year\base
 */
trait Singleton
{
    protected static $instance;

    /**
     * Create a new instance of this singleton.
     */
    final public static function instance()
    {
        return isset(static::$instance)
            ? static::$instance
            : static::$instance = new static;
    }

    /**
     * Constructor.
     */
    final protected function __construct()
    {
        $this->init();
    }

    /**
     * Initialize the singleton free from constructor parameters.
     */
    protected function init() {}

    public function __clone()
    {
        trigger_error('Cloning '.__CLASS__.' is not allowed.', E_USER_ERROR);
    }

    public function __wakeup()
    {
        trigger_error('Unserializing '.__CLASS__.' is not allowed.', E_USER_ERROR);
    }
}