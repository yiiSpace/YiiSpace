<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/22
 * Time: 13:53
 */

namespace year\payment;

/**
 * @see http://qi138138lin.blog.163.com/blog/static/1858853072012784544752/
 * @see http://www.haoyangshi.com/blog/57.html
 *
 * 上面的类文件，通过实例化后，然后将参数发送给建行url，之后建行处理发送的参数，等建行处理支付以后，会返回一个向本站发送一个消息，
 * 告诉你是成功还是失败，这个url地址在建行商户后台自己设置，下面介绍一下建行处理完后，验签过程，由于验签是用java实现的，
 * 所以这部分需要使用jsp，jsp代码respond.jsp如下:

   respond.jsp文件成功或者失败都会跳到respond.php文件进行处理，如果成功php这边可以修改用户订单状态信息，
 * 失败告诉用户支付问题，并记录日志，帮助以后查看，如果有问题可以加好样式交流群109966408。
 *
 *
 * Class CCB
 * @package year\payment
 */
class CCB{
    private  $pubstr = '';            //建行提供的密钥，需要登陆建行商户后台下载
    static   $MERCHANTID = '';        //商户代码
    private  $POSID  = '';            //商户柜台代码
    private  $BRANCHID  = '';         //银行分行代码
    private  $ORDERID = '';           //订单编号
    private  $PAYMENT = '';           //订单金额

    private  $CURCODE = '';           //币种
    private  $TXCODE = '';            //交易码
    private  $REMARK1 = '';           //备注1
    private  $REMARK2 = '';           //备注2

    private  $TYPE = '';              //接口类型
    private  $GATEWAY = '';           //网关类型
    private  $CLIENTIP = '';          //客户端ip地址

    private  $PUB32TR2 = '';          //公钥后30位
    private  $bankURL = '';           //提交url
    private  $REGINFO = '';           //注册信息
    private  $PROINFO = '';           //商品信息
    private $REFERER = '';            //商户域名

    private  $URL = '';
    private  $tmp = '';
    private  $temp_New = '';
    private  $temp_New1 = '';
    /**
     * 构造函数  封装参数
     * @return  void
     */
    public function __construct($order_sn,$payment)
    {
        $this->MERCHANTID = '';
        $this->POSID = '';
        $this->BRANCHID = '';

        $this->ORDERID = $order_sn;
        $this->PAYMENT = $payment;
        $this->CURCODE = '01';

        $this->TXCODE = '';
        $this->REMARK1 = '';
        $this->REMARK2 = $order_sn;

        $this->bankURL = 'https://ibsbjstar.ccb.com.cn/app/ccbMain';
        $this->TYPE = 1;
        $this->PUB32TR2 = substr($this->pubstr, -30);

        $this->GATEWAY = '';
        $this->CLIENTIP = real_ip();   //可以自己写个方法，我这里自己调用系统里
        $this->REGINFO = '';

        $this->PROINFO = '';
        $this->REFERER = '';
    }

    /*获取参数值*/
    public function getVar($name){
        return $this->$name;
    }

    /**
     * 生成url，文档用js，此url用于跳转到建行支付页
     * @access  public
     * @return  url
     */
    public  function getUrl()
    {
        $this->tmp .='MERCHANTID='.$this->MERCHANTID.'&POSID='.$this->POSID.'&BRANCHID='.$this->BRANCHID.'&ORDERID='.$this->ORDERID.'&PAYMENT='.$this->PAYMENT.'&CURCODE='.$this->CURCODE.'&TXCODE='.$this->TXCODE.'&REMARK1='.$this->REMARK1.'&REMARK2='.$this->REMARK2;
        $this->temp_New .=$this->tmp."&TYPE=".$this->TYPE."&PUB=".$this->PUB32TR2."&GATEWAY=".$this->GATEWAY."&CLIENTIP=".$this->CLIENTIP."®INFO=".$this->REGINFO."&PROINFO=".$this->PROINFO."&REFERER=".$this->REFERER;
        $this->temp_New1 .=$this->tmp."&TYPE=".$this->TYPE."&GATEWAY=".$this->GATEWAY."&CLIENTIP=".$this->CLIENTIP."®INFO=".$this->REGINFO."&PROINFO=".$this->PROINFO."&REFERER=".$this->REFERER;

        $strMD5 = md5($this->temp_New);
        $this->URL .= $this->bankURL."?".$this->temp_New1."&MAC=".$strMD5;
        return $this->URL;
    }

    /*记录支付日志信息*/
    public function writeLog($order){

        $fp = fopen('/'.$order['order_sn'].'.txt' , 'a');
        if(flock($fp, LOCK_EX)){
            fwrite($fp, "提交到建行支付页面时间：\r");
            fwrite($fp,  local_date('Y-m-d H:i:s'));
            fwrite($fp,"\n");
            fwrite($fp, "传递url参数信息：\n");
            fwrite($fp, $this->getUrl());
            fwrite($fp, "\n记录支付前数据信息:\n");
            fwrite($fp, "订单号：".$order['order_sn']."\r订单金额：".$order['order_amount']);
            fwrite($fp, "\r\n\n\n");
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }

}
?>

