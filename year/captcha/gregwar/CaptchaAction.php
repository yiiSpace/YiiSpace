<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/16
 * Time: 11:11
 */

namespace year\captcha\gregwar;

use Gregwar\Captcha\CaptchaBuilder;

/**
 * TODO 其余的设置属性 想办法设置到底层的组件上
 *
 * Class CaptchaAction
 * @package year\captcha\gregwar
 */
class CaptchaAction extends \yii\captcha\CaptchaAction {

    /**
     *
     * Renders the CAPTCHA image.
     * @param string $code the verification code
     * @return string image contents
     */
    protected function renderImage($code)
    {
        /*
        if (Captcha::checkRequirements() === 'gd') {
            return $this->renderImageByGD($code);
        } else {
            return $this->renderImageByImagick($code);
        }
        */

        $builder = new CaptchaBuilder($code);
        $builder->build($this->width,$this->height);
        $quality = 90 ;
        return $builder->get($quality);
    }
}