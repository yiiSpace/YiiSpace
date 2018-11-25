## 迁移命令

~~~cmd
 
 yii migrate/create create_table_content_album  --migrationPath=@my/content/migrations
 
 yii migrate/up  --migrationPath=@my/content/migrations


yii migrate/create create_table_content_photo  --migrationPath=@my/content/migrations

yii migrate/create create_table_article  --migrationPath=@my/content/migrations

yii migrate/create create_table_article_category  --migrationPath=@my/content/migrations

yii migrate --migrationPath="@vendor/romi45/yii2-seo-behavior/migrations"
~~~