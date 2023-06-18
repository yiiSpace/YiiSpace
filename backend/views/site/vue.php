
<?php

use common\widgets\VueAsset;
use year\widgets\CssBlock;
use year\widgets\JsBlock;

VueAsset::register($this);
?>


<?=  __FILE__ ?>

<div id="app" class="vue-msg">
  {{ message }} : count {{ count + 1}}

  <div>
    {{ rawContent }}
  </div>
  <div >
    <span v-html="rawContent"></span>
  </div>
  <div v-bind:class="eleClass">
    HTML属性 模版插值
  </div>

  <div>
    <h3>
      简单js表达式
    </h3>
    {{count+3}} <br>
    {{true? "true" : "false"}} <br>

    {{"yiispace@qq.com".split('@')}}

  </div>
  <div>
    <h3>指令</h3>
    <div v-if="visible"> 可见性</div>
    <div v-once> {{ onceValue }}</div>
    <div >
      带参数：
      <a v-bind:href="toUrl">跳转</a>
    
    </div>
    <div>
      动态属性绑定
      <a v-bind:[attrname]="toUrl">跳转</a>
      <a :[attrname]="toUrl">简写 跳转</a>
    </div>

      <div>
        <h3>on 绑定</h3>
        <button v-on:click="handleClick">点我</button>
        <button @click="alert('hi')">点我(简写)</button>
        <button @[event]="count++">点我(简写) {{count}}</button>
      </div>

      <div>
        <h3>计算属性</h3>
        <div>
          先用方法 {{userInfo()}}
        </div>
        <div>
          <h4>多次调用计算属性 会使用缓存机制</h4>
          再用计算属性 {{userInfo2}} <br>
          再用计算属性 {{userInfo2}} <br>
          再用计算属性 {{userInfo2}}
        </div>
      </div>

  </div>
  <div>
    <h3>
      getter && setter
    </h3>
    <div>
      全名：{{fullName}}
    </div>
  </div>

    <div>
      <h3>样式绑定</h3>
      <div v-bind:class='eleClass'>常规绑定</div>
      <div v-bind:class="{[eleClass]: enableClass, 'big-font':enableClass }">条件式 常规绑定
        根据enableClass 的值动态决定是否采用某些css样式类

      </div>
      <div v-bind:class="classObj">条件式 常规绑定
        根据enableClass 的值动态决定是否采用某些css样式类

      </div>
    </div>

</div>

<?php JsBlock::begin() ?>
<script>
  const { createApp } = Vue
  
  const vm = createApp({
    data() {
      return {
        count: 0,
        message: 'Hello Vue!',
        rawContent: '<span style="color:blue">this is html content</span>'
       
        , eleClass: 'green'
        , enableClass: true
        , classObj :{
          'green' : true,
          'big-font': true,
        }

        , visible: true
        , onceValue: 10
        , toUrl: 'http://baidu.com'
        , attrname: 'href' // 🙅‍♂️不可以有大写

        , event: 'click'

        , myName: 'qing'
        , myAge: 18

        , firstName : 'qing'
        , lastName : 'yi'
      }
    },
    methods:{
      handleClick(){
        this.count++
      }

      , userInfo(){
        return this.myName + this.myAge 
      }
    },
    computed:{
      userInfo2(){
        // 不可以跟方法名同名 会出错哦
        console.log('userInfo: computed attribute called!')
        return this.myName + this.myAge 
      },
      fullName: {
        get() {
          return this.firstName + ' ' + this.lastName
        }
        , set(value) {
          console.log('set fullname: ' + value); 
          //  value.split([' ',','])
          // 正则参考 搜索 **js regexp** ：https://blog.csdn.net/a15297701931/article/details/126479577
          const reg = /,|\s+/ig // 空格或者逗号做为分割符 ； i - 忽略大小写 ；g - 全部要
          //  const parts = value.split(new RegExp('(,|\s+)','ig'))
           const parts = value.split(reg)
           console.log(parts);
           this.firstName = parts[0];
           this.lastName = parts[1]
        }
      }
    }

  }).mount('#app')

  console.log(vm) // TODO 了解下Proxy

  // 延迟调用setter
  setTimeout(function () {
    vm.fullName = 'qing chen'
  }, 2000)

</script>
<?php JsBlock::end() ?>

<?php CssBlock::begin() ?>
<style>
.vue-msg {
  background-color:azure;
}
.green {
  color:greenyellow
}
.big-font {
  font-size: 2rem
}
</style>
<?php CssBlock::end() ?>