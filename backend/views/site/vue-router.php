<?php
/**
 * @see https://stackoverflow.com/questions/75560017/vue-warn-unhandled-error-during-execution-of-async-component-loader-at-async
 *
 */

use backend\components\VueComponentsAsset;
use common\widgets\VueRouterAsset;
use common\widgets\VueSFCLoaderAsset;
use year\widgets\CssBlock;
use year\widgets\JsBlock;

/**  @var $this yii\web\View */

VueSFCLoaderAsset::register($this);
VueRouterAsset::register($this);

$asset = VueComponentsAsset::register($this);
echo $asset->baseUrl;
?>

<pre>
<code class='javascript'>
  // 可以修改为 参考：https://stackoverflow.com/questions/75560017/vue-warn-unhandled-error-during-execution-of-async-component-loader-at-async
async getFile(url) {
        const res = await fetch(url);

        if ( !res.ok ) {
            throw Object.assign(new Error(res.statusText + ' ' + url), { res });
        }

        return {
            getContentData: (asBinary) => asBinary ? res.arrayBuffer() : res.text(),
        }
    },
</code>

</pre>


<div id="app" class="vue-app">
    <h1>Hello Vue App!</h1>

    <div id="filterModalContainer">
         <my-element />
    </div>

    <hello-world></hello-world>
    <p>
        <router-link to="/">Go to Home</router-link>
        <router-link to="/about">Go to About</router-link>
        <router-link to="/about/1234">Go to About/1234</router-link>
    </p>
    <router-view></router-view>
</div>


 

<?php JsBlock::begin()?>
<script>
  const { loadModule } = window['vue3-sfc-loader'];

  const Home = {
        template: '<div>Home</div>'
    };

    const About = {
        template: '<div>About</div>',
        created() {
            console.debug("About created");
            this.$watch(
                () => this.$route.params,
                (toParams, previousParams) => {
                    // react to route changes...
                    console.debug(toParams, previousParams);
                }
            )
        }
    }

    const routes = [
        { path: '/', component: Home },
        { path: '/about', component: About },
        { path: '/about/:userId', component: About }
    ];


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

const router = VueRouter.createRouter({
        history: VueRouter.createWebHashHistory(),
        routes, // short for `routes: routes`
    });

const app = Vue.createApp({
    router: router,
    components: {
        'my-element': Vue.defineAsyncComponent( () => loadModule('<?=$asset->baseUrl?>/MyElement.vue', options) ),
        'hello-world': Vue.defineAsyncComponent( () => loadModule('<?=$asset->baseUrl?>/HelloWorld.vue', options) )
    }
})
.use(router)
.mount('#app');

</script>
<?php JsBlock::end()?>

<?php CssBlock::begin()?>
<style>
.vue-app {
  background-color:beige;
}
</style>
<?php CssBlock::end()?>