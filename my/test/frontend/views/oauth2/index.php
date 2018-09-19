<div class="test-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>

    <button onclick="getToken()">获取token</button>

    <?php \year\widgets\JsBlock::begin() ?>
    <script>
        function getToken()
        {
            //  var url = window.location.host + "/oauth2/token";
            var url = 'http://127.0.0.1:6666/YiiSpace/api/web/' + "/oauth2/token";
            var url = 'http://127.0.0.1:6666/YiiSpace/api/web/' + "/oauth2/rest/token";
            var data = {
                'grant_type':'password',
                'username':'yiqing2',
                'password':'yiqing',
                'client_id':'testclient',
                'client_secret':'testpass'
            };
                        //ajax POST `data` to `url` here
                        //
           $.post(url,data,function (resp) {
               alert(resp) ;
           });
        }
    </script>
    <?php \year\widgets\JsBlock::end() ?>

</div>
