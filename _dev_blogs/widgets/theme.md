自  [rmrevin/yii2-comments](https://github.com/rmrevin/yii2-comments/blob/master/widgets/CommentListWidget.php) 
>
    /**
     * Class CommentListWidget
     * @package rmrevin\yii\module\Comments\widgets
     */
    class CommentListWidget extends \yii\base\Widget
    {
        /** @var string|null */
        public $theme;
        /** @var string */
        public $viewFile = 'comment-list';
        /** @var array */
        public $viewParams = [];
        /** @var array */
        public $options = ['class' => 'comments-widget'];
        /** @var string */
        public $entity;
        /** @var string */
        public $anchorAfterUpdate = '#comment-%d';
        /** @var array */
        public $pagination = [
            'pageParam' => 'page',
            'pageSizeParam' => 'per-page',
            'pageSize' => 20,
            'pageSizeLimit' => [1, 50],
        ];
        ...
        /**
         * @inheritdoc
         */
        public function getViewPath()
        {
            return empty($this->theme)
                ? parent::getViewPath()
                : (\Yii::$app->getViewPath() . DIRECTORY_SEPARATOR . $this->theme);
        }
    }