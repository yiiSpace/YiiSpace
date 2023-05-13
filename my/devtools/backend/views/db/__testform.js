// Configuration that can live anywhere, but must be passed to the form builder
var configuration = {
  title: "Example form",
  action: "/replace/this/url",
  method: "post",
  onValidSubmit: function (formState) {console.error('YAY a success!!', formState)}, // note: this is just a hook into the valid submit if you do not want to specify an action
  inputs: [
    {
      title: "Example User Name",
      id: "user-input",
      placeholder: "user name",
      subtext: 'this is a desc for the input',
      type: "text",
      validators: ['required']
    },
    {
      type: "header",
      text: "First form section"
    },
    {
      title: "Example Phone Number",
      id: "phone-input",
      placeholder: "123-456-7890",
      subtext: 'this is a desc for the input',
      type: "phone",
      validators: ['phone']
    },
    {
      title: "Example Email",
      id: "email-input",
      placeholder: "example@email.com",
      subtext: 'this is a desc for the input',
      type: "email",
      validators: ['email']
    },
    {
      title: "Example Password",
      id: "password-input",
      placeholder: "Password",
      type: "password",
      validators: ['required']
    },
    {
      type: "header",
      text: "Second form section"
    },
    {
      title: "Example Select Dropdown",
      id: "select-input",
      type: "select",
      options: [
        {text: "option 1", value: "value_1"},
        {text: "option 2", value: "value_2"},
        {text: "option 3", value: "value_3"},
        {text: "option 4", value: "value_4"}
      ],
      validators: ['required']
    },
    {
      title: "Example Radio buttons",
      id: "radio-input",
      type: "radio",
      options: [
        {text: "radio 1", value: "radio_1"},
        {text: "radio 2", value: "radio_2"},
        {text: "radio 3", value: "radio_3"},
        {text: "radio 4", value: "radio_4"}
      ],
      validators: ['required']
    },
        {
      title: "Example Checkbox",
      id: "check-input",
      type: "checkbox",
      options: [
        {text: "check 1", value: "check_1"},
        {text: "check 2", value: "check_2"},
        {text: "check 3", value: "check_3"},
        {text: "check 4", value: "check_4"}
      ]
    },
  ]
};

// Code run when the page is ready
$(document).ready(function () {
  formBuilder.buildForm('form-container', configuration);
})

var formBuilder = (function () {
  // ****************************
  // ***** VALIDATION LOGIC *****
  // ****************************
  var errorStrings = {
    required: 'Field is required',
    email: 'Please enter a valid email',
    phone: 'Please enter a valid phone number',
  };
  var regexValues = {
    email: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
    phone: /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/
  };
  var fieldValidators = {
    required: requiredValidator,
    email: regexValidatorById.bind(null, 'email'),
    phone: regexValidatorById.bind(null, 'phone')
  };

  function requiredValidator (value) {
    return (value) ? null : errorStrings.required;
  }

  function regexValidatorById (id, textValue) {
    return (regexValues[id].test(textValue)) ? null : errorStrings[id];
  }

  // ******************************************
  // ***** LOGIC TO BUILD AND MANAGE FORM *****
  // ******************************************
  function buildForm (containerId, config) {
    var formState = getInitialFormState(config.inputs);
    var formValidators = getFormValidators(config.inputs);
    var formErrors = {};

    function getInitialFormState (inputs) {
      return inputs.reduce(function (state, config) {
        state[config.id] = config.defaultValue;

        return state;
      }, {});
    }

    function getFormValidators (inputs) {
      return inputs.reduce(function (formValidators, config) {
        var validators = config.validators;

        if (validators && validators.length) {
          formValidators[config.id] = validators;
        }

        return formValidators;
      }, {});
    };

    function renderForm () {
      var $form = $('<form class="form-builder-content"></form>')
        .prop({
          action: config.action,
          method: config.method
        })
        .append(renderTitle(config.title))
        .append(config.inputs.map(renderInput))
        .append(renderSubmitButton(config.submitText));

      $(`#${containerId}`).html($form);
    }

    function renderTitle (title) {
      return (title) ? `<h2>${title}</h2>` : '';
    }

    function renderInput (config) {
      var renderMethods = {
        text: renderTextInput,
        select: renderOptionsInput,
        radio: renderRadioInput,
        checkbox: renderRadioInput,
        header: renderSectionHeader
      };
      var renderMethod = renderMethods[config.type] || renderMethods.text;

      return renderMethod(config);
    }

    function renderTextInput (config) {
      var input = `<input type="${config.type}" class="form-control" id="${config.id}" placeholder="${config.placeholder}" />`;

      return renderFormGroup(input, config);
    }

    function renderOptionsInput (config) {
      var options = config.options.map(function (option) {
        return `<option value="${option.value}">${option.text}</option>`;
      }).join('');
      var select = `<select id="${config.id}" class="form-control">${options}</select>`;

      return renderFormGroup(select, config);
    }

    function renderFormGroup (input, config) {
      return `
        <div class="form-group">
          <label for="${config.id}">${config.title}</label>
          ${input}
          ${renderError()}
          ${renderSubtext(config.subtext)}
        </div>
      `;
    }

    function renderRadioInput (config, index) {
      var radios = config.options.map(function (item, index, array) {
        var errors = (array.length - 1 === index) ? renderError() : '';

        return `
          <div class="form-check">
            <input class="form-check-input" type="${config.type}" id="${config.id + index}" name="${config.id}" value="${item.value}">
            <label class="form-check-label" for="${config.id + index}">${item.text}</label>
             ${errors}
          </div>
        `;
      }).join('');

      return `
        <fieldset class="form-group" id="${config.id}">
          <div>${config.title}</div>
          ${radios}
        </fieldset>
      `;
    }

    function renderError () {
      return  `<div class="form-error-text invalid-feedback"></div>`;
    }

    function renderSubtext (text) {
      return (text) ? `<small class="form-text text-muted">${text}</small>` : '';
    }

    function renderSubmitButton (text) {
      return `<div class="text-right"><button class="btn btn-primary form-submit-button" type="submit">${text || 'Submit'}</button></div>`;
    }

    function renderSectionHeader (config) {
      return `<h4>${config.text}</h4>`;
    }

    function addEventHandlers () {
      $(`#${containerId}`)
        .on('focusout', '.form-control', handleInputChange)
        .on('change', '.form-check-input', handleCheckboxChange)
        .on('click', '.form-submit-button', handleSubmit);
    }

    function handleInputChange (event) {
      updateInputAndValidate(event.target.id, event.target.value);
    }

    function handleCheckboxChange (event) {
      updateInputAndValidate(event.target.name, event.target.value);
    }

    function updateInputAndValidate (id, value) {
      formState[id] = value;
      validateField(id);
      updateWithErrors();
    }

    function handleSubmit (event) {
      validateAll();

      if (!isFormValid()) {
        event.preventDefault();
        updateWithErrors();
      } else {
        config.onValidSubmit && config.onValidSubmit(formState);
      }
    }

    function isFormValid () {
      var valid = true;

      Object.keys(formState).map(function (id) {
        if (formErrors[id]) {
          valid = false;
        }
      });

      return valid;
    }

    function validateAll () {
      Object.keys(formState).map(validateField);
    }

    function validateField (id) {
      var validatorList = formValidators[id] || [];

      validatorList.map(function (validatorKey) {
        var validator = fieldValidators[validatorKey];

        if (validator) {
          formErrors[id] = validator(formState[id]);
        }
      });
    }

    function updateWithErrors () {
      Object.keys(formState).map(function (inputId) {
        var error = formErrors[inputId];
        var invalidClass = 'is-invalid';
        var errorSelector = '.form-error-text';
        var checkSelector = '.form-check-input';
        var classMethod = (error) ? 'addClass' : 'removeClass';
        var $input =$(`#${inputId}`);
        var $checkboxes = $input.find(checkSelector);
        var $error = ($checkboxes.length) ?  $input.find(errorSelector) : $input.parent().find(errorSelector);

        $input[classMethod](invalidClass);
        $checkboxes[classMethod](invalidClass);
        $error.html(error);
      });
    }

    (function init () {
      renderForm();
      addEventHandlers();
    }());
  }

  // *************************
  // **** PUBLIC METHODS *****
  // *************************
  return {
    buildForm: buildForm
  };
}());