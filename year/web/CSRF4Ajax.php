<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/23
 * Time: 16:16
 */

namespace year\web;


use yii\base\Widget;
use yii\web\Request;

/**
 * @see http://beego.me/docs/mvc/controller/xsrf.md
 *
 * FIXME we should promise these code been executed before any post ajax execution!
 *
 * Class CSRF4Ajax
 * @package year\web
 */
class CSRF4Ajax extends Widget{

public function run()
{
    $this->extendAjax() ;
}

    /**
     * TODO we can inject the csrfToken params to the postParams
     */
    protected function extendAjax()
    {
        // $csrfHeaderName = Request::CSRF_HEADER ;
        $csrfHeaderName = 'HTTP_' . str_replace('-', '_', strtoupper(Request::CSRF_HEADER));

        $js = <<<JS
var origAjax = $.ajax;
$.extend({
    ajax: function(url, options) {
        if (typeof url === 'object') {
            options = url;
            url = undefined;
        }
        options = options || {};
        url = options.url;
        // var xsrftoken = $('meta[name=_xsrf]').attr('content');
        var csrfParma = $('meta[name=csrf-param]').attr('content');
        var csrfToken = $('meta[name=csrf-token]').attr('content');
        var headers = options.headers || {};
        var domain = document.domain.replace(/\./ig, '\\.');
        if (!/^(http:|https:).*/.test(url) || eval('/^(http:|https:)\\/\\/(.+\\.)*' + domain + '.*/').test(url)) {
            // headers = $.extend(headers, {'X-Xsrftoken':xsrftoken});
            headers = $.extend(headers, { $csrfHeaderName : csrfToken } );
        }
        options.headers = headers;
        return origAjax(url, options);
    }
});
JS;

        $this->view->registerJs($js);

    }

}