<?php
/**
 * @see https://medium.com/@marcel.leusch/use-vue-3-single-file-components-without-compilation-ac2ccb5f15c2
 * @see https://stackoverflow.com/questions/75560017/vue-warn-unhandled-error-during-execution-of-async-component-loader-at-async
 * 
 */

use backend\components\VueComponentsAsset;
use common\widgets\VueAsset;
use common\widgets\VueSFCLoaderAsset;
use year\widgets\CssBlock;
use year\widgets\JsBlock;

// VueAsset::register($this);

/**  @var $this yii\web\View */

// $this->registerJsFile('https://cdn.jsdelivr.net/npm/vue3-sfc-loader/dist/vue3-sfc-loader.js',[]);
VueSFCLoaderAsset::register($this) ;


$asset = VueComponentsAsset::register($this);
echo $asset->baseUrl ;
?>

 
 

<?=  __FILE__ ?>

<div id="app" class="vue-msg">
<div>
    <h2>异步组件</h2>
    <my-element></my-element>
</div> 

<div id="filterModalContainer">
    <!-- 注意自关闭组件 不是有效语法 反斜杠出现的位置不能是最后: <button-counter/> -->
  <button-counter> </button-counter> <br>
  多一个
  <button-counter> </button-counter><br>
  另一个
  <button-counter> </button-counter><br>

</div>

<div>
    <h3>父子通讯</h3>
    注意第二个命名方法跟骆驼命名方法的转换 坑爹的地方要注意⚠️ 
    <my-child v-bind:msg="message" v-bind:from-parent="message"></my-child>
    <my-child msg="消息1" from-parent="消息2"></my-child>
</div>

<div>
    <h3>定义props 方式2</h3>
    <!-- 第二个属性是js表达式哦 -->
    <my-child2 msg="消息1" :from-parent="200"></my-child2>
    <my-child2 msg="消息1" :from-parent="{name:'hi' , age: 18}"></my-child2>
    <!-- v-bind 会把对象的属性作为组件根元素的html属性绑定过去的 所以模版中需要有单个根元素作为容器节点才行 -->
    <my-child2 v-bind="attributes" msg="消息1" :from-parent="{name:'hi' , age: 18}"></my-child2>
</div>

<div>
    <h3>传递消息</h3>
    <my-child3  :msg="2" :from-parent="{}"></my-child3>
    <my-child3  msg="2" :from-parent="{}"></my-child3>
    <my-child3  msg="2" ext="其他变量"></my-child3>

</div>

<div>
    <h3>自定义事件</h3>
    <my-component v-on:child-event="parentFn" :msg="message"></my-component>
</div>

<div>
    <h3>组件双向绑定</h3>

    <input type="text" v-model="message">
    <br>

    <input type="text" v-bind:value="message">
    <input type="text" v-on:input="message = $event.target.value">
    <br>
    综合为
    <input type="text" v-bind:value="message" v-on:input="message = $event.target.value">
    <!-- <my-component2   :parent-message="message"></my-component2> -->
    <my-component2   v-model:parent-message="message"></my-component2>

</div>

<div>
    <h3>slot的使用</h3>
    <my-component3   > 
        this is the ... slot content from parent component
    </my-component3>
    <my-component3   ></my-component3>
    <my-component4 v-slot:header  >123</my-component4>

</div>

<div>
    <h3>生命周期 </h3>
    <my-component5   ></my-component5>
</div>

</div>

<?php JsBlock::begin() ?>
<script>
  const { loadModule } = window['vue3-sfc-loader'];

const options = {
    moduleCache: {
        vue: Vue
    },
    async getFile(url) {
        const res = await fetch(url);
        if ( !res.ok )
            throw Object.assign(new Error(res.statusText + ' ' + url), { res });
        return {
            getContentData: asBinary => asBinary ? res.arrayBuffer() : res.text(),
        }
    },
    addStyle(textContent) {
        const style = Object.assign(document.createElement('style'), { textContent });
        const ref = document.head.getElementsByTagName('style')[0] || null;
        document.head.insertBefore(style, ref);
    },
}

const MyComponent = {
    props:[
        'msg' ,
        'fromParent'
    ],
    emits: {
        // 'child-event' // 不验证
        'child-event': (value)=>{
                console.log("接下来应该验证value的值：" );
                console.log(value)
                 return true 

            }
        },
    data(){
        return {
            message: 'this is message defined in child component'
        }
    }
    , template: `
          <div>
          <h4>MyComponent</h4>
          <p>自己的变量: {{message}}</p>
          <p>传自父亲的: {{msg}}</p>
          <button v-on:click="childClick">触发事件</button>
          </div>
    `
    ,methods:{
        childClick(){
            console.log("子组件事件处理")

            // 级联触发自定义的事件
            this.$emit('child-event',{})
        } 
    }
}
const MyChild = {
    props:[
        'msg' ,
        'fromParent'
    ],
    data(){
        return {
            message: 'this is message defined in child component'
        }
    }
    , template: `
          
          <p>
          来自父组件的值:  {{msg}}
          <br/>
          第二个值的类型  {{ typeof fromParent}}
          </p>
          <p>{{message}}</p>
    `
}
const MyChild2 = {
    props:{
      msg: String,
      fromParent: Number
    }
        
    ,
    data(){
        return {
            message: 'this is message defined in child component'
        }
    }
    , template: `
          <div>
          <p>
          来自父组件的值:  {{msg}}
          <br/>
          第二个值的类型  {{ typeof fromParent}}
          </p>
          <p>{{message}}</p>
          </div>
    `
}
const MyChild3 = {
    props:{
      msg: String,
      fromParent: Number
      ,extra: {
        type: [String, Number, Object],
        // default 也可以是一个函数哦😯
        default: '你可以传递其他值 现在看到的是默认值哦'
        ,validator(value){
            console.log("触发验证")
            // return ['a','b','c'].indexOf(value) !== -1 ;
            return true 
        }
      }
    }
        
    ,
    data(){
        return {
            message: 'this is message defined in child component'
            ,parentMsg: this.msg
        }
    }
    , template: `
          <div>
           
          来自父组件的值:  {{msg}}
          <br/>
           
          <p>{{parentMsg}}</p>
           <button @click="parentMsg++">++</button> 

           <h4>传给子组件的extra属性可以有默认值 传了就覆盖 不传就显示默认</h4>
           {{extra}}

          </div>
    `
}


const MyComponent2 = {
    props:[
        'parentMessage' ,
         
    ],
    emits: {
        // 'child-event' // 不验证
        'child-event': (value)=>{
                console.log("接下来应该验证value的值：" );
                console.log(value)
                 return true 

            }
        },
    data(){
        return {
            message: 'this is message defined in child component'
        }
    }
    , template: `
          <div>
          <h4>MyComponent2</h4>
          
          <p>传自父亲的: {{parentMessage}}</p>
        <div>
        <input type="text" v-bind:value="parentMessage" v-on:input="$emit('update:parentMessage',$event.target.value)" />
        
        </div>

          <button v-on:click="childClick">触发事件</button>
          </div>
    `
    ,methods:{
        childClick(){
           
            
        } 
    }
}

const MyComponent3 = {
    props:[
        'parentMessage' ,
         'title'
    ],
    emits: {
        
        },
    data(){
        return {
            // _title: this.title || 'MyComponent3'
        }
    }
    , template: `
          <div>
          <h4>{{title || 'MyComponent3'}}</h4>
          <slot>不传则显示此默认值哦</slot>
          </div>
    `
    ,methods:{
        
    }
}

const MyComponent4 = {
    props:{

        title:{
            type: String,
            default: 'default title'
        } 
    }
    ,
    emits: {
        
        },
    data(){
        return {
            // _title: this.title || 'MyComponent3'
        }
    }
    , template: `
          <div>
          <h4>{{title || 'MyComponent4'}}</h4>

          <h5>
          <slot name="header">不传则显示此默认值哦</slot>
          <h5>
          </div>
    `
    ,methods:{
        
    }
}

const MyComponent5 = {
    
    data(){
        return {
           msg: 'hi MyComponent5'
        }
    }
    , template: `
          <div>
          <h4>{{title || 'MyComponent5'}}</h4>
           
          {{msg}}
          </div>
    `
    , created(){
        console.log('component5 created')
        // ˙这个时期还跟dom树没啥关系 还没挂载到树上
    }
    , mounted(){
        console.log('component5 mounted')
        // 这个时期可以使用 document相关的函数了 
    }
    , updated(){
        console.log('vm dom is updated');
    }
}

const app = 
// Vue.createApp({})

// 下面这个是组件配置
Vue.createApp({
    methods: {
        parentFn(){
            console.log("parentFn called")
            this.message = '通知所有子组件的消息哦😯'
        }
    },
    data(){
        return {
            message: 'hi VUE3'
            ,post :{
                likes: 100
            }
            , attributes: {
                id: 'name',
                class: 'input'
            }
        }
    },
    // 这个是局部组件定义？ 是推荐使用的方式!
    components: {
        'my-element': Vue.defineAsyncComponent( () => loadModule('<?= $asset->baseUrl ?>/MyElement.vue', options) )
        ,'my-child': MyChild 
        ,'my-child2': MyChild2
        ,'my-child3': MyChild3
        ,'my-component': MyComponent
        ,'my-component2': MyComponent2
        ,'my-component3': MyComponent3
        ,'my-component4': MyComponent4
        ,'my-component5': MyComponent5
    }
})

// 这个是全局组件定义方法 
// 组件后面的配置对象跟createApp 里面的配置是一样的 整个应用也是一个组件 全部组件形成组件树
// 猜测 配置对象 被赋值给了一个接口  : const config: IComponent = { .... } 
// 组件名称推荐使用 全小写横线隔开
app.component('button-counter',{
    data(){
        return {
            count: 0
        }
    }
    , template: `
          <p>{{count}}</p>
         <button v-on:click="count++">click {{count}}</button>
    `
})
app.mount('#app');

</script>
<?php JsBlock::end() ?>

<?php CssBlock::begin() ?>
<style>
.vue-msg {
  background-color: darkgoldenrod;
}
</style>
<?php CssBlock::end() ?>