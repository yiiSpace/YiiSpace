<?php
// 试下动态生成表单
  $assetBaseUrl = \common\widgets\EasyJsonFormAsset::register($this) ;
  $assetBaseUrl = \common\widgets\DynFormsAsset::register($this) ;
  \common\widgets\JsonFormsAsset::register($this) ;

//  \Faker\Factory::
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
    <div id="my-container2"></div>

    <div id="main-form"></div>
    <button onclick="loadForm();">load form</button>



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

// ====
const random = () => Math.random().toString(36).substring(7);
const form7 = [
  {
    type: 'input',
    id: `name${random()}`,
    label: 'Name',
    placeholder: 'Write your name here',
    attr: {
      class: 'test',
    },
    helps: {
      label: 'This is your name',
    }
  },
  {
    type: 'textarea',
    id: `life${random()}`,
    label: 'About your life',
    attr: {
      class: 'test',
      placeholder: 'Write about your life...',
    },
    helps: {
      label: 'Write about your life',
    },
  },
  {
    type: 'select',
    id: `country${random()}`,
    label: 'Country',
    attr: {
      class: 'test',
    },
    options: [
      { label: 'EEUU', value: 'US' },
      { label: 'Chile', value: 'CL' },
      { label: 'Germany', value: 'DE' },
    ],
    helps: {
      label: 'Select your country',
    }
  },
  {
    type: 'multiple',
    id: `color${random()}`,
    label: 'Color',
    attr: {
      class: 'test',
    },
    options: [
      { label: 'Blue', value: 'blue' },
      { label: 'Green', value: 'green' },
      { label: 'Black', value: 'black' },
    ],
    helps: {
      label: 'Select your favorite color',
    }
  },
  {
    type: 'radio',
    id: `gender${random()}`,
    label: 'Gender',
    attr: {
      class: 'test',
    },
    options: [
      { label: 'Male', value: 'male' },
      { label: 'Female', value: 'female' },
    ],
    helps: {
      label: 'Select your gender',
    }
  },
  {
    type: 'checkbox',
    id: `pet${random()}`,
    label: 'Pet',
    attr: {
      class: 'test',
    },
    options: [
      { label: 'Cat', value: 'cat' },
      { label: 'Dog', value: 'dog' },
      { label: 'Bird', value: 'bird' },
    ],
    helps: {
      label: 'Select your favorite pet',
    }
  },
  {
    type: `rate`,
    id: `satisfaction${random()}`,
    label: 'Satisfaction',
    icon: 'star',
    attr: {
      class: 'test',
    },
    options: [
      { label: 'Very good', value: '5' },
      { label: 'Good', value: '4' },
      { label: 'Indifferent', value: '3' },
      { label: 'Not bad', value: '2' },
      { label: 'Bad', value: '1' },
    ],
    helps: {
      label: 'How much satisfied are you?',
    }
  }
];

const options = {
  container: document.querySelector('#main-form'),
  debug: true,
};

function loadForm(){
     const form = () => {
         return form7;
     };
     Form = new DynForm({ form: form(), options });
     Form.render();
 }

 //========

 var schema = {"type": "boolean"}
 var schema = {
    "$schema": "http://json-schema.org/draft-03/schema#",
    "type": "object",
    "properties": {
        "pageNum": {
            "type": "integer",
            "title": "Page number",
            "description": "Page number to be queried, `1-based`. See [Pagination](https://en.wikipedia.org/wiki/Pagination) for more details",
            "default": 1,
            "required": true
        },
        "pageSize": {
            "type": "integer",
            "title": "Page size",
            "description": "Number of records per page",
            "required": true,
            "default": 50,
            "enum": [
                10,
                25,
                50,
                100
            ]
        },
        "selectedFacetValues": {
            "type": "array",
            "title": "Query terms",
            "minItems": 2,
            "uniqueItems": true,
            "items": {
                "description": "Query item",
                "type": "object",
                "properties": {
                    "facetName": {
                        "type": "string",
                        "title": "Field name",
                        "description": "Indexed field name",
                        "required": true
                    },
                    "matchAllNull": {
                        "type": "boolean",
                        "title": "Match nulls"
                    },
                    "matchAllNotNull": {
                        "type": "boolean",
                        "title": "Match not nulls"
                    },
                    "facetValues": {
                        "type": "array",
                        "title": "Field values",
                        "items": {
                            "type": "object",
                            "properties": {
                                "value": {
                                    "type": "string",
                                    "title": "Value"
                                }
                            }
                        }
                    },
                    "included": {
                        "type": "boolean",
                        "title": "Included"
                    }
                }
            }
        },
        "sorts": {
            "type": "array",
            "title": "Sorting",
            "items": {
                "type": "object",
                "properties": {
                    "fieldName": {
                        "type": "string",
                        "title": "Field name"
                    },
                    "ascending": {
                        "type": "boolean",
                        "title": "Ascending"
                    }
                }
            }
        }
    }
};
var BrutusinForms = brutusin["json-forms"];
var bf = BrutusinForms.create(schema);

var container = document.getElementById('my-container2');
data = [] ;
bf.render(container, data);

</script>
<?php \year\widgets\JsBlock::end() ?>