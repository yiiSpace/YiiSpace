<template>
    <div class="hello">Hello {{ who }}</div>
</template>
  
<script>
module.exports = {
    data: function () {
        return {
            who: 'yiispace world'
        }
    }
}
</script>
  
<style>
.hello {
    background-color: rgb(52, 168, 192);
}
</style>