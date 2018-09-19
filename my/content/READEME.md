## 命令程序中 各个命令可以互相调用：

~~~cmd

    \Yii::$app->runAction('migrate/up', [
            'interactive' => $this->interactive,
            'migrationPath'=>'@my/blog/migrations',
        ]);

~~~

！启示  
Yii 中类库都有公共方法 在阅读源码时  考虑可能的调用者 及使用场景 


## 参考设计

dolphin

~~~sql

CREATE TABLE `bx_photos_main` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Categories` text NOT NULL,
  `Owner` int(10) unsigned DEFAULT NULL,
  `Ext` varchar(4) DEFAULT '',
  `Size` varchar(10) DEFAULT '',
  `Title` varchar(255) DEFAULT '',
  `Uri` varchar(255) NOT NULL DEFAULT '',
  `Desc` text NOT NULL,
  `Tags` varchar(255) NOT NULL DEFAULT '',
  `Date` int(11) NOT NULL DEFAULT '0',
  `Views` int(11) DEFAULT '0',
  `Rate` float NOT NULL DEFAULT '0',
  `RateCount` int(11) NOT NULL DEFAULT '0',
  `CommentsCount` int(11) NOT NULL DEFAULT '0',
  `Featured` tinyint(4) NOT NULL DEFAULT '0',
  `Status` enum('approved','disapproved','pending') NOT NULL DEFAULT 'pending',
  `Hash` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Hash` (`Hash`),
  KEY `Owner` (`Owner`),
  KEY `Uri` (`Uri`),
  KEY `Date` (`Date`),
  FULLTEXT KEY `ftMain` (`Title`,`Tags`,`Desc`,`Categories`),
  FULLTEXT KEY `ftTags` (`Tags`),
  FULLTEXT KEY `ftCategories` (`Categories`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
~~~