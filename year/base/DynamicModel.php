<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/2/10
 * Time: 9:05
 */

namespace year\base;


class DynamicModel extends \yii\base\DynamicModel
{

    /**
     * @var array
     */
    protected $attributeLabels = [];

    /**
     * Defines an attribute.
     * @param string $name the attribute name
     * @param null $label
     * @return $this
     */
    public function setAttributeLabel($name, $label = null)
    {
        $this->attributeLabels[$name] = $label;
        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function unsetAttributeLabel($name)
    {
        unset($this->attributeLabels[$name]);
        return $this;
    }

    /**
     * @param array $attributeLabels
     * @return $this
     */
    public function setAttributeLabels($attributeLabels = [])
    {
        foreach ($attributeLabels as $name => $label) {
            $this->setAttributeLabel($name, $label);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return $this->attributeLabels;
    }

}