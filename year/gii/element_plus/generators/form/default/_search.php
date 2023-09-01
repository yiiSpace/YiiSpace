<?php

/**
 * This is the template for generating the search form of a specified table.
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var \year\gii\element_plus\generators\form\Generator $generator
 * @var string $tableName full table name
 */

// FIXME: 关于表单默认值的问题 可以通过字段类型取到其默认值：https://github.com/php-toolkit/stdlib/blob/master/src/Type.php#L94
// 也可以用ActiveRecord 取到默认值：https://www.yiiframework.com/doc/guide/2.0/en/db-active-record#default-attribute-values

// TODO： 对TS 的支持
// todo: php 类型转换为typescript类型： spatie/typescript-transformer ｜https://typeschema.org/｜https://hybridly.dev/guide/typescript.html
// 万一用php库搞不定 还可以使用进程间通信 或者webdriver等手段通过无头浏览器让特定网站来完成转换

$genProp = function ($propName, $propType) {
  $propName = '$' . $propName;
  $propCode = <<<Code
  /**
   * @var $propType
   */
  public {$propName};
  Code;
  return  $propCode;
};
/*
print_r([
  'rules'=>$rules,
]) ;
*/
?>
<template>
  <!-- /** generate for table:  <?= $generator->tableName ?> | class: <?= $className ?> */ -->

  <el-form ref="ruleFormRef" :model="ruleForm" :rules="rules" label-width="120px" class="demo-ruleForm" :size="formSize" status-icon>
   <?php 
    $propsCode = [] ;
    $count = 0 ;
    foreach ($properties as $property => $data) : ?>
          <?php if($count<6):?>
        <el-form-item label="<?= $labels[$property] ?>" prop="<?= $property ?>">
        <?= $generator->generateSearchFormItemField($tableName, $property) ?>
        </el-form-item>

    <?php else: ?>
        <?php if($count == 6): ?>
        <?php endif;?>
        <el-form-item label="<?= $labels[$property] ?>" prop="<?= $property ?>" v-show="isShow">
        <?= $generator->generateSearchFormItemField($tableName, $property) ?>
        </el-form-item>
    <?php endif;?>

    <?php
         // print_r($data, false);
        $propsCode[] = $genProp($data['name'],$data['type']);
        ?>
    <?php $count++; endforeach; ?>

    <el-form-item>
        <el-button
                class="arrow"
                :icon="isShow ? ArrowUp : ArrowDown"
                @click="isShow = !isShow" >
        </el-button>  
      <el-button type="primary" @click="submitForm(ruleFormRef)">Create</el-button>
      <el-button @click="resetForm(ruleFormRef)">Reset</el-button>
    </el-form-item>
  </el-form>
</template>
<!-- <script lang="ts" setup> -->
<?php
$classCode = "
<?php
/**
* @TypeScriptMe
*/
class $className
{\r\n " . implode("\r\n",$propsCode)."\r\n}";

// echo $classCode ;
// \year\gii\common\utils\TsParser::run($classCode);
?>
<script setup>
import {reactive,ref} from 'vue'
// import type { FormInstance, FormRules } from 'element-plus'

// 引入图标
import { ArrowUp,ArrowDown } from '@element-plus/icons-vue'

/*
import {  getCurrentInstance} from 'vue'
const {ctx} = getCurrentInstance() // 这个里面有不少东西可以很方便的使用的😄
console.log('[crud-form]:', ctx)
*/
  /*
  interface RuleForm {
    name: string
   ...
  }
  <?php \year\gii\common\utils\TsParser::run($classCode); ?>
  */
    <?php 
     // print_r($defaults,  true) ;  json_encode($defaults); 
      \yii\helpers\Json::$prettyPrint = true;
      // echo \yii\helpers\Json::encode($defaults) 
      // var datac = JSON.parse(data);
      ?>
  const isShow = ref(false);

  const formSize = ref('default')
  // const ruleFormRef = ref<FormInstance>()
  const ruleFormRef = ref()
  // const ruleForm = reactive<RuleForm>({
  const ruleForm = reactive(
    <?= \yii\helpers\Json::encode($defaults) ?>
  )
  // const rules = reactive<FormRules<RuleForm>>({
  const rules = reactive(
    <?= \yii\helpers\Json::encode($rules) ?>
  )
  // const submitForm = async (formEl: FormInstance | undefined) => {
  const submitForm = async (formEl) => {
    if (!formEl) return
    await formEl.validate((valid, fields) => {
      if (valid) {
        console.log('submit!')
        alert('TODO: should call some api to accomplish the creation')
      } else {
        console.log('error submit!', fields)
      }
    })
  }
  // const resetForm = (formEl: FormInstance | undefined) => {
  const resetForm = (formEl) => {
    if (!formEl) return
    formEl.resetFields()
  }
</script>
<style >
.demo-ruleForm .el-input {
  --el-input-width: 220px;
}
.demo-ruleForm_ok {
    /* display:flex;    */
    /* or  display：inline—flex;
(区别跟block和inline-block区别一样)，让一个元素变为flex容器*/

    display: grid;
    /* grid-template-columns: 1fr 1fr 1fr; */
    /* grid-template-columns: repeat(3, 33.33%); */


    grid-template-columns: 1fr 1fr minmax(100px, 1fr);
    grid-gap: 10px;
    /*这里下面介绍*/
    /* grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); */
    /* // grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); */

    justify-items: end;
    /* align-items: start; */
}
/**
TODO: 要处理 label过长的问题 会撑爆布局
word-break:break-all
试试 或者超出部分用...?
*/

/* 

始终在右下角位置
grid 和 flex都可以做到！

@see https://blog.csdn.net/ZHENGCHUNJUN/article/details/116756998

父盒子加了display: flex，就相当于起到浮动的效果，盒子会自行排列成一排；
若想让父盒子里的某一个盒子靠右显示，其他盒子居左， 只需要在父盒子里面，
加入display: flex，在想要移动的盒子里面，加入margin-left: auto即可；
同理，如果你想让第一个盒子向左显示，其余盒子都向右显示，只需要给左边的第一个盒子设置 margin-right:auto即可；
*/
.btns {
    /* grid-column-start: 3;
    grid-column-end: 4; */

    /* grid-column: 2/4; */
    grid-column: 2/span 2;

    justify-self: end;
    /* 
    justify-self: start | end | center | stretch;
    align-self: start | end | center | stretch;
    
    */

    /** ---- for grid-layout end------ */

    /** ---- for flex begin------ */
    /* align-self: flex-end; */
    /* margin-right: auto; */
    margin-left: auto;
    /* text-align:right; */
    /* margin-right: 10px; */
}
.demo-ruleForm2 {
    display: flex;
    /* or  display：inline—flex;
(区别跟block和inline-block区别一样)，让一个元素变为flex容器*/
    flex-wrap: wrap;
    /* justify-content: flex-start; */
    /* justify-content: stretch; */
    justify-content: space-between;
    /* justify-content: flex-end; */
    /* align-items: end; */
}
</style>