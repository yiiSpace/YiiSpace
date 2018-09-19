<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-23
 * Time: 下午7:04
 */

namespace year\caching;

use Yii;
use yii\helpers\ArrayHelper;


class SSDBCache extends \yii\caching\Cache
{

    /**
     * @var string
     */
    public $vendorDir = '@app/lib/ssdb';

    /**
     * ~~~
     * 'ssdb' => array(
     * 'host' => '127.0.0.1',
     * 'port' => '8888',
     * 'timeout_ms'=>2000
     * ),
     * ~~~
     *
     * @var array|\SimpleSSDB
     */
    public $ssdb = [

    ];

    public $defaultConfig = [
        'host' => '127.0.0.1',
        'port' => '8888',
        'timeout_ms' => 2000,
    ];

    /**
     * Initializes the ssdb Cache component.
     * This method will initialize the [[ssdb]] property to make sure it refers to a valid ssdb connection.
     * @throws InvalidConfigException if [[ssdb]] is invalid.
     */
    public function init()
    {
        include_once(Yii::getAlias($this->vendorDir) . '/SDDB.php');
        parent::init();
        if (is_array($this->ssdb)) {
            /*
            $host = $this->ssdb['host'];
            $port = $this->ssdb['port'];
            $timeout_ms = isset($this->ssdb['timeout_ms']) ? $this->ssdb['timeout_ms'] :   2000 ;
            */
            $conf = ArrayHelper::merge($this->defaultConfig, $this->ssdb);

            $this->ssdb = new \SimpleSSDB($conf['host'], $conf['port'], $conf['timeout_ms']);
        }
        if (!$this->ssdb instanceof \SimpleSSDB) {
            throw new InvalidConfigException("Cache::ssdb must be either a ssdb connection instance or the application component ID of a ssdb connection.");
        }
    }

    /**
     * Checks whether a specified key exists in the cache.
     * This can be faster than getting the value from the cache if the data is big.
     * Note that this method does not check whether the dependency associated
     * with the cached data, if there is any, has changed. So a call to [[get]]
     * may return false while exists returns true.
     * @param mixed $key a key identifying the cached value. This can be a simple string or
     * a complex data structure consisting of factors representing the key.
     * @return boolean true if a value exists in cache, false if the value is not in the cache or expired.
     */
    public function exists($key)
    {
        return (bool)$this->executeCommand('exists', [$this->buildKey($key)]);
    }

    /**
     * @inheritdoc
     */
    protected function getValue($key)
    {
        return $this->executeCommand('get', [$key]);
    }

    /**
     * @inheritdoc
     */
    protected function getValues($keys)
    {
        $response = $this->executeCommand('multi_get', $keys);
        $result = [];
        $i = 0;
        foreach ($keys as $key) {
            $result[$key] = $response[$i++];
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function setValue($key, $value, $expire)
    {
        if ($expire == 0) {
            return (bool)$this->executeCommand('SET', [$key, $value]);
        } else {
            $expire = (int)($expire * 1000);
            return (bool)$this->executeCommand('SET', [$key, $value, 'PX', $expire]);
        }
    }

    /**
     * @inheritdoc
     */
    protected function setValues($data, $expire)
    {
        $args = [];
        foreach ($data as $key => $value) {
            $args[] = $key;
            $args[] = $value;
        }
        $failedKeys = [];
        if ($expire == 0) {
            $this->executeCommand('MSET', $args);
        } else {
            $expire = (int)($expire * 1000);
            $this->executeCommand('MULTI');
            $this->executeCommand('MSET', $args);
            $index = [];
            foreach ($data as $key => $value) {
                $this->executeCommand('PEXPIRE', [$key, $expire]);
                $index[] = $key;
            }
            $result = $this->executeCommand('EXEC');
            array_shift($result);
            foreach ($result as $i => $r) {
                if ($r != 1) {
                    $failedKeys[] = $index[$i];
                }
            }
        }
        return $failedKeys;
    }

    /**
     * @inheritdoc
     */
    protected function addValue($key, $value, $expire)
    {
        if ($expire == 0) {
            return (bool)$this->executeCommand('SET', [$key, $value, 'NX']);
        } else {
            $expire = (int)($expire * 1000);
            return (bool)$this->executeCommand('SET', [$key, $value, 'PX', $expire, 'NX']);
        }
    }

    /**
     * @inheritdoc
     */
    protected function deleteValue($key)
    {
        return (bool)$this->executeCommand('DEL', [$key]);
    }

    /**
     * @inheritdoc
     */
    protected function flushValues()
    {
        return $this->executeCommand('FLUSHDB');
    }

    protected function executeCommandd($name, $params = [])
    {
        return call_user_func([$this->ssdb,$name],$params);
    }
}