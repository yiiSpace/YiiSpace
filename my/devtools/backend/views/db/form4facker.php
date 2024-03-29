<?php
/** @var \yii\web\View $this */
/** @var string $content */

// 试下动态生成表单

\common\widgets\DFormAsset::register($this);
\common\widgets\OutperFormAsset::register($this) ;

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


        <form id="myform">
            this content will be replaced
        </form>
        <form id="myform2">
            this content will be replaced
        </form>


    </div>
<?php \year\widgets\JsBlock::begin() ?>
    <script type="text/javascript">
	$(function() {
	  // Generate a form
		$("#myform").dform({
		    "action" : "index.html",
		    "method" : "get",
		    "html" :
		    [
		        {
		            "type" : "p",
		            "html" : "You must login"
		        },
		        {
		            "name" : "username",
		            "id" : "txt-username",
		            "caption" : "Username",
		            "type" : "text",
		            "placeholder" : "E.g. user@example.com"
		        },
		        {
		            "name" : "password",
		            "caption" : "Password",
		            "type" : "password"
		        },
		       {
		         "name" : "country",
		        "type" : "select",
                "options" : {
                    "us" : "USA",
                    "ca" : "Canada",
                    "de" : {
                        "selected" : "selected",
                        "html" : "Germany"
                        }
                    }
                },
                {
                    "type" : "checkboxes",
                    "options" : {
                        "newsletter" : "Receive the newsletter",
                        "terms" : "I read the terms of service",
                        "update" : "Keep me up to date on new events"
                    }
                },
		        {
		            "type" : "submit",
		            "value" : "Login"
		        }
		    ]
		});
	});

    // ======================

     var fields = [
   [ "houseno", "number", "This is the description", {min:1, max:999}],
[ "foo", "text", "This is the description",
      {validate:function(flds) {
        if (flds.foo.value != flds.foo2.value)
          return "Mismatch between foo en foo2 fields";
       } }
       ],
   [ "foo2", "password", "This is the description"],
   [ "bar", "select", "This is the description",
     {list:
      ["one",
       ["two", {class:"bright"}],
       ["three", "Three choices"],
       "four",
       ["five", "Five", {style:"display:none;"}],
      ]
     }
   ],
 ];
 var form = Outperform.create("form", {id:"hello"}, fields);
 // document.body.appendChild(form);
 document.getElementById('myform2').appendChild(form);

/*
 // on submit:
 if (form.reportValidity()) {
   console.log(JSON.stringify(Outperform.getfields(form)));
   Outperform.clearpersist(form);
 }
 */

    </script>
<?php \year\widgets\JsBlock::end() ?>