/*!	AO Forms - v1.0 - 2018-10-11
* https://github.com/spexnetworks - https://spexnetworks.com
* Javascript library for create custom forms with custom tags, not using input, select, textarea. Fully compatible Webkit, Gecko, IE9+.
* Copyright SPEX™ Networks, created for Videsk®. Licensed MIT */

"use strict";

//Position element to create
var increment = 0;

//User function interact
function AOForm(form,el){
	this.data = AOFormData;
	generateForm(form, function(completeForm){
		el.appendChild(completeForm);
		loadEvents();
		console.warn('Form is complete with '+completeForm.childNodes.length+' components. For more info visit https://https://github.com/spexnetworks/aoform');
		increment = 0; //For create a new AOForm
	});
};

//Validate JSON
function validateForm(form){
	if(!form){
		return false; //Not valid, form is null
	}
	else{
		try{
			var check = form[0].type; //Check if form have correct JSON format
			return true;
		}
		catch(e){
			console.error('Unexpected Error: JSON Format error. Please check, and try again. Documentation: https://https://github.com/spexnetworks/aoform'); //Error formating JSON
			return false;
		}
	}
};
//Function create all form
function generateForm(form,callback){
	var container = document.createElement(ClassesAO.metaElement.class);
	container.setAttribute('class',ClassesAO.container.class);
	if(validateForm(form)){ //If is valid form contnue with append to element
		for (var i = 0; i < form.length; i++) {
			genereateElement(form[i], function(el){ //Call genereateElement() function
				container.appendChild(el); //Append to element selected
			});
		}
		callback(container); //Callback function
	}
};

//Function for create struct elements v.1.0 [input,textarea,radio,checkbox,select]
function genereateElement(form, callback){
	//Create unique id for element
	function guidGenerator() {
	    var S4 = function() {
	       return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
	    };
	    return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
	};
	var tag = document.createElement(ClassesAO.metaElement.class); //Create element with custom tag. Default: 'aoform'
	var script = document.createElement('script'); //Create tag script for javascript
	var title = document.createElement(ClassesAO.metaElement.class);
	var id = guidGenerator();
	switch(form.type){
		case 'input': tag.setAttribute('class',ClassesAO.input.text.class);
				      tag.setAttribute('placeholder',form.label);
				      tag.setAttribute('name',form.name);
				      tag.setAttribute('value',form.values);
				      tag.setAttribute('contenteditable','true');
				      tag.setAttribute('spellcheck','false');
				      tag.setAttribute('data-id', id);
				      var data = '{"'+form.name+'": ""}';
				      AOFormData.push(JSON.parse(data));
				      var elSelector = "[data-id='"+id+"']";
				      var addScript = 'document.querySelector("'+elSelector+'").onkeydown =  function(){AOFormData['+increment+']["'+form.name+'"] = this.innerText;};';
				      TempListener.push(addScript);
				      var inputContainer = document.createElement(ClassesAO.metaElement.class);
				      inputContainer.setAttribute('class', ClassesAO.input.container.class);
				      inputContainer.appendChild(tag);
				      callback(inputContainer);
			break;
		case 'textarea': tag.setAttribute('class',ClassesAO.textarea.class);
					     tag.setAttribute('placeholder',form.label);
					     tag.setAttribute('name',form.name);
					     tag.setAttribute('value',form.values);
					     tag.setAttribute('contenteditable','true');
					     tag.setAttribute('spellcheck','false');
					     tag.setAttribute('data-id', id);
					     var data = '{"'+form.name+'": ""}';
					     AOFormData.push(JSON.parse(data));
					     var elSelector = "[data-id='"+id+"']";
					     var addScript = 'document.querySelector("'+elSelector+'").onkeydown =  function(){AOFormData['+increment+']["'+form.name+'"] = this.innerText;};';
					     TempListener.push(addScript);
					     callback(tag);
			break;
		case 'select': tag.setAttribute('class',ClassesAO.select.container.class);
					   tag.setAttribute('name',form.name);
					   var selectext = document.createElement(ClassesAO.metaElement.class);
					   selectext.setAttribute('class', ClassesAO.select.text.class);
					   selectext.setAttribute('placeholder', form.label);
					   selectext.setAttribute('data-id', id);
					   var elSelector = "[data-id='"+id+"']";
					   var addScript = 'document.querySelector("'+elSelector+'").onclick =  function(){if(this.nextSibling.classList.contains(ClassesAO.activeClass)){this.nextSibling.classList.remove(ClassesAO.activeClass);}else{this.nextSibling.classList.add(ClassesAO.activeClass);}};';
					   TempListener.push(addScript);
					   var optionContainer = document.createElement(ClassesAO.metaElement.class);
					   optionContainer.setAttribute('class', ClassesAO.select.options.container.class);
					   var options = form.values;
					   for (var i = 0; i < options.length; i++){
					   		var idOption = guidGenerator();
					   		var optionElement = document.createElement(ClassesAO.metaElement.class);
					   		optionElement.setAttribute('class',ClassesAO.select.options.option.class);
					   		optionElement.innerText = options[i].label;
					   		optionElement.setAttribute('value',options[i].value);
					   		optionElement.setAttribute('data-id',idOption);
					   		var elSelectorOption = "[data-id='"+idOption+"']";
					   		var addScript = 'document.querySelector("'+elSelectorOption+'").onclick =  function(){var value = this.getAttribute("value"); var text = this.innerText; AOFormData['+increment+']["'+form.name+'"] = value;document.querySelector("'+elSelector+'").click(); document.querySelector("'+elSelector+'").setAttribute("placeholder",text); document.querySelector("'+elSelector+'").classList.add(ClassesAO.select.text.notEmpty)};';
					   		TempListener.push(addScript);
					   		optionContainer.appendChild(optionElement);
					   }
					   tag.appendChild(selectext);
					   tag.appendChild(optionContainer);
					   var data = '{"'+form.name+'": ""}';
					   AOFormData.push(JSON.parse(data));
					   callback(tag);
			break;
		case 'radio': tag.setAttribute('class',ClassesAO.radio.container.class);
					  tag.setAttribute('name',form.name);
					  title.setAttribute('class', ClassesAO.title.class);
					  title.innerText = form.label;
					  tag.appendChild(title);
					  var options = form.values;
					  for (var i = 0; i < options.length; i++){
					  		var idOption = guidGenerator();
					  		var optionElement = document.createElement(ClassesAO.metaElement.class);
					  		optionElement.setAttribute('class',ClassesAO.radio.option.class);
					  		optionElement.setAttribute('placeholder',options[i].label);
					  		optionElement.setAttribute('value',options[i].value);
					  		optionElement.setAttribute('data-id',idOption);
					  		var elSelector = "[data-id='"+idOption+"']";
					  		var addScript = 'document.querySelector("'+elSelector+'").onclick =  function(){for (var i = 0; i < document.querySelectorAll(".'+ClassesAO.radio.option.class+'").length; i++) {document.querySelectorAll(".'+ClassesAO.radio.option.class+'")[i].classList.remove(ClassesAO.activeClass);}this.classList.add(ClassesAO.activeClass);AOFormData['+increment+']["'+form.name+'"] = this.getAttribute("value");};';
					  		TempListener.push(addScript);
					  		tag.appendChild(optionElement);
					  }
					  var data = '{"'+form.name+'": ""}';
					  AOFormData.push(JSON.parse(data));
					  callback(tag);
			break;
		case 'checkbox': tag.setAttribute('class',ClassesAO.checkbox.container.class);
					  tag.setAttribute('name',form.name);
					  tag.setAttribute('data-id', id);
					  title.setAttribute('class', ClassesAO.title.class);
					  title.innerText = form.label;
					  tag.appendChild(title);
					  var options = form.values;
					  for (var i = 0; i < options.length; i++){
					  		var idOption = guidGenerator();
					  		var optionElement = document.createElement(ClassesAO.metaElement.class);
					  		optionElement.setAttribute('class',ClassesAO.checkbox.option.class);
					  		optionElement.setAttribute('placeholder',options[i].label);
					  		optionElement.setAttribute('value',options[i].value);
					  		optionElement.setAttribute('data-id',idOption);
					  		var elSelector = "[data-id='"+idOption+"']";
					  		var addScript = 'document.querySelector("'+elSelector+'").onclick =  function(){var value = this.getAttribute("value");if(this.classList.contains(ClassesAO.activeClass)){AOFormData['+increment+']["'+form.name+'"].pop(value);this.classList.remove(ClassesAO.activeClass);}else{AOFormData['+increment+']["'+form.name+'"].push(value);this.classList.add(ClassesAO.activeClass);}};';
					  		TempListener.push(addScript);
					  		tag.appendChild(optionElement);
					  }
					  var data = '{"'+form.name+'": []}';
					  AOFormData.push(JSON.parse(data));
					  callback(tag);
			break;
		case 'multiselect': tag.setAttribute('class',ClassesAO.multiselect.container.class);
						   tag.setAttribute('name',form.name);
						   var selectext = document.createElement(ClassesAO.metaElement.class);
						   selectext.setAttribute('class', ClassesAO.multiselect.text.container.class);
						   selectext.setAttribute('data-id', id);
						   var elSelector = "[data-id='"+id+"']";
						   var addScript = 'document.querySelector("'+elSelector+'").onclick =  function(e){e.stopPropagation(); if(this.nextSibling.classList.contains(ClassesAO.activeClass)){this.nextSibling.classList.remove(ClassesAO.activeClass);}else{this.nextSibling.classList.add(ClassesAO.activeClass);}};';
						   TempListener.push(addScript);
						   var textContainerOptions = document.createElement(ClassesAO.metaElement.class);
						   textContainerOptions.setAttribute("class", ClassesAO.multiselect.text.options.container.class);
						   textContainerOptions.setAttribute('placeholder', form.label);
						   var idContainerOptionSelected = guidGenerator();
						   textContainerOptions.setAttribute("data-id", idContainerOptionSelected); 
						   selectext.appendChild(textContainerOptions);
						   var optionContainer = document.createElement(ClassesAO.metaElement.class);
						   optionContainer.setAttribute('class', ClassesAO.multiselect.options.container.class);
						   var options = form.values;
						   for (var i = 0; i < options.length; i++){
						   		var idOption = guidGenerator();
						   		var optionElement = document.createElement(ClassesAO.metaElement.class);
						   		optionElement.setAttribute('class',ClassesAO.multiselect.options.option.class);
						   		optionElement.innerText = options[i].label;
						   		optionElement.setAttribute('value',options[i].value);
						   		optionElement.setAttribute('data-id',idOption);
						   		var elSelectorOption = "[data-id='"+idOption+"']";
						   		var addScript = `
									document.querySelector("`+elSelectorOption+`").onclick = function(e) {
										e.stopPropagation();
										if (!this.classList.contains(ClassesAO.activeClass)) { 
											this.classList.add(ClassesAO.activeClass);
											var newOption = document.createElement(ClassesAO.metaElement.class);
									        newOption.setAttribute("class", ClassesAO.multiselect.text.options.option.class);
									        newOption.setAttribute("data-id-option", "`+idOption+`");
									        newOption.innerText = this.innerText;
									        addListenerOptionsMultiSelect();
									        document.querySelector('[data-id="`+idContainerOptionSelected+`"]').appendChild(newOption);
									        AOFormData[`+increment+`]["`+form.name+`"].push(this.getAttribute("value")); 
									    } else {
									    	this.classList.remove(ClassesAO.activeClass);
									    	var id_option = '[data-id-option="'+this.getAttribute('data-id')+'"]';
									    	function listenerOption(selector){
												var selectOption = document.querySelector(id_option);
											    selectOption.remove();
									    	};
									    	listenerOption();
									    	AOFormData[`+increment+`]["`+form.name+`"].pop(this.getAttribute("value"));
									    }
									  	document.querySelector("`+elSelector+`").click(); 
									};
						   		`;
						   		TempListener.push(addScript);
						   		optionContainer.appendChild(optionElement);
						   }
						   tag.appendChild(selectext);
						   tag.appendChild(optionContainer);
						   var data = '{"'+form.name+'": []}';
						   AOFormData.push(JSON.parse(data));
						   callback(tag);
			break;
		case 'searchselect': tag.setAttribute('class',ClassesAO.searchselect.container.class);
						   tag.setAttribute('name',form.name);
						   var selectext = document.createElement(ClassesAO.metaElement.class);
						   selectext.setAttribute('class', ClassesAO.searchselect.text.container.class);
						   selectext.setAttribute('data-id', id);
						   var elSelector = "[data-id='"+id+"']";
						   var addScript = 'document.querySelector("'+elSelector+'").onclick =  function(e){e.stopPropagation(); if(this.nextSibling.classList.contains(ClassesAO.activeClass)){this.nextSibling.classList.remove(ClassesAO.activeClass);}else{this.nextSibling.classList.add(ClassesAO.activeClass);}};';
						   TempListener.push(addScript);
						   var textContainerOptions = document.createElement(ClassesAO.metaElement.class);
						   textContainerOptions.setAttribute("class", ClassesAO.searchselect.text.options.container.class);
						   textContainerOptions.setAttribute('placeholder', form.label);
						   var idContainerOptionSelected = guidGenerator();
						   textContainerOptions.setAttribute("data-id", idContainerOptionSelected); 
						   selectext.appendChild(textContainerOptions);
						   var optionContainer = document.createElement(ClassesAO.metaElement.class);
						   optionContainer.setAttribute('class', ClassesAO.searchselect.options.container.class);
						   var options = form.values;
						   var searchContainer = document.createElement(ClassesAO.metaElement.class);
						   searchContainer.setAttribute('class', ClassesAO.searchselect.options.search.container.class);
						   var searchTextarea = document.createElement(ClassesAO.metaElement.class);
						   searchTextarea.setAttribute('class', ClassesAO.searchselect.options.search.textarea.class);
						   searchTextarea.setAttribute('placeholder', ClassesAO.searchselect.options.search.textarea.placeholder);
						   searchTextarea.setAttribute('contenteditable', '');
						   var idsearchTextArea = guidGenerator();
						   searchTextarea.setAttribute('id-option', idsearchTextArea);
						   searchContainer.appendChild(searchTextarea);
						   optionContainer.appendChild(searchContainer);
						   for (var i = 0; i < options.length; i++){
						   		var idOption = guidGenerator();
						   		var optionElement = document.createElement(ClassesAO.metaElement.class);
						   		optionElement.setAttribute('class',ClassesAO.searchselect.options.option.class);
						   		optionElement.innerText = options[i].label;
						   		optionElement.setAttribute('value',options[i].value);
						   		optionElement.setAttribute('data-id',idOption);
						   		var elSelectorOption = "[data-id='"+idOption+"']";
						   		var addScript = `
									document.querySelector("`+elSelectorOption+`").onclick = function(e) {
										e.stopPropagation();
										if (!this.classList.contains(ClassesAO.activeClass)) { 
											this.classList.add(ClassesAO.activeClass);
											var newOption = document.createElement(ClassesAO.metaElement.class);
									        newOption.setAttribute("class", ClassesAO.searchselect.text.options.option.class);
									        newOption.setAttribute("data-id-option", "`+idOption+`");
									        newOption.innerText = this.innerText;
									        addListenerOptionsMultiSelect();
									        document.querySelector('[data-id="`+idContainerOptionSelected+`"]').appendChild(newOption);
									        AOFormData[`+increment+`]["`+form.name+`"].push(this.getAttribute("value")); 
									    } else {
									    	this.classList.remove(ClassesAO.activeClass);
									    	var id_option = '[data-id-option="'+this.getAttribute('data-id')+'"]';
									    	function listenerOption(selector){
												var selectOption = document.querySelector(id_option);
											    selectOption.remove();
									    	};
									    	listenerOption();
									    	AOFormData[`+increment+`]["`+form.name+`"].pop(this.getAttribute("value"));
									    }
									  	document.querySelector("`+elSelector+`").click(); 
									};
						   		`;
						   		TempListener.push(addScript);
						   		optionContainer.appendChild(optionElement);
						   }
						   tag.appendChild(selectext);
						   tag.appendChild(optionContainer);
						   var data = '{"'+form.name+'": []}';
						   AOFormData.push(JSON.parse(data));
						   callback(tag);
			break;
	}
	increment++;
};

function loadEvents(){
	var script = document.createElement('script');
	script.setAttribute('id','aoform-dynamic-script');
	for (var i = 0; i < TempListener.length; i++) {
		script.innerHTML = script.innerHTML + TempListener[i];
	}
	document.querySelector('body').appendChild(script);
}

//Array with data form
var AOFormData = [];

//Classes CSS of form
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
	},
	textarea: {
		class: 'aoform-textarea'
	},
	select: {
		container: {
			class: 'aoform-select-container'
		},
		text: {
			class: 'aoform-text-select',
			notEmpty: 'aoform-selected'
		},
		options: {
			container: {
				class: 'aoform-option-select'
			},
			option: {
				class: 'aoform-option'
			}
		}
	},
	radio: {
		container: {
			class: 'aoform-radio-container'
		},
		option: {
			class: 'aoform-radio'
		}
	},
	checkbox: {
		container: {
			class: 'aoform-checkbox-container'
		},
		option: {
			class: 'aoform-checkbox'
		}
	},
	multiselect: {
		container: {
			class: 'aoform-multiple-select'
		},
		text: {
			container: {
				class: 'aoform-text-select aoform-options-selected'
			},
			options: {
				container: {
					class: 'aoform-multiple-selected-option'
				},
				option: {
					class: 'aoform-select-option'
				}
			}
		},
		options: {
			container: {
				class: 'aoform-option-select'
			},
			option: {
				class: 'aoform-option'
			}
		}
	},
	searchselect: {
		container: {
			class: 'aoform-multiple-select'
		},
		text: {
			container: {
				class: 'aoform-text-select aoform-options-selected'
			},
			options: {
				container: {
					class: 'aoform-multiple-selected-option'
				},
				option: {
					class: 'aoform-select-option'
				}
			}
		},
		options: {
			container: {
				class: 'aoform-option-select'
			},
			option: {
				class: 'aoform-option'
			},
			search:{
				container: {
					class: 'aoform-container-search'
				},
				textarea: {
					class: 'aoform-text-search',
					placeholder: 'Type for search...'
				}
			}
		}
	},
	title:{
		class: 'aoform-title'
	},
	subtitle:{
		class: 'aoform-subtitle'
	},
	activeClass: 'aoform-active',
};

const TempListener = [];

//Function for create click event listener options added to multiselect element
function addListenerOptionsMultiSelect(){
	var optionsBtn = document.querySelectorAll(ClassesAO.multiselect.text.options.option.class);
	var elScript = document.querySelector('#aoform-dynamic-script');
	for (var i = 0; i < optionsBtn.length; i++) {
		elScript.innerHTML += optionsBtn[i]+`.addEventListener('click', function(event) {
				event.cancelBubble = true;
		  		var selector = '[data-id="'+this.getAttribute('data-id-option')+'"]';
		    	document.querySelectorAll(selector).classList.remove(ClassesAO.activeClass);
		    	this.remove();
			});
		`;
	}
}