<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/23
 * Time: 12:38
 */

namespace backend\gii\crud\easyui;


class Generator extends \yii\gii\generators\crud\Generator{

    public function getName()
    {
        return 'EasyUi CRUD';
    }

    public function getDescription()
    {
        return 'This generator generates an extended version of CRUDs.';
    }

    /**
     * Generates code for active field
     * @param string $attribute
     * @return string
     */
    public function generateActiveField($attribute)
    {
        $tableSchema = $this->getTableSchema();
        if ($tableSchema === false || !isset($tableSchema->columns[$attribute])) {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $attribute)) {
                return "\$form->field(\$model, '$attribute')->passwordInput()";
            } else {
                return "\$form->field(\$model, '$attribute')";
            }
        }
        $column = $tableSchema->columns[$attribute];
        if ($column->phpType === 'boolean') {
            return "\$form->field(\$model, '$attribute')->checkbox(['class'=>'easyui-checkbox'])";
        } elseif ($column->type === 'text') {
            return "\$form->field(\$model, '$attribute')->textarea(['rows' => 6])";
        } else {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                $input = 'passwordInput';
            } else {
                $input = 'textInput';
            }
            if (is_array($column->enumValues) && count($column->enumValues) > 0) {
                $dropDownOptions = [];
                foreach ($column->enumValues as $enumValue) {
                    $dropDownOptions[$enumValue] = Inflector::humanize($enumValue);
                }
                return "\$form->field(\$model, '$attribute')->dropDownList("
                . preg_replace("/\n\s*/", ' ', VarDumper::export($dropDownOptions)).", ['prompt' => ''])";
            } elseif ($column->phpType !== 'string' || $column->size === null) {
                return "\$form->field(\$model, '$attribute')->$input(['class'=>'easyui-textbox'])";
            } else {
                return "\$form->field(\$model, '$attribute')->$input(['maxlength' => $column->size])";
            }
        }
    }

    /**
     * Generates code for active search field
     * @param string $attribute
     * @return string
     */
    public function generateActiveSearchField($attribute)
    {
        $tableSchema = $this->getTableSchema();
        if ($tableSchema === false) {
            // return "\$form->field(\$model, '$attribute',['inputOptions'=>'form-control easyui-textbox '])";
            return "\$form->field(\$model, '$attribute',['inputOptions'=>[ 'class' => 'form-control easyui-textbox ']])";
        }
        $column = $tableSchema->columns[$attribute];
        if ($column->phpType === 'boolean') {
            return "\$form->field(\$model, '$attribute')->checkbox()";
        } else {
            // return "\$form->field(\$model, '$attribute',['inputOptions'=>'form-control easyui-textbox '])";
            return "\$form->field(\$model, '$attribute',['inputOptions'=>[ 'class' => 'form-control easyui-textbox ']])";
        }
    }
}