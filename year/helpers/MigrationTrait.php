<?php
/**
 * User: yiqing
 * Date: 14-8-1
 * Time: 上午12:33
 */

namespace year\helpers;


trait MigrationTrait {

    /**
     * not null specification
     * see communitiyii/yii2-user
     */
    public static  $NOT_NULL = ' NOT NULL ';
    // default timestamp
    public static  $DEFAULT_TIME = " DEFAULT '0000-00-00 00:00:00' ";

    /**
     * @return null|string
     * @throws RuntimeException
     */
    public function getTableOptions()
    {
        $tableOptions = null;
        switch (\Yii::$app->db->driverName) {
            case 'mysql':
                $tableOptions = ' CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB ';
                break;
            case 'pgsql':
                $tableOptions = null;
                break;
            default:
                throw new \RuntimeException('Your database is not supported!');
        }
        return $tableOptions ;
    }
} 