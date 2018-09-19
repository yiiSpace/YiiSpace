(function ($) {
    $.fn.formDialog=function(options){

        return this.each(function(){
            var link=$(this);

            alert("yy");
                $.ajax({
                    'url': link.attr('href'),
                    'dataType': 'json',
                    'success': function(data){
                        alert('hahah'+data.form);
                        var dialog=$('<div style="display:none;"><div class="forView"></div></div>');
                        $('body').append(dialog);
                        if(options["dialogOptions"]){
                            dialog.dialog(options["dialogOptions"]);
                        }else{
                            dialog.dialog();
                        }

                        dialog.find('.forView').html(data.view || data.form);

                        dialog.delegate('form', 'submit', function(e){
                            e.preventDefault();
                            $.ajax({
                                'url': link.attr('href'),
                                'type': 'post',
                                'data': $(this).serialize(),
                                'dataType': 'json',
                                'success': function(data){
                                    if (data.status=='failure')
                                        dialog.find('.forView').html(data.view || data.form);
                                    else if (data.status=='success'){
                                        dialog.dialog('close').detach();
                                        options['onSuccess'](data, e);
                                    }
                                }
                            });

                        });
                    }
                    ,'error':function (XMLHttpRequest, textStatus, errorThrown) {
                        // 通常 textStatus 和 errorThrown 之中
                        // 只有一个会包含信息
                        // this; // 调用本次AJAX请求时传递的options参数
                    }

                });

        });
         alert("yeee");
    }
})(jQuery);	
