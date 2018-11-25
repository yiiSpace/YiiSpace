<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/11/25
 * Time: 9:27
 */

namespace year\queue;


use yii\base\BaseObject;

/**
 *
 * ------------------------------------------------------------------------------------------------------------------ +|
 * TODO 要足够动态化 如果需要从命令行也可以传递params参数 那么可以参考yii\console\Request 类如何解析参数的！
 *
 * 此函数一般可以用在程序中  用来程序化推入一些命令 到队列中 等待执行！ 如果想提供cmd 接口 允许用户从命令行推入命令 主要
 * 难点在params 和options
 *
 * Yii执行控制台动作的语法是：
 * > yii <route> [--option1=value1 --option2=value2 ... argument1 argument2 ...]
 * 我们假设需要这样在cmd推入命令：
 * > yii  queue/push-cmd  cmd ' --option1=value1 --option2=value2 ... argument1 argument2 ... '
 * 也就是找了一个中转的代理 然后在代理中用： \Yii::$app->runAction('controller/test', ['option' => 'value', $a, $b]);
 * 问题在于 如何把 命令行的参数解析为 runAction的 第二个参数形式！
 * ------------------------------------------------------------------------------------------------------------------ +|
 * Class CommandJob
 * @package year\queue
 */
class CommandJob extends BaseObject implements \yii\queue\JobInterface
{
    /**
     * @var string
     */
    public $cmd;
    /**
     * @var array
     */
    public $params = [];

    /**
     * @param Queue $queue which pushed and is handling the job
     */
    public function execute($queue)
    {
        // echo $this->cmd ;
        $app = \Yii::$app;
        $temp = clone $app;
        $temp->runAction($this->cmd, $this->params);
        unset($temp);
        \Yii::$app = $app;
        \Yii::$app->log->logger->flush(true);
    }
}