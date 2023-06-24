
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
  mutations: {
  },

 //提交的mutation可以包含任意异步操作
  actions: {
  },

 //类似于vue中的计算属性
  getters: {
  },

 //将store分割成模块（module）,应用较大时使用
  modules: {
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