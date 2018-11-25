(function ($) {


    $.Redactor.prototype.advanced = function () {
        return {
            init: function () {
                var button = this.button.add('advanced', 'Advanced');

                // make your added button as Font Awesome's icon
                // this.button.setAwesome('advanced', 'fa-tasks');
                this.button.changeIcon('advanced','image'); // 随便给个拉

                this.button.addCallback(button, this.advanced.testButton);
            },
            testButton: function (buttonName) {
                alert(buttonName);
            }
        };
    };

})(jQuery);
