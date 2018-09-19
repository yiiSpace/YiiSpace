<?php
/**
 * User: yiqing
 * Date: 2014/11/26
 * Time: 8:25
 */

namespace year\helpers;

use Yii;
use yii\helpers\Url;

$dir = dirname(__FILE__);
//$alias = md5($dir);
define('WEB_JUMPER_BASE_PATH_ALIAS', '@' . md5($dir));

Yii::setAlias(WEB_JUMPER_BASE_PATH_ALIAS, $dir . DIRECTORY_SEPARATOR . 'WebJumper');

/**
 * TODO 有时间分离 原先只想给alice用  现在后台也需要了 bootstrap的还要做一套出来 目前比较混乱 《策略模式》+ 《工厂方法》即可
 * TODO 重构为 （ Trait + widget + 应用程序组件 ） 其中组件允许配置使用哪种皮肤 widget主要是支持多皮肤  trait用来方便操作IDE 智能提示功能1
 *
 * 对于在新窗体打开并想返回一步的可以用类似逻辑：
        location.href = document.referrer;
        // document.referrer是获取上一页的url
 *
 *
 * 每种皮肤是一个策略 实现共同接口 然后工厂方法中通过判断当前的皮肤名称 选择不同的策略
 *
 * Class WebJumperTrait
 * @package year\helpers
 */
trait WebJumperTrait
{

    static $TipStyleMessage = 'message';
    static $TipStyleInfo = 'info';
    static $TipStyleSuccess = 'success';
    static $TipStyleDanger = 'danger';
    static $TipStyleWarning = 'warning';
    static $TipStyleQuestion = 'question';

    /**
     * @var array
     */
    public static $tipBoxMap = [
        'success' => '<i class="iconfont" title="成功">&#xF049;</i>',
        'message' => '<i class="iconfont" title="提示">&#xF046;</i>',
        'error' => ' <i class="iconfont" title="出错">&#xF045;</i>',
        'warning' => '<i class="iconfont" title="警告">&#xF047;</i>',
        'stop' => '<i class="iconfont" title="阻止">&#xF048;</i>',
        'wait' => '<i class="iconfont" title="等待">&#xF04B;</i>',
        'question' => '<i class="iconfont" title="疑问">&#xF04A;</i>',
    ];

    /**
     * @param string $tipBoxStyle
     * @return string
     */
    public static function getTipBoxIcon($tipBoxStyle = 'message')
    {
        if (isset(static::$tipBoxMap[$tipBoxStyle])) {
            return static::$tipBoxMap[$tipBoxStyle];
        } else {
            return '';
        }
    }

    /**
     * @var string
     */
    protected $jumperBasePath = WEB_JUMPER_BASE_PATH_ALIAS;

    /**
     * @return string
     */
    public function getJumperBasePath()
    {
        $viewDir = 'bootstrap';

        $theme = Yii::$app->view->theme;
        if ($theme instanceof \year\base\Theme) {
            // $viewDir = $theme->active ;
            if ($theme->active == 'alice') {
                $viewDir = 'alice';
            }
        }

        return $this->jumperBasePath . '/' . $viewDir;
    }

    /**
     * @param string $basePathAlias
     * @return $this
     */
    public function setJumperBasePath($basePathAlias = '')
    {
        $this->jumperBasePath = $basePathAlias;
        return $this;
    }

    /**
     * 若干秒后自动跳转到指定的URL上
     * @param  $url
     * @param string $msg
     * @param string $tipBoxStyle 参考支付宝tipBox样式：
     * @param int $secs
     * @return void
     */
    public function jumpTo($url, $msg = '', $tipBoxStyle = 'message', $secs = 5)
    {
        if (is_array($url)) {
            $url = Url::to($url);
        }
        $controller = \Yii::$app->controller;
        //$controller->layout = $this->layout;

        // $controller->render('//public/jumpTo',array('url'=>$url,'msg'=>$msg,'secs'=>$secs));
        $basePathAlias = $this->getJumperBasePath();

        return $controller->render($basePathAlias . '/jumpTo', array(
                'url' => $url, 'msg' => $msg, 'secs' => $secs,
                'tipBoxStyle' => $tipBoxStyle, 'tipBoxIcon' => static::getTipBoxIcon($tipBoxStyle),
            )
        );

    }

    public function jumpToDialog($url, $msg = '', $secs = 5)
    {
        $controller = Yii::$app->controller;
        //$controller->layout = $this->layout;

        // $controller->render('//public/jumpTo',array('url'=>$url,'msg'=>$msg,'secs'=>$secs));
        return $controller->render($this->getJumperBasePath() . '/jumpToDialog', array('url' => $url, 'msg' => $msg, 'secs' => $secs));
    }

    public function jumpBack($msg = '', $tipBoxStyle = 'message', $secs = 5, $step = 1)
    {
        $controller = Yii::$app->controller;
        //$controller->layout = $this->layout;
        // $this->render('//public/jumpBack',array('msg'=>$msg,'secs'=>$secs));
        return $controller->render($this->getJumperBasePath() . '/jumpBack', [
                'msg' => $msg,
                'secs' => $secs,
                'step' => $step,
                'tipBoxStyle' => $tipBoxStyle,
                'tipBoxIcon' => static::getTipBoxIcon($tipBoxStyle),
            ]
        );
    }

    public function jumpBackDialog($msg = '', $secs = 5, $step = 1)
    {
        $controller = Yii::$app->controller;
        //$controller->layout = $this->layout;
        // $this->render('//public/jumpBack',array('msg'=>$msg,'secs'=>$secs));
        return $controller->render($this->getJumperBasePath() . '/jumpBackDialog', array('msg' => $msg, 'secs' => $secs, 'step' => $step));
    }
} 