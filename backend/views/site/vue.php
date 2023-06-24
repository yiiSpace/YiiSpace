
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
      <h3>class绑定</h3>
      <div v-bind:class='eleClass'>常规绑定</div>
      <div v-bind:class="{[eleClass]: enableClass, 'big-font':enableClass }">条件式 常规绑定
        根据enableClass 的值动态决定是否采用某些css样式类

      </div>
      <div v-bind:class="classObj"> 
        根据enableClass 的值动态决定是否采用某些css样式类

        跟上面👆同效果 绑定的是classObj 对象

      </div>
      <div v-bind:class="classObj2"> 

        跟上面👆同效果 绑定的是classObj2 计算属性

      </div>

      <div v-bind:class="[redClass,bigFontClass]">
          数组形式 css-class
      </div>
    </div>

    <div>
      <h3>style 绑定</h3>
      <span v-bind:style="{color: styleColor}">内容 内联 解构对象形式</span> <br>
      <span v-bind:style="styleObj">内容 对象形式</span> <br>
      <span v-bind:style="[redStyle, smallStyle]">内容 数组形式</span>

    </div>

    <div>
      <h2>条件渲染指令 </h2>
      <div v-if="flag">
        是否显示
      </div>
      <div v-else> 不显示</div>

      <div v-if="type === 'A' ">
        成绩是 A
      </div>
      <div v-else-if="type === 'B' ">
        成绩是 B
      </div>
      <div v-else>
        其他低于 A B 等级的 
      </div>

      <template v-if="flag">
        <h2>标题</h2>
        <h4>标题</h4>
        <p>
          内容 
        </p>
      </template>

      <div v-show="flag" >
        显示 | 隐藏

        控制dislay 属性 注意跟v-if 的区别 v-if 涉及节点的增加和删除
        v-show 总是生成节点 用display控制其是否显示
      </div>
    </div>

    <div>
      <h2>循环相关</h2>
      <ul>
        <li v-for="item in grads">
          {{item}}
        </li>
      </ul>
      
      <ul>
        <li v-for="(  item,idx) in grads">
         {{idx}}: {{item}}
        </li>
      </ul>
      <h3>js 迭代器语法</h3>
      <ul>
        <li v-for="item of grads">
          {{item}}
        </li>
      </ul>

      <h3> 对象属性迭代</h3>
      <ul>
        <li v-for="attr in object">
          {{attr}}
      </li>
    </ul>
      <ul>
        <li v-for="(value, name, idx) in object">
          {{idx}} : {{name}} => {{value}}
      </li>

    <template v-for="(item, idx) in grads">
      <li>
        {{idx}}
      </li>
      <li>
        {{item}}
      </li>

    </template>
    </ul>

    <h3>数值循环</h3>
    <ul>
      <li v-for="n in 10">
        {{n}}
      </li>
    </ul>
    <h3>v-if v-for 优先级问题 不推荐出现在同一个元素上 推荐拆开哦😯</h3>
    <template v-for="n in 10">
      <span v-if="n <= 7">{{n}}</span>
    </template>
    <br>
    <template v-for="n in 10">
      <span v-if="n !== 5">{{n}}</span>
    </template>

    </div>

    <div>
      <h3>数组相关</h3>
      <ul>
        <li v-for="city in cities">{{city}}</li>
      </ul>
      <ul>
        <li v-for="city in cities">
          <input type="checkbox">
          {{city.name}}
        </li>
      </ul>
      <button v-on:click="addCity">add city</button>

      <hr>
      <ul>
        <li v-for="city in cities" v-bind:key="city.id">
          <input type="checkbox">
          {{city.name}}
        </li>
      </ul>
      <button v-on:click="addCity">add city</button>
    </div>

    <div>
      <h3>事件处理能力</h3>

      <div>
        <h4>计算器</h4>
        <span class="big-font red">
          {{count}}
        </span> <br>
        <button v-on:click="count++" >add count {{count}}</button>
        <button  @click="addCount" >add count {{count}}</button>
        <button  @click="addCount2(5)" >add count {{count}}</button>
        <button  @click="addCount3(5,$event)" >add count {{count}}</button>
      </div>

      <div v-on:click="addCount">
        <h3>事件修饰符</h3>
        <div>
          .stop | .once | .prevent | .capture | .self | .passive

        更多的请查看手册: ...
        </div>
        <div>{{count}}</div>
        <button  @click="addCount3(5,$event)" >add count {{count}} 同时👆传递click 加上父亲的click 等于加了6</button>
        <button  @click.stop="addCount3(5,$event)" >add count {{count}}</button>
        <button  @click.once="addCount3(5,$event)" >add count {{count}} 只调用一次 再多次的点击变成触发父组件的click事件 </button>
        <button  @click.enter="addCount3(5,$event)" >add count {{count}} 同时👆传递click 加上父亲的click 等于加了6 回车键也可以触发</button>
      </div>
      
      <h3>键盘修饰符</h3>
      <button  v-on:keyup.enter="addCount3(5,$event)" >add count {{count}} 每次加5  回车键也可以触发</button>

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
        , redClass: 'red'
        , greenClass: 'green'
        , bigFontClass: 'big-font'

        , styleColor: 'red'
        , styleObj: {
          'color': 'green'
        }
        , redStyle: {
          'color': 'red'
        }
        , smallStyle:{
          'font-size': '0.8rem'
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

        , flag: true 
        , type: 'D'

        // 用于v-for 的数据
        , grads: [
          'A', 'B', 'C', 'D', 'E'
        ]
        , object: {
          name: 'mr. qing',
          gender: 'M',
          age: 18 
        }

        // 数组测试
        , cities: [
          {id:1, name:'上海'},
          {id:2,name:'重庆'},
          {id:3, name:'北京'},
          {id:4, name:'西安'},
        ]
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
      , addCount2(num){
        // 隐式传递event
        console.log(event)
        this.count += num
      }
      , addCount3(num, ev){
        // 显式传递event
        console.log(ev)
        this.count += num
      }

      , userInfo(){
        return this.myName + this.myAge 
      }

      , addCity(){
        const count = this.cities.length 
        console.log('city count: '+ count)
        this.cities.unshift({name: '广东'})
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
      },
      classObj2() {
        return {
          'green' : true,
          'big-font': true,
           }
        }
      
    }

  }).mount('#app')

  console.log(vm) // TODO 了解下Proxy

  // 延迟调用setter
  setTimeout(function () {
    vm.fullName = 'qing chen'
  }, 2000)


 // 数组中推入一个城市
 vm.cities.push({
   name: '深圳'
 })
 setTimeout(function () {
    vm.cities[1] = {name: '南京'}
  }, 4000)

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
.red {
  color:red
}
.big-font {
  font-size: 2rem
}
</style>
<?php CssBlock::end() ?>