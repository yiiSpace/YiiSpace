<?php
// 试下动态生成表单
  $assetBaseUrl = \common\widgets\EasyJsonFormAsset::register($this) ;
?>

<div class="php-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>

    <div id="my-container"></div>

</div>
<?php \year\widgets\JsBlock::begin() ?>
<script>

// Loading the structure. In real life, the structure would be retrieved from
// the database. In this example, we are just passing a hardcoded structure.
let jsonStructure = `[
    {
        "type": "text",
        "label": "New Text 1",
        "customattribute": "",
        "mandatory": false,
        "properties": {
            "lengthmeasurement": "no",
            "lengthmax": 0,
            "lengthmin": 0,
            "multiline": false
        },
        "value": ""
    }
]`;

// The JSON needs to be converted to an object, before it is passed to EasyJsonForm
let structure = JSON.parse(jsonStructure);

// Creating the EasyJsonForm, now with the structure of the saved form
var ejf = new EasyJsonForm('my-form', structure);

// Initializing the form the page
document.getElementById('my-container').appendChild(ejf.formGet());

</script>
<?php \year\widgets\JsBlock::end() ?>