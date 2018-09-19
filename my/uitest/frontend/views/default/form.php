<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/4/6
 * Time: 23:15
 */
?>

<script>

    function formPost(url, params, target) {
        // 如果未指定提交窗体 那么提交到新开的tab窗体中去
        if (undefined == target) {
            target = '_blank';
        }
        var opts = {
            id: 'vForm',
            //  name:'_helper_form',
            action: url,
            method: 'post',
            target: '_blank',
            style: 'display:none'
        };
        // var inpQ =  $('#inpQ').clone();
        var $newForm = $('<form/>', opts);
        /*
         if (params !== undefined && (typeof params == 'object')) {
         }else{
         params = {} ;
         }
         */
        params = params || {};
        // 推入csrf令牌 不然yii的post提交不会通过的！
        var csrfParam = $('meta[name=csrf-param]').prop('content');
        var csrfToken = $('meta[name=csrf-token]').prop('content');
        params[csrfParam] = csrfToken;

        for (k in params) {
            var $paramInput = $('<input>',
                {
                    name: k,
                    type: 'hidden',
                    value: params[k]
                });
            $newForm.append($paramInput);
        }
        $('body').append($newForm);
        $newForm.trigger('submit');
        $newForm.remove();
    }
    ;


</script>

<a href="<?= \yii\helpers\Url::to() ?>" onclick="formPost($(this).attr('href'),{p1:1,p2:2}); return false ;">提交</a>