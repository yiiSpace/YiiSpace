# AOForm JS Library

Simple responsive Forms generator with JSON Schema, without dependencies (Pure JS) in 10Kb. We want to continue improving our open source library, so any changes or additions of new elements will be found in the [documentation](https://github.com/spexnetworks/aoform/wiki). 😃

AOForm is completly compatible with Webkit, Gecko and IE9+.

In CSS we use Flexible Box Layout Module, making complete responsive form 😎. [See compatibility here](https://caniuse.com/#feat=flexbox).

[![DepShield Badge](https://depshield.sonatype.org/badges/spexnetworks/aoform/depshield.svg)](https://depshield.github.io)

## Usage

For start using add to `<head>`:

```javascript
<link rel="stylesheet" type="text/css" href="aoform.min.css">
<script src="https://example.com/js/aoform.min.js"></script>
``` 
For create form need understand the simple JSON Schema. More types of form elements in [Wiki](https://github.com/spexnetworks/aoform/wiki/JSON-Schema).

```javascript
var jsonForm = [
{
 "type": "input",
 "name": "name",
 "label": "Name",
 "values": ""
},
{
 "type": "select",
 "name": "color",
 "label": "Favorite Color",
 "values": [
	{"label":"Blue","value":"blue"},
	{"label":"Yellow","value":"yellow"},
	{"label":"Orange","value":"orange"}
 ]
}
];
```

After JSON Schema, can create new Form with:

```javascript
var myForm = new AOForm(jsonForm, document.querySelector('body'));
```
**AOForm function need Form and Element for append form.**

## Get Form Data

```javascript
myForm.data;
```

## Custom CSS

We add classes in `ClassesAO` object in the follow struct:

```javascript
const ClassesAO = {
	metaElement: {
		class: 'aoform'
	},
	container: {
		class: 'aoform-container'
	},
	input: {
		container: {
			class: 'aoform-input-container'
		},
		text: {
			class: 'aoform-input'
		}
	}...
```

Also you can replace the class of element with your own class. The HTML struct of elements can see in [Wiki](https://github.com/spexnetworks/aoform/wiki/CSS-Schema).

## Screenshot

Normal             |  Responsive
:-------------------------:|:-------------------------:
![AOForm Example Screenshot](https://i.imgur.com/ia2s8ZD.png)  |  ![AOForm Example Screenshot](https://i.imgur.com/YHZzMx0.png)

## License

[Licensed under the MIT license](https://github.com/spexnetworks/aoform/blob/master/LICENSE).
