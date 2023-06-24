
<?php

use common\widgets\VueAsset;
use common\widgets\VuePiniaAsset;
use year\widgets\CssBlock;
use year\widgets\JsBlock;

VueAsset::register($this);
VuePiniaAsset::register($this);
?>


<?=__FILE__?>

<div id="app" class="vue-msg">




<div>
  <h3>使用pinia</h3>

  {{message}}

  {{userStore.username}}
  
</div>




</div>

<?php JsBlock::begin()?>
<script>
  const { createApp } = Vue
  
  // console.log(Pinia)

  // TODO pinia 有个插件可以做持久化： pinia-plugin-persist
  const { defineStore, createPinia } = Pinia

  // const useStore = defineStore({
  const userStore = defineStore({
    id: 'user',
    state: () => ({
        count: 0,
        username: '10个肉包子'
    }),
    getters: {},
    actions: {},
})

  const app = createApp({
    data() {
      return {
        count: 0,
        message: 'Hello Vue!',
        userStore: userStore()
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

  app.use(createPinia())

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