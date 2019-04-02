<?php

Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('storage', dirname(dirname(__DIR__)) . '/storage');
// another two apps
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api'); // add api alias
Yii::setAlias('installer', dirname(dirname(__DIR__)) . '/installer'); // add installer alias

Yii::setAlias('my', dirname(dirname(__DIR__)) . '/my');
Yii::setAlias('year', dirname(dirname(__DIR__)) . '/year');

Yii::setAlias('modules',   'D:\Visual-NMP-x64\www\459loveofficial\modules');



// apache thrift lib
// Yii::setAlias('Thrift', dirname(dirname(__DIR__)) . '/common/lib/Thrift');
