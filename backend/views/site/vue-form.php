
<?php

use common\widgets\VueAsset;
use year\widgets\CssBlock;
use year\widgets\JsBlock;

VueAsset::register($this);
?>


<?=__FILE__?>

<div id="app" class="vue-msg">

<input type="text" v-model="message">
<p>
  {{message}}
</p>
lazy
<input type="text" v-model.lazy="message">

<input type="checkbox" id="check_box" v-model="checked" v-bind:value="checked">
<label for="check_box">{{checked}}</label>
<br>

<input type="checkbox" id="a" v-model="checkedNames" value="坑" >
<label for="a">坑</label>
<input type="checkbox" id="b" v-model="checkedNames" value="蒙">
<label for="b">蒙</label>
<input type="checkbox" id="c" v-model="checkedNames" value="拐">
<label for="c">拐</label>
<div> {{checkedNames}} </div>

<br>
<input type="radio" id="one" value="1" v-model="gender">
<label for="one">男</label>
<input type="radio" id="one" value="0" v-model="gender">
<label for="one">女</label>

<br>
<h3>这个例子好像绑定有问题</h3>
 <select  v-model="selected">
  <option value="">北京</option>
  <option value="">上海</option>
  <option value="">广州</option>
  <option value="">深圳</option>
 </select>
 <div>
  {{selected}}
 </div>

<div>
  <h3>类型会变哦😯</h3>
  <input type="number" v-model="count" >
  {{typeof count}}
  <input type="number" v-model.number="count" >
</div>

<div>
  <h3>去除输入的空格</h3>
  <span>{{message}}</span><br>
  <input type="text" v-model ="message" >
  后面这个输入空格不影响
  <input type="text" v-model.trim ="message" >
</div>

</div>

<?php JsBlock::begin()?>
<script>
  const { createApp } = Vue

  const vm = createApp({
    data() {
      return {
        count: 0,
        message: 'Hello Vue!',

        checked: true,
        checkedNames: []
        , gender: 1
        , selected: ''
      }
    },
    methods:{
      handleClick(){
        this.count++
      }
      , addCount(event){
        console.log(event)
        this.count++
      }

    },
    computed:{


    }

  }).mount('#app')

  console.log(vm) // TODO 了解下Proxy

 
  

</script>
<?php JsBlock::end()?>

<?php CssBlock::begin()?>
<style>
.vue-msg {
  background-color:azure;
}
.green {
  color:greenyellow
}
.red {
  color:red
}
.big-font {
  font-size: 2rem
}
</style>
<?php CssBlock::end()?>