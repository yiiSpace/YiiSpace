<?php

Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
// another two apps
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api'); // add api alias
Yii::setAlias('installer', dirname(dirname(__DIR__)) . '/installer'); // add installer alias

Yii::setAlias('my', dirname(dirname(__DIR__)) . '/my');
Yii::setAlias('year', dirname(dirname(__DIR__)) . '/year');



// apache thrift lib
// Yii::setAlias('Thrift', dirname(dirname(__DIR__)) . '/common/lib/Thrift');
