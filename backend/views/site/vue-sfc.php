<?php

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

<div id="filterModalContainer">
    <my-element />
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

Vue.createApp({
    components: {
        'my-element': Vue.defineAsyncComponent( () => loadModule('<?= $asset->baseUrl ?>/MyElement.vue', options) )
    }
}).mount('#app');

</script>
<?php JsBlock::end() ?>

<?php CssBlock::begin() ?>
<style>
.vue-msg {
  background-color: darkgoldenrod;
}
</style>
<?php CssBlock::end() ?>