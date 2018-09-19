<?php
/**
 * User: yiqing
 * Date: 2014/10/4
 * Time: 16:35
 */

namespace year\app;


interface SettingsInterface {

    /**
     * CmsSettings::set()
     *
     * @param string $category name of the category
     * @param mixed $key
     * can be either a single item (string) or an array of item=>value pairs
     * @param mixed $value value to set for the key, leave this empty if $key is an array
     * @param bool $toDatabase whether to save the items to the database
     * @return CmsSettings
     */
    public function set($category='system', $key='', $value='', $toDatabase=true);

    /**
     * CmsSettings::get()
     *
     * @param string $category name of the category
     * @param mixed $key
     * can be either :
     * empty, returning all items of the selected category
     * a string, meaning a single key will be returned
     * an array, returning an array of key=>value pairs
     * @param string $default the default value to be returned
     * @return mixed
     */
    public function get($category='system', $key='', $default=null);

    /**
     * delete an item or all items from a category
     *
     * @param string $category the name of the category
     * @param string|array $key
     * can be either:
     * empty, meaning it will delete all items of the selected category
     * a single key
     * an array of keys
     * @return CmsSettings
     */
    public function delete($category, $key='');


    /**
     * load from database the items of the specified category
     *
     * @param string $category
     * @return array the items of the category
     */
    public function load($category);

    /**
     * @return mixed
     */
    public function toArray();
} 