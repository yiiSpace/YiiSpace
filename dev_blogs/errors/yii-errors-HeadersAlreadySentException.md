
yii\web\HeadersAlreadySentException
----

https://stackoverflow.com/questions/49689315/an-error-occurred-while-handling-another-error-yii-web-headersalreadysentexcep

You may also call exit at the end of your method to prevent further processing or wrap your code with ob_start() and ob_get_clean(), if you're not able to avoid echo.

Since Yii 2.0.14 you cannot echo in a controller. A response must be returned:

~~~php

public function actionAdd_comment() {
    $model = new \app\models\Comments();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        $this->someMagicWithEcho();
        exit;
    }
}

or

public function actionAdd_comment() {
    $model = new \app\models\Comments();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        ob_start();
        $this->someMagicWithEcho();
        return ob_get_clean();
    }
}

~~~

 I have encountered a situation where there was no echo in the controller, but I also got the error. After going through several sites looking for a solution, I discovered an alternative.

You can check the php.ini file and ensure the output buffer is enabled. If not, you can enable it by adding this line in php.ini if it does not exist:

output_buffering = on

And turn it off for just the script - the script where it is not required by either...

    calling ob_end_flush(), or
    calling ob_end_clean()
