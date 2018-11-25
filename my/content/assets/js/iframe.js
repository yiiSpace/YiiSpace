(function ($) {

    var $iframe =  $('<iframe>', {
        // src: this.opts.iframeUrl ,
        id:  'myFrame',
        frameborder: 0,
        scrolling: 'no'
    });
    // --------------------------------------------------------------------------------------------------------  +|
    //  can delete this blocks just for testing
    var iFrames = $iframe ;
    function resize() {
        for (var i = 0, j = iFrames.length; i < j; i++) {
            var nHeight = iFrames[i].contentWindow.document.body.offsetHeight;
            iFrames[i].style.height = nHeight + 'px';
        }
    }
    if ($.browser.safari || $.browser.opera) {
        iFrames.load(function() {
            setTimeout(resize, 0);
        });
        for (var i = 0, j = iFrames.length; i < j; i++) {
            var iSource = iFrames[i].src;
            iFrames[i].src = '';
            iFrames[i].src = iSource;
        }

    } else {
        iFrames.load(function() {
            this.style.height = this.contentWindow.document.body.offsetHeight + 'px';
        });
    }
    // --------------------------------------------------------------------------------------------------------  +|
    $.Redactor.prototype.iframe = function () {
        return {
            translations: {
                en: {
                    "choose": "选择"
                }
            },
            init: function () {
                if (!this.opts.iframeUrl) return;

                // this.modal.addCallback('image', this.iframe.load);
               // this.modal.addCallback('video', this.iframe.load);
               //  var button = this.button.addAfter('image', 'video', this.lang.get('video'));
                var button = this.button.addAfter('image', 'iframe', 'iframe');
                this.button.addCallback(button, this.iframe.load);
                alert("yayayyay") ;
            },
            load: function () {
                var $modal = this.modal.getModal();

                $iframe.attr('src',this.opts.iframeUrl) ;
               // .apppendTo($modal) ;
                $modal.append($iframe);

            },
            insert: function (e) {
                this.image.insert('<img src="' + $(e.target).attr('rel') + '" alt="' + $(e.target).attr('title') + '" data-id="' + $(e.target).data('id') + '">');
            }

        };
    };
})(jQuery);
