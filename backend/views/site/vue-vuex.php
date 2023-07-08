
<?php

use common\widgets\VueAsset;
use common\widgets\VueXAsset;
use year\widgets\CssBlock;
use year\widgets\JsBlock;

VueAsset::register($this);
VueXAsset::register($this);
?>


<?=__FILE__?>

<div id="app" class="vue-msg">

<div>
  <h3>使用vuex</h3>

  {{message}}

  <hr>
  <h4> from vuex</h4>
  {{store.state.message}}

  <hr>
  <h4> store data from user module </h4>
  {{store.state.user.info}}

  <p>
    可以在控制台 用vue-tools开发工具查看 store的内容！
</p>
</div>

</div>

<?php JsBlock::begin()?>
<script>
  const { createApp } = Vue

  console.log(Vuex)
  const {  createStore , useStore } = Vuex

  const myStore = createStore({
 //全局state，类似于vue中的data
  state() {
    return {
       message: "hello vuex",
       name: "my-store",
    };
  },

 //修改state函数
 // 使用 ： store.commit('mutationName',<params...>)
  mutations: {
    updateMessage(state,msg){
      state.message = msg 
    }
  },

 //提交的mutation可以包含任意异步操作
 // 使用： store.dispatch('actionName',<{some-params-here}>)
  actions: {
  },

 //类似于vue中的计算属性
  getters: {
  },

 //将store分割成模块（module）,应用较大时使用
 // ⚠️ 这里其实跟YII Modules 结构类似都是组合设计模式的体现 内部结构跟外部结构一样
  modules: {
    user:{
      state(){
        return {
          info: {
            name: 'qing',
            age: 18
          }
        }
      }
    }
  }
})


  const app = createApp({
    data() {
      return {
        count: 0,
        message: 'Hello Vue!',
         store: useStore()
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

  })


  app.use(myStore)

  console.log(myStore)
  // console.log(app)

  const vm = app.mount('#app')

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