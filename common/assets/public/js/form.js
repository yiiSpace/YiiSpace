/**
 * Created by yiqing on 2015/4/6.
 */


function formPost(url, params,target) {
    // 如果未指定提交窗体 那么提交到新开的tab窗体中去
    if(undefined == target){
        target = '_blank';
    }
    var opts = {
        id: 'vForm',
        action: url,
        method:'post',
        target: '_blank',
        style: 'display:none'
    };
    // var inpQ =  $('#inpQ').clone();
    var $newForm = $('<form/>', opts);
    if (params !== undefined && (typeof params == 'object')) {
        for (k in params) {
            var $paramInput = $('<input>',
                {
                    name: k,
                    type: 'hidden',
                    value: params[k]
                });
            $newForm.append($paramInput);
        }
    }
    $('body').append($newForm);
    $newForm.trigger('submit');
    $newForm.remove();
}
// jquery工具类 判断变量是否为空！
jQuery.isBlank = function (obj) {
    if (!obj || jQuery.trim(obj) === "") return true;
    if (obj.length && obj.length > 0) return false;

    for (var prop in obj) return false;
    return true;
};
/**
 * 提交对象到指定url
 *
 * @param uri
 * @param obj
 * @constructor
 */
function PostObjectToUri(uri, obj) {
    "use strict";

    var json, form, input;

    json = JSON.stringify(obj);

    form = document.createElement("form");
    form.method = "post";
    form.action = uri;
    input = document.createElement("input");
    input.setAttribute("name", "json");
    input.setAttribute("value", json);
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
};