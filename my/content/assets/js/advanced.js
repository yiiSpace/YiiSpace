(function ($) {


    $.Redactor.prototype.iframe = function () {
        return {
            getTemplate: function () {
                return String()
                    + '<div id="redactor-modal-advanced">'
                   //  + '<label>Enter a text</label>'
                   // + '<textarea id="mymodal-textarea" rows="6"></textarea>'
                    + '</div>';
            },
            init: function () {
                var button = this.button.add('iframe', 'iframe');

                // make your added button as Font Awesome's icon
                // this.button.setAwesome('iframe', 'fa-tasks');
                this.button.changeIcon('iframe', 'image'); // 随便给个拉

                this.button.addCallback(button, this.iframe.testButton);
            },
            testButton: function (buttonName) {
                /*
                // alert(buttonName);
                var $modal = this.modal.getModal();

                var $iframe = $('<iframe>', {
                    src: this.opts.iframeUrl,
                    id: 'myFrame',
                    frameborder: 0,
                    scrolling: 'no'
                });
                // $iframe.attr('src',this.opts.iframeUrl) ;
                // .apppendTo($modal) ;
               //  $modal.append($iframe);
                this.modal.addTemplate('iframe',
                    this.iframe.getTemplate());
                this.modal.load('iframe', 'iframe Modal', 400);
                this.modal.show();
                */
                this.modal.addTemplate('iframe',
                    this.iframe.getTemplate());
                // this.modal.load('iframe', 'Advanced Modal', 400);
                this.modal.load('iframe', 'Advanced Modal',700);

                var $iframe = $('<iframe>', {
                    src: this.opts.iframeUrl,
                    id: 'myFrame',
                    width:'96%',
                    height:'100%',
                    frameborder: 0,
                    scrolling:  'yes' // 'no'
                });
                $iframe.appendTo('#redactor-modal-advanced');
                //  this.model.append($iframe) ;

               // this.modal.createCancelButton();
               // var button = this.modal.createActionButton('Insert');
               // this.selection.save();
                this.modal.show();
            }
        };
    };

})(jQuery);
