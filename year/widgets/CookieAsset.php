<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/2/13
 * Time: 15:42
 */

namespace year\widgets;


use yii\web\AssetBundle;
use yii\web\View;

class CookieAsset extends AssetBundle{
    public function init(){
        parent::init();
    }

    /**
     * Registers the CSS and JS files with the given view.
     * @param \yii\web\View $view the view that the asset files are to be registered with.
     */
    public function registerAssetFiles($view)
    {
       parent::registerAssetFiles($view);

        $cookieLib = <<<PLUGIN
//获得coolie 的值
function cookie(name){
   var cookieArray=document.cookie.split("; "); //得到分割的cookie名值对
   var cookie=new Object();
   for (var i=0;i<cookieArray.length;i++){
      var arr=cookieArray[i].split("=");       //将名和值分开
      if(arr[0]==name)return unescape(arr[1]); //如果是指定的cookie，则返回它的值
   }
   return "";
}

function delCookie(name)//删除cookie
{
   document.cookie = name+"=;expires="+(new Date(0)).toGMTString();
}

function getCookie(objName){//获取指定名称的cookie的值

    var arrStr = document.cookie.split("; ");

    for(var i = 0;i < arrStr.length;i ++){

        var temp = arrStr[i].split("=");

        if(temp[0] == objName) return unescape(temp[1]);
   }
}

function addCookie(objName,objValue,objHours){      //添加cookie
    var str = objName + "=" + escape(objValue);
    if(objHours > 0){                               //为时不设定过期时间，浏览器关闭时cookie自动消失
        var date = new Date();
        var ms = objHours*3600*1000;
        date.setTime(date.getTime() + ms);
        str += "; expires=" + date.toGMTString();
   }
   document.cookie = str;
}

function setCookie(name,value)//两个参数，一个是cookie的名子，一个是值

{
    var Days = 30; //此 cookie 将被保存 30 天
    var exp = new Date();    //new Date("December 31, 9998");
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}

function getCookie(name)//取cookies函数
{
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
     if(arr != null) return unescape(arr[2]); return null;
}

function delCookie(name)//删除cookie
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
PLUGIN;
        /***
         * 调用一下上面方法：
        查看复制打印?
        setCookie("test","tank",1800);         //设置cookie的值，生存时间半个小时
        alert(getCookie('test'));                     //取得cookie的值，显示tank
        clearCookie("test");                           //删除cookie的值
        alert(getCookie('test'));                     //test对应的cookie值为空，显示为false.就是getCookie最后返的false值。
         */
        $cookieLib = <<<JS
  //取得cookie
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');    //把cookie分割成组
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];                      //取得字符串
            while (c.charAt(0) == ' ') {          //判断一下字符串有没有前导空格
                c = c.substring(1, c.length);      //有的话，从第二位开始取
            }
            if (c.indexOf(nameEQ) == 0) {       //如果含有我们要的name
                return unescape(c.substring(nameEQ.length, c.length));    //解码并截取我们要值
            }
        }
        return false;
    }

    //清除cookie
    function clearCookie(name) {
        setCookie(name, "", -1);
    }

    //设置cookie
    function setCookie(name, value, seconds) {
        seconds = seconds || 0;   //seconds有值就直接赋值，没有为0，这个根php不一样。
        var expires = "";
        if (seconds != 0) {      //设置cookie生存时间
            var date = new Date();
            date.setTime(date.getTime() + (seconds * 1000));
            expires = "; expires=" + date.toGMTString();
        }
        document.cookie = name + "=" + escape(value) + expires + "; path=/";   //转码并赋值
    }

JS;

       $view->registerJs($cookieLib,View::POS_END);
    }

}