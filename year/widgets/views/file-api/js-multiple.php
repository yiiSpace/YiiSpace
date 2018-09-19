<?php \year\widgets\JsBlock::begin() ?>
<script>
    var YiiFileApi = (function () {
        /**
         * 获取yii的csrf参数名跟令牌
         *
         * @type {{getParam: Function, getToken: Function}}
         */
        var yiiCsrf = {
            getParam: function () {
                return $('meta[name="csrf-param"]').prop('content');
            }
            , getToken: function () {
                return $('meta[name="csrf-token"]').prop('content');
            }
        };

        /**
         * @param options    config object
         *    {
       *        ele : '' , // element to listen
       *        sessionName : '' ,
       *        sessionId : '' ,
       *        onPreview : '',
       *
       *        postFileName : '',
       *        postData : '',  // post data when upload the image together to the server end
       *        onComplete : '' , // when the upload completed ,this callback function will be called !
       *    }
         *
         * */
        function YiiFileApi(options) {

            // var choose = document.getElementById('choose');
            this.ele = options['ele'];

            // var sessionName = '<?= \app\helpers\Web::getSessionNameIdPair()[0] ?>';
            // var sessionId = '<?= \app\helpers\Web::getSessionNameIdPair()[1] ?>';
            this.sessionName = options['sessionName'];
            this.sessionId = options['sessionId'];

            var sessionName = options['sessionName'];
            var sessionId = options['sessionId'];
            var onPreview = options['onPreview'] || function (err, img) {
                };

            //  文件上传字段的名称
            var postFileName = options['postFileName'] || 'images';

            FileAPI.event.on(this.ele, 'change', function (evt) {
                var files = FileAPI.getFiles(evt); // Retrieve file list

                FileAPI.filterFiles(files, function (file, info/**Object*/) {
                    /*
                     if( /^image/.test(file.type) ){
                     return  info.width >= 320 && info.height >= 240;
                     }
                     return  false;
                     */
                    return true;

                }, function (files/**Array*/, rejected/**Array*/) {
                    if (files.length) {
                        // Make preview 100x100
                        FileAPI.each(files, function (file) {
                            FileAPI.Image(file).preview(100).get(function (err, img) {
                                // images.appendChild(img);
                                // 预览回调
                                onPreview.call(this, err, img);
                            });

                        });

                        var csrfParam = yiiCsrf.getParam();
                        var csrfToken = yiiCsrf.getToken();

                        var postData = {};
                        if (options['postData']) {
                            // 允许是个方法 这样可以动态计算
                            if ($.isFunction(options['postData'])) {
                                postData = options['postData'].call(null);
                            } else {
                                postData = options['postData'];
                            }
                        }

                        // 推入csrf验证信息 和session信息
                        postData[csrfParam] = csrfToken;
                        postData[sessionName] = sessionId;

                        // 处理上传的url
                        var url = options['url'];

                        var onComplete = options['onComplete']
                            || function (err, xhr) {
                                /* ... */
                                if (!err) {
                                    var result = xhr.responseText;
                                    // ...
                                    console.log(result);
                                }
                            };


                        var uploadOptions = {
                            url: url,
                            // files: { images: files },
                            files: {},
                            data: postData,
                            progress: function (evt) { /* ... */
                            },
                            complete: onComplete
                        };


                        // Uploading Files
                        // FileAPI.upload(uploadOptions);
                        FileAPI.each(files, function (file) {
                            // 文件字段
                            uploadOptions['files'][postFileName] = file;

                            // Uploading Files
                            FileAPI.upload(uploadOptions);
                        });
                    }
                });
            });

        }

        return YiiFileApi;
    })();

</script>
<?php \year\widgets\JsBlock::end() ?>