<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/4/25
 * Time: 13:18
 */

namespace year\gii\goodmall\utils;


use yii\validators\Validator;

/**
 * Class QualifiedTypeValidator
 * @package year\gii\goodmall\utils
 */
class QualifiedTypeValidator extends Validator
{
    /**
     * TODO 有空了写一个完整的验证规则  比如： bu github.com/beego/bee/utils.DocValue
     *
     * @var string
     */
    public $pattern = '/\w+\.\w+$/';


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {

            $this->message = \Yii::t('goodmall_gotype', '{attribute} is not a valid qualified go type. should like  <pkgPath>/<pkgName>.<TypeName>');
        }
    }

    /**
     * Validates a value.
     * A validator class can implement this method to support data validation out of the context of a data model.
     * @param mixed $value the data value to be validated.
     * @return array|null the error message and the parameters to be inserted into the error message.
     * Null should be returned if the data is valid.
     * @throws NotSupportedException if the validator does not supporting data validation without a model
     */
    protected function validateValue($value)
    {
        if (preg_match($this->pattern, $value) !== 1) {
            return [$this->message, []];
        }

        return null ;
    }

}