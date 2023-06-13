
<?php

use common\widgets\VueAsset;
use year\widgets\CssBlock;
use year\widgets\JsBlock;

VueAsset::register($this);
?>


<?=  __FILE__ ?>

<div id="app" class="vue-msg">{{ message }}</div>

<?php JsBlock::begin() ?>
<script>
  const { createApp } = Vue
  
  createApp({
    data() {
      return {
        message: 'Hello Vue!'
      }
    }
  }).mount('#app')
</script>
<?php JsBlock::end() ?>

<?php CssBlock::begin() ?>
<style>
.vue-msg {
  background-color: darkgoldenrod;
}
</style>
<?php CssBlock::end() ?>