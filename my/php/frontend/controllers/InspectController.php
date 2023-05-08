<?php

namespace my\php\frontend\controllers;

use yii\web\Controller;

class InspectController extends Controller
{
    public function actionIndex()
    {
// @see

        $constants = get_defined_constants();


        $functions = get_defined_functions();


        $extensions = get_loaded_extensions();

        $module_name = 'pdo';
        $funcs_of_module = get_extension_funcs($module_name);


        $classes = get_declared_classes();

        $vas = get_defined_vars();
        dump($vas);
        die(0);
    }

    public function actionReflection()
    {

    }
}