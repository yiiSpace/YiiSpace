<?php
/**
 * @see https://medium.com/@marcel.leusch/use-vue-3-single-file-components-without-compilation-ac2ccb5f15c2
 * @see https://stackoverflow.com/questions/75560017/vue-warn-unhandled-error-during-execution-of-async-component-loader-at-async
 * 
 */

use backend\components\VueComponentsAsset;
use common\widgets\NaiveUiAsset;
use common\widgets\VueAsset;
use common\widgets\VueSFCLoaderAsset;
use year\widgets\CssBlock;
use year\widgets\JsBlock;

// VueAsset::register($this);

/**  @var $this yii\web\View */

// $this->registerJsFile('https://cdn.jsdelivr.net/npm/vue3-sfc-loader/dist/vue3-sfc-loader.js',[]);
VueSFCLoaderAsset::register($this) ;

NaiveUiAsset::register($this) ;

$asset = VueComponentsAsset::register($this);
echo $asset->baseUrl ;
?>

<pre>
<code class='javascript'>
  // <!-- some code here -->
</code>

</pre>

<?=  __FILE__ ?>

<div id="app" class="vue-msg">

<div id="filterModalContainer">
    <h4>注意自闭和组件的加载有问题哦😯！</h4>
<my-element> </my-element>

    <h4>使用naiveui</h4>
    <div>
    <n-button>{{ message }}</n-button>
    <n-space>
    <n-button>Default</n-button>
    <n-button type="tertiary">
      Tertiary
    </n-button>
    <n-button type="primary">
      Primary
    </n-button>
    <n-button type="info">
      Info
    </n-button>
    <n-button type="success">
      Success
    </n-button>
    <n-button type="warning">
      Warning
    </n-button>
    <n-button type="error">
      Error
    </n-button>
  </n-space>

   
    </div>
   
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

const app = Vue.createApp({
    setup() {
          return {
            message: 'naive'
          }
        },
    components: {
        'my-element': Vue.defineAsyncComponent( () => loadModule('<?= $asset->baseUrl ?>/MyElement.vue', options) )
    }
});

// 使用naiveui
app.use(naive);

app.mount('#app');

</script>
<?php JsBlock::end() ?>

<?php CssBlock::begin() ?>
<style>
.vue-msg {
  background-color:azure;
  margin: 5px;
  padding: 5px;
}
</style>
<?php CssBlock::end() ?>