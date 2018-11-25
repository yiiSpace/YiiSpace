(function ($) {
    $.Redactor.prototype.imagemanager = function () {
        return {
            translations: {
                en: {
                    "choose": "选择"
                }
            },
            init: function () {
                if (!this.opts.imageManagerJson) return;

                this.modal.addCallback('image', this.imagemanager.load);
            },
            load: function () {
                var $modal = this.modal.getModal();

                this.modal.createTabber($modal);
                this.modal.addTab(1, this.lang.get('upload'), 'active');
                this.modal.addTab(2, this.lang.get('choose'));


                $('#redactor-modal-image-droparea').addClass('redactor-tab redactor-tab1');

                $('#redactor-modal-image-droparea').prepend('<p>选择一个相册？</p>');


                var $box2 = $('<div id="redactor-image-manager-box" style="overflow: auto; height: 300px;" class="redactor-tab redactor-tab2">').hide();

                var self = this;
                $box2.html("加载中... 稍等");
                $box2.load(this.opts.imageManagerUrl   , function(response,status,xhr) {
                    // alert("Load was performed.");
                    // TODO  执行回调 可以暴露出去？
                    // $('img',$box2).click($.proxy(self.imagemanager.insert, self));
                    // NOTE 需要延迟特性 防止分页后就不管用了
                    $($box2).on( 'click','img', $.proxy(self.imagemanager.insert, self));
                });
                $modal.append($box2);

            },
            insert: function (e) {
                // this.image.insert('<img src="' + $(e.target).attr('rel') + '" alt="' + $(e.target).attr('title') + '" data-id="' + $(e.target).data('id') + '">');
                this.image.insert('<img src="' + $(e.target).attr('src') + '" alt="' + $(e.target).attr('alt') + '" >');
            },
        };
    };
})(jQuery);
