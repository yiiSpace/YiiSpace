assets 目录 文件摆放 参考yii2官方扩展： yii-gii yii-debug

XxxAsset 类处于模块根目录下 
资源文件assets 也在根目录下
前者引用后者的资源路径

但yii其他扩展中也有把XxxAsset类放在assets目录 或者其项目的widgets里面跟小挂件放在一起！

本项目是从yii2高级模版来的 默认就放在这 

但如果想添加额外的资源 需要考虑存放路径名称 这里用dist 或者vendor public 感觉都可以