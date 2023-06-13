
<?php

use common\widgets\VueAsset;
use year\widgets\JsBlock;

VueAsset::register($this);
?>


<?=  __FILE__ ?>

<div id="app">{{ message }}</div>

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