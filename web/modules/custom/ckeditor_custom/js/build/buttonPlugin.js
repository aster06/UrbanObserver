!function(e,t){"object"==typeof exports&&"object"==typeof module?module.exports=t():"function"==typeof define&&define.amd?define([],t):"object"==typeof exports?exports.CKEditor5=t():(e.CKEditor5=e.CKEditor5||{},e.CKEditor5.buttonPlugin=t())}(self,(()=>(()=>{var __webpack_modules__={"./js/ckeditor5_plugins/buttonPlugin/src/button.js":(__unused_webpack_module,__webpack_exports__,__webpack_require__)=>{"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   "default": () => (/* binding */ Button)\n/* harmony export */ });\n/* harmony import */ var _buttonediting__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./buttonediting */ "./js/ckeditor5_plugins/buttonPlugin/src/buttonediting.js");\n/* harmony import */ var ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ckeditor5/src/core */ "ckeditor5/src/core.js");\n/* harmony import */ var _buttonui_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./buttonui.js */ "./js/ckeditor5_plugins/buttonPlugin/src/buttonui.js");\n\n\n\n\nclass Button extends ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_1__.Plugin {\n  static get requires() {\n    return [ _buttonediting__WEBPACK_IMPORTED_MODULE_0__["default"], _buttonui_js__WEBPACK_IMPORTED_MODULE_2__["default"] ];\n  }\n}\n\n\n//# sourceURL=webpack://CKEditor5.buttonPlugin/./js/ckeditor5_plugins/buttonPlugin/src/button.js?')},"./js/ckeditor5_plugins/buttonPlugin/src/buttonconfig.js":(__unused_webpack_module,__webpack_exports__,__webpack_require__)=>{"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   colorOptions: () => (/* binding */ colorOptions),\n/* harmony export */   defaultSize: () => (/* binding */ defaultSize),\n/* harmony export */   sizeOptions: () => (/* binding */ sizeOptions),\n/* harmony export */   textColorOptions: () => (/* binding */ textColorOptions),\n/* harmony export */   textDefaultColor: () => (/* binding */ textDefaultColor)\n/* harmony export */ });\n/* harmony import */ var ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ckeditor5/src/core */ \"ckeditor5/src/core.js\");\n\n\nconst sizeOptions = {\n  large: {\n    label: 'Large',\n    icon: ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_0__.icons.large,\n    className: 'cke-large'\n  },\n  regular: {\n    label: 'Regular',\n    icon: ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_0__.icons.regular,\n    className: 'cke-regular'\n  },\n  small: {\n    label: 'Small',\n    icon: ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_0__.icons.small,\n    className: 'cke-small'\n  },\n};\n\nconst defaultSize = 'regular';\n\nconst colorOptions = {\n  blue: {\n    label: 'Blue',\n    className: 'ucb-link-button-blue'\n  },\n  black: {\n    label: 'Black',\n    className: 'ucb-link-button-black'\n  },\n  gray: {\n    label: 'Gray',\n    className: 'ucb-link-button-gray'\n  },\n  white: {\n    label: 'White',\n    className: 'ucb-link-button-white'\n  },\n  gold: {\n    label: 'Gold',\n    className: 'ucb-link-button-gold'\n  }\n};\n\nconst textColorOptions = {\n  blue: {\n    label: 'Blue',\n    className: 'ucb-text-link-button-blue'\n  },\n  black: {\n    label: 'Black',\n    className: 'ucb-text-link-button-black'\n  },\n  gray: {\n    label: 'Gray',\n    className: 'ucb-text-link-button-gray'\n  },\n  white: {\n    label: 'White',\n    className: 'ucb-text-link-button-white'\n  },\n  gold: {\n    label: 'Gold',\n    className: 'ucb-text-link-button-gold'\n  }\n};\n\nlet textDefaultColor = 'black';\n\n\n//# sourceURL=webpack://CKEditor5.buttonPlugin/./js/ckeditor5_plugins/buttonPlugin/src/buttonconfig.js?")},"./js/ckeditor5_plugins/buttonPlugin/src/buttonediting.js":(__unused_webpack_module,__webpack_exports__,__webpack_require__)=>{"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ ButtonEditing)\n/* harmony export */ });\n/* harmony import */ var ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ckeditor5/src/core */ \"ckeditor5/src/core.js\");\n/* harmony import */ var _insertbuttoncommand__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./insertbuttoncommand */ \"./js/ckeditor5_plugins/buttonPlugin/src/insertbuttoncommand.js\");\n/* harmony import */ var ckeditor5_src_widget__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ckeditor5/src/widget */ \"ckeditor5/src/widget.js\");\n/* harmony import */ var _buttonconfig__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./buttonconfig */ \"./js/ckeditor5_plugins/buttonPlugin/src/buttonconfig.js\");\n/**\n * @file defines schemas, converters, and commands for the button plugin.\n *\n * @typedef { import('@ckeditor/ckeditor5-engine').DowncastWriter } DowncastWriter\n * @typedef { import('@ckeditor/ckeditor5-engine/src/view/containerelement').default } ContainerElement\n */\n\n\n\n\n\n\nclass ButtonEditing extends ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_0__.Plugin {\n  static get requires() {\n    return [ckeditor5_src_widget__WEBPACK_IMPORTED_MODULE_2__.Widget];\n  }\n\n  init() {\n    this._defineSchema();\n    this._defineConverters();\n    this.editor.commands.add('addButton', new _insertbuttoncommand__WEBPACK_IMPORTED_MODULE_1__[\"default\"](this.editor));\n  }\n\n  // Schemas are registered via the central `editor` object.\n  _defineSchema() {\n    const schema = this.editor.model.schema;\n    schema.register('linkButton', {\n      allowWhere: '$text',\n      isObject: true,\n      isInline: true,\n      allowAttributes: ['linkButtonColor', 'linkButtonSize', 'linkButtonHref', 'linkButtonText']\n    });\n    schema.register('linkButtonContents', {\n      isLimit: true,\n      allowIn: 'linkButton',\n      allowContentOf: '$block'\n    });\n    schema.addChildCheck((context, childDefinition) => {\n      // Disallows adding a linkButton inside linkButtonContents.\n      if (context.endsWith('linkButtonContents') && childDefinition.name === 'linkButton')\n        return false;\n    });\n  }\n\n  _defineConverters() {\n    // Converters are registered via the central editor object.\n    const { conversion } = this.editor;\n\n    // Attributes convertable to/from a class name need no separate upcast and downcast definitions\n    conversion.attributeToAttribute(buildAttributeToAttributeDefinition('linkButtonColor', _buttonconfig__WEBPACK_IMPORTED_MODULE_3__.colorOptions));\n    conversion.attributeToAttribute(buildAttributeToAttributeDefinition('linkButtonSize', _buttonconfig__WEBPACK_IMPORTED_MODULE_3__.sizeOptions));\n    conversion.attributeToAttribute(buildAttributeToAttributeDefinition('linkButtonText', _buttonconfig__WEBPACK_IMPORTED_MODULE_3__.textColorOptions));\n\n    // Element upcasts\n    conversion.for('upcast').add(dispatcher => {\n      // A custom upcast prevents the CKEditor 5 Link plugin from overriding via its `linkHref` attribute `$text` element.\n      dispatcher.on('element:a', (evt, data, conversionApi) => {\n        if (conversionApi.consumable.consume(data.viewItem, { name: true, classes: 'ucb-link-button', attributes: ['href'] })) {\n          const linkButton = conversionApi.writer.createElement('linkButton', { linkButtonHref: data.viewItem.getAttribute('href') });\n          // Forces insertion and conversion of a clean `linkButton` element.\n          if (!conversionApi.safeInsert(linkButton, data.modelCursor))\n            return;\n          conversionApi.convertChildren(data.viewItem, linkButton);\n          conversionApi.updateConversionResult(linkButton, data); // Omitting this line causes strange issues (trust me).\n        }\n      });\n    });\n    conversion.for('upcast').elementToElement({\n      model: 'linkButtonContents',\n      view: {\n        name: 'span',\n        classes: 'ucb-link-button-contents'\n      }\n    });\n\n    // Attribute downcasts\n    conversion.for('downcast').attributeToAttribute({ model: 'linkButtonHref', view: 'href' });\n\n    // Element downcasts – elements become widgets in the editor via `editingDowncast`\n    conversion.for('dataDowncast').elementToElement({\n      model: 'linkButton',\n      view: {\n        name: 'a',\n        classes: 'ucb-link-button'\n      }\n    });\n    conversion.for('dataDowncast').elementToElement({\n      model: 'linkButtonContents',\n      view: {\n        name: 'span',\n        classes: 'ucb-link-button-contents'\n      }\n    });\n    conversion.for('editingDowncast').elementToElement({\n      model: 'linkButton',\n      view: (modelElement, { writer }) =>\n        (0,ckeditor5_src_widget__WEBPACK_IMPORTED_MODULE_2__.toWidget)(\n          writer.createContainerElement('a', { class: 'ucb-link-button', onclick: 'event.preventDefault()' }, { renderUnsafeAttributes: ['onclick'] }),\n          writer, { label: 'button widget' }\n        )\n    });\n    conversion.for('editingDowncast').elementToElement({\n      model: 'linkButtonContents',\n      view: (modelElement, { writer }) =>\n        (0,ckeditor5_src_widget__WEBPACK_IMPORTED_MODULE_2__.toWidgetEditable)(writer.createEditableElement('span', { class: 'ucb-link-button-contents' }), writer)\n    });\n  }\n}\n\nfunction buildAttributeToAttributeDefinition(attributeName, attributeOptions) {\n  const view = {};\n  for (const [name, option] of Object.entries(attributeOptions))\n    view[name] = { key: 'class', value: option.className };\n  return {\n    model: {\n      key: attributeName,\n      values: Object.keys(attributeOptions)\n    },\n    view\n  };\n}\n\n\n//# sourceURL=webpack://CKEditor5.buttonPlugin/./js/ckeditor5_plugins/buttonPlugin/src/buttonediting.js?")},"./js/ckeditor5_plugins/buttonPlugin/src/buttonui.js":(__unused_webpack_module,__webpack_exports__,__webpack_require__)=>{"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ ButtonUI)\n/* harmony export */ });\n/* harmony import */ var ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ckeditor5/src/core */ \"ckeditor5/src/core.js\");\n/* harmony import */ var ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ckeditor5/src/ui */ \"ckeditor5/src/ui.js\");\n/* harmony import */ var _buttonview__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./buttonview */ \"./js/ckeditor5_plugins/buttonPlugin/src/buttonview.js\");\n/* harmony import */ var _icons_simpleBox_svg__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../icons/simpleBox.svg */ \"./icons/simpleBox.svg\");\n\n\n\n\n\nclass ButtonUI extends ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_0__.Plugin {\n  static get requires() {\n    return [ ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_1__.ContextualBalloon ];\n  }\n  static get pluginName(){\n    return 'ButtonUI'\n  }\n\n  init() {\n    const editor = this.editor;\n    const componentFactory = editor.ui.componentFactory;\n    const insertButtonCommand = editor.commands.get('addButton')\n    const viewDocument = editor.editing.view.document;\n\n    // Create the balloon and the form view.\n    this._balloon = this.editor.plugins.get( ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_1__.ContextualBalloon );\n    this.formView = this._createFormView(editor.locale);\n    this.buttonView = null;\n\n    componentFactory.add( 'button', (locale) => {\n      const button = new ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_1__.ButtonView(locale);\n\n      button.label = 'Button';\n      button.icon = _icons_simpleBox_svg__WEBPACK_IMPORTED_MODULE_3__[\"default\"];\n      button.tooltip = true;\n      button.withText = false;\n      button.isToggleable = true;\n      // Show the UI on button click.\n      this.listenTo( button, 'execute', () => {\n        this._showUI(insertButtonCommand.existingButtonSelected)\n      } );\n\n      this.buttonView = button;\n\n      // Show the on/off in Toolbar if a button is already selected.\n      const updateButtonState = () => {\n        const linkButtonSelected = insertButtonCommand.existingButtonSelected;\n        button.isOn = !!linkButtonSelected;\n      };\n\n      // Listen for changes in the linkButton selection.\n      this.listenTo(insertButtonCommand, 'change:value', updateButtonState);\n      this.listenTo(insertButtonCommand, 'change:existingButtonSelected', updateButtonState);\n\n      // Shows the UI on click of a button widget.\n      this.listenTo(viewDocument, 'click', () => {\n        if (insertButtonCommand.existingButtonSelected)\n          this._showUI(insertButtonCommand.existingButtonSelected);\n      });\n\n      this.on('showUI', (eventInfo, newButton) => {\n        this._showUI(newButton)\n      });\n\n      // Bind the state of the button to the command.\n      button.bind('isOn', 'isEnabled').to(insertButtonCommand, 'value', 'isEnabled');\n\n      return button;\n    } );\n  }\n\n  _createFormView(locale) {\n    const editor = this.editor;\n    const componentFactory = editor.ui.componentFactory;\n    const formView = new _buttonview__WEBPACK_IMPORTED_MODULE_2__[\"default\"]( locale, componentFactory, editor.config.get('default_color'));\n\n\n    // Execute the command after clicking the \"Save\" button.\n    this.listenTo( formView, 'submit', () => {\n      // Grab values from the Form and title input fields.\n      const value = {\n        href: formView.linkInputView.fieldView.element.value,\n        color: formView.color,\n        size: formView.size,\n        text: formView.text,\n      };\n      editor.execute( 'addButton', value );\n\n      // Hide the form view after submit.\n      this._hideUI();\n    } );\n\n    // Hide the form view after clicking the \"Cancel\" button.\n    this.listenTo( formView, 'cancel', () => {\n      this._hideUI();\n    } );\n\n    // Close the panel on esc key press when the form has focus.\n    formView.keystrokes.set('Esc', (data, cancel) => {\n      this._hideUI();\n      cancel();\n    });\n\n    // Hide the form view when clicking outside the balloon.\n    (0,ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_1__.clickOutsideHandler)( {\n      emitter: formView,\n      activator: () => this._balloon.visibleView === formView,\n      contextElements: [ this._balloon.view.element ],\n      callback: () => this._hideUI()\n    } );\n\n    return formView;\n  }\n\n  _showUI(selectedButton) {\n    this.buttonView.isOn = true;\n\n    // If there's an existing balloon open, close it!\n    if (this._balloon.visibleView) {\n      this._hideUI();\n    }\n\n    // Check the value of the command.\n    const commandValue = this.editor.commands.get( 'addButton' ).value;\n\n    this._balloon.add( {\n      view: this.formView,\n      position: this._getBalloonPositionData()\n    } );\n\n    if (selectedButton) {\n      const size = selectedButton.getAttribute('linkButtonSize');\n      const color = selectedButton.getAttribute('linkButtonColor');\n      const href = selectedButton.getAttribute('linkButtonHref');\n      const text = selectedButton.getAttribute('linkButtonText');\n\n      this.formView.color = color;\n      this.formView.size = size;\n      this.formView.text = text;\n\n      this.formView.linkInputView.fieldView.value = href;\n      this.formView.linkInputView.fieldView.element.value = href;\n      this.formView.linkInputView.fieldView.set('value', href);\n    }\n\n    // Fill the form using the state (value) of the command.\n    if ( commandValue ) {\n      this.formView.linkInputView.fieldView.value = commandValue.link;\n      this.formView.colorDropdown.fieldView.value = commandValue.color;\n      this.formView.sizeDropdown.fieldView.value = commandValue.size;\n      this.formView.textDropdown.fieldView.value = commandValue.text;\n    }\n    setTimeout(() => {\n      this.formView.linkInputView.fieldView.focus();\n    }, 0);\n  }\n  _hideUI() {\n    // Case for if user is rapidly clicking add button to button group\n    if (!this._balloon.hasView(this.formView)) {\n      return; // If the formView isn't in the balloon, do nothing\n    }\n    // Clear the input field values and reset the form.\n    this.formView.element.reset();\n    this.buttonView.isOn = false;\n\n    this._balloon.remove( this.formView );\n\n    // Focus the editing view after inserting the tooltip so the user can start typing the content\n    // right away and keep the editor focused.\n    this.editor.editing.view.focus();\n  }\n\n  _getBalloonPositionData() {\n    const view = this.editor.editing.view;\n    const viewDocument = view.document;\n    let target = null;\n\n    // Set a target position by converting view selection range to DOM\n    target = () => view.domConverter.viewRangeToDom( viewDocument.selection.getFirstRange() );\n\n    return {\n      target\n    };\n  }\n}\n\n\n//# sourceURL=webpack://CKEditor5.buttonPlugin/./js/ckeditor5_plugins/buttonPlugin/src/buttonui.js?")},"./js/ckeditor5_plugins/buttonPlugin/src/buttonview.js":(__unused_webpack_module,__webpack_exports__,__webpack_require__)=>{"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ FormView)\n/* harmony export */ });\n/* harmony import */ var ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ckeditor5/src/ui */ \"ckeditor5/src/ui.js\");\n/* harmony import */ var ckeditor5_src_utils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ckeditor5/src/utils */ \"ckeditor5/src/utils.js\");\n/* harmony import */ var ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ckeditor5/src/core */ \"ckeditor5/src/core.js\");\n/* harmony import */ var _icons_paint_svg__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../icons/paint.svg */ \"./icons/paint.svg\");\n/* harmony import */ var _icons_text_color_svg__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../../../icons/text-color.svg */ \"./icons/text-color.svg\");\n/* harmony import */ var _buttonconfig__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./buttonconfig */ \"./js/ckeditor5_plugins/buttonPlugin/src/buttonconfig.js\");\n\n\n\n\n\n\n\n\nclass FormView extends ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_0__.View {\n  constructor( locale, componentFactory, defaultColor) {\n    super( locale);\n    this.focusTracker = new ckeditor5_src_utils__WEBPACK_IMPORTED_MODULE_1__.FocusTracker();\n    this.keystrokes = new ckeditor5_src_utils__WEBPACK_IMPORTED_MODULE_1__.KeystrokeHandler();\n\n    //let textDefaultColor = drupalSettings.ckeditor_custom_button.default_color;\n\n    // Creates Dropdowns for Color, Size, Text color\n    this.colorDropdown = this._createSelectionDropdown(locale, 'Color', _icons_paint_svg__WEBPACK_IMPORTED_MODULE_3__[\"default\"], 'color', _buttonconfig__WEBPACK_IMPORTED_MODULE_5__.colorOptions, defaultColor)\n    this.sizeDropdown = this._createSelectionDropdown(locale, 'Size', _buttonconfig__WEBPACK_IMPORTED_MODULE_5__.sizeOptions[_buttonconfig__WEBPACK_IMPORTED_MODULE_5__.defaultSize].icon, 'size', _buttonconfig__WEBPACK_IMPORTED_MODULE_5__.sizeOptions, _buttonconfig__WEBPACK_IMPORTED_MODULE_5__.defaultSize )\n    this.textDropdown = this._createSelectionDropdown(locale, 'Text', _icons_text_color_svg__WEBPACK_IMPORTED_MODULE_4__[\"default\"], 'text', _buttonconfig__WEBPACK_IMPORTED_MODULE_5__.textColorOptions, _buttonconfig__WEBPACK_IMPORTED_MODULE_5__.textDefaultColor )\n    // Creates the main input field.\n    // this.innerTextInputView = this._createInput( 'Button Text' );\n    this.linkInputView = this._createInput( 'Add Link' );\n\n    // Sets defaults\n    this.set('size', _buttonconfig__WEBPACK_IMPORTED_MODULE_5__.defaultSize)\n    this.set('color', defaultColor)\n    this.set('text', _buttonconfig__WEBPACK_IMPORTED_MODULE_5__.textDefaultColor)\n    this.linkInputView.fieldView.bind('href').to(this, 'href');\n    this.set('href', '')\n\n    this.saveButtonView = this._createButton( 'Save', ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_2__.icons.check, 'ck-button-save' );\n\n    this.saveButtonView.type = 'submit';\n\n    this.cancelButtonView = this._createButton( 'Cancel', ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_2__.icons.cancel, 'ck-button-cancel' );\n\n    // Delegate ButtonView#execute to FormView#cancel.\n    this.cancelButtonView.delegate( 'execute' ).to( this, 'cancel' );\n\n    this.childViews = this.createCollection( [\n      this.sizeDropdown,\n      this.colorDropdown,\n      this.textDropdown,\n      // this.innerTextInputView,\n      this.linkInputView,\n      this.saveButtonView,\n      this.cancelButtonView\n    ] );\n\n    this._focusCycler = new ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_0__.FocusCycler( {\n      focusables: this.childViews,\n      focusTracker: this.focusTracker,\n      keystrokeHandler: this.keystrokes,\n      actions: {\n        // Navigate form fields backwards using the Shift + Tab keystroke.\n        focusPrevious: 'shift + tab',\n\n        // Navigate form fields forwards using the Tab key.\n        focusNext: 'tab'\n      }\n    } );\n\n    this.setTemplate( {\n      tag: 'form',\n      attributes: {\n        class: [ 'ck', 'ck-button-form' ],\n        tabindex: '-1'\n      },\n      children: this.childViews\n    } );\n  }\n\n  render() {\n    super.render();\n\n    (0,ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_0__.submitHandler)( {\n      view: this\n    } );\n\n    this.childViews._items.forEach( view => {\n      // Register the view in the focus tracker.\n      this.focusTracker.add( view.element );\n    } );\n\n    // Start listening for the keystrokes coming from #element.\n    this.keystrokes.listenTo( this.element );\n  }\n\n  destroy() {\n    super.destroy();\n\n    this.focusTracker.destroy();\n    this.keystrokes.destroy();\n  }\n\n  focus() {\n    // If the link text field is enabled, focus it straight away to allow the user to type.\n    if ( this.linkInputView.isEnabled ) {\n      this.linkInputView.focus();\n    }\n    // Focus the link text field if the former is disabled.\n    else {\n      this.linkInputView.focus();\n    }\n  }\n\n  _createInput( label ) {\n    const labeledInput = new ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_0__.LabeledFieldView( this.locale, ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_0__.createLabeledInputText );\n\n    labeledInput.label = label;\n\n    return labeledInput;\n  }\n\n  _createButton( label, icon, className ) {\n    const button = new ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_0__.ButtonView();\n\n    button.set( {\n      label,\n      icon,\n      tooltip: true,\n      class: className\n    } );\n\n    return button;\n  }\n\n  _createSelectionDropdown(locale, tooltip, icon, attribute, options, defaultValue) {\n    const dropdownView = (0,ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_0__.createDropdown)(locale), defaultOption = options[defaultValue];\n    (0,ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_0__.addToolbarToDropdown)(dropdownView, Object.entries(options).map(([optionValue, option]) => this._createSelectableButton(locale, option.label, option.icon, attribute, optionValue)));\n    dropdownView.buttonView.set({\n      icon,\n      tooltip: locale.t(tooltip),\n      withText: !icon\n    });\n    dropdownView.buttonView.bind('label').to(this, attribute, value => locale.t(options[value] ? options[value].label : defaultOption.label));\n    if (icon === options[defaultValue].icon) { // If the icon for the dropdown is the same as the icon for the default option, it changes to reflect the current selection.\n      dropdownView.buttonView.bind('icon').to(this, attribute, value => options[value] ? options[value].icon : defaultOption.icon);\n    }\n    return dropdownView;\n  }\n\n  _createSelectableButton(locale, label, icon, attribute, value) {\n    const buttonView = new ckeditor5_src_ui__WEBPACK_IMPORTED_MODULE_0__.ButtonView();\n    buttonView.set({\n      label: locale.t(label),\n      icon,\n      tooltip: !!icon, // Displays the tooltip on hover if there is an icon\n      isToggleable: true, // Allows the button with the attribute's current value to display as selected\n      withText: !icon // Displays the button as text if the icon is falsey\n    });\n    // Allows the button with the attribute's current value to display as selected\n    buttonView.bind('isOn').to(this, attribute, attributeValue => attributeValue === value);\n    // Sets the attribute to the button's value on click\n    this.listenTo(buttonView, 'execute', () => {\n      this.set(attribute, value);\n    });\n    return buttonView;\n  }\n}\n\n\n//# sourceURL=webpack://CKEditor5.buttonPlugin/./js/ckeditor5_plugins/buttonPlugin/src/buttonview.js?")},"./js/ckeditor5_plugins/buttonPlugin/src/index.js":(__unused_webpack_module,__webpack_exports__,__webpack_require__)=>{"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var _button__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./button */ "./js/ckeditor5_plugins/buttonPlugin/src/button.js");\n\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({\n  Button: _button__WEBPACK_IMPORTED_MODULE_0__["default"]\n});\n\n\n//# sourceURL=webpack://CKEditor5.buttonPlugin/./js/ckeditor5_plugins/buttonPlugin/src/index.js?')},"./js/ckeditor5_plugins/buttonPlugin/src/insertbuttoncommand.js":(__unused_webpack_module,__webpack_exports__,__webpack_require__)=>{"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ ButtonCommand)\n/* harmony export */ });\n/* harmony import */ var ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ckeditor5/src/core */ \"ckeditor5/src/core.js\");\n/* harmony import */ var _buttonconfig__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./buttonconfig */ \"./js/ckeditor5_plugins/buttonPlugin/src/buttonconfig.js\");\n/**\n * @file defines InsertButtonCommand, which is executed when the button toolbar button is pressed.\n */\n\n\n\n\nclass ButtonCommand extends ckeditor5_src_core__WEBPACK_IMPORTED_MODULE_0__.Command {\n  constructor(editor) {\n    super(editor);\n    this.set('existingButtonSelected', false);\n  }\n  execute({ value = '', size = _buttonconfig__WEBPACK_IMPORTED_MODULE_1__.defaultSize, color = defaultColor, text = _buttonconfig__WEBPACK_IMPORTED_MODULE_1__.textDefaultColor, href = '', classes = '' }) {\n    const model = this.editor.model;\n    const selection = model.document.selection;\n\n    model.change(writer => {\n      const range = selection.getFirstRange(),\n        linkButton = writer.createElement('linkButton', {\n          linkButtonColor: color,\n          linkButtonSize: size,\n          linkButtonHref: href,\n          linkButtonText: text\n        }),\n        linkButtonContents = writer.createElement('linkButtonContents');\n      for (const item of range.getItems()) {\n        let element;\n        if (item.is('textProxy'))\n          element = writer.createText(item.data, item.textNode.getAttributes());\n        else if (item.is('element'))\n          element = writer.cloneElement(item);\n        if (element && model.schema.checkChild(linkButtonContents, element))\n          writer.append(element, linkButtonContents);\n      }\n      writer.append(linkButtonContents, linkButton);\n      model.insertContent(linkButton);\n      writer.setSelection(linkButtonContents, 'in');\n    });\n  }\n\n  refresh() {\n    const model = this.editor.model;\n    const selection = model.document.selection;\n    const selectedElement = selection.getSelectedElement();\n\n    const allowedIn = model.schema.findAllowedParent(\n      selection.getFirstPosition(),\n      'linkButton'\n    );\n\n    this.isEnabled = allowedIn !== null;\n\n    this.existingButtonSelected = isButtonElement(selectedElement) ? selectedElement : null;\n  }\n}\n\n/**\n * @param {Element | null} element\n * @returns {boolean}\n */\nfunction isButtonElement(element) {\n  return element && element.name === 'linkButton';\n}\n\n\n//# sourceURL=webpack://CKEditor5.buttonPlugin/./js/ckeditor5_plugins/buttonPlugin/src/insertbuttoncommand.js?")},"./icons/paint.svg":(__unused_webpack_module,__webpack_exports__,__webpack_require__)=>{"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("<svg xmlns=\\"http://www.w3.org/2000/svg\\" viewBox=\\"0 0 384 512\\">\x3c!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. --\x3e<path d=\\"M162.4 6c-1.5-3.6-5-6-8.9-6h-19c-3.9 0-7.5 2.4-8.9 6L104.9 57.7c-3.2 8-14.6 8-17.8 0L66.4 6c-1.5-3.6-5-6-8.9-6H48C21.5 0 0 21.5 0 48V224v22.4V256H9.6 374.4 384v-9.6V224 48c0-26.5-21.5-48-48-48H230.5c-3.9 0-7.5 2.4-8.9 6L200.9 57.7c-3.2 8-14.6 8-17.8 0L162.4 6zM0 288v32c0 35.3 28.7 64 64 64h64v64c0 35.3 28.7 64 64 64s64-28.7 64-64V384h64c35.3 0 64-28.7 64-64V288H0zM192 432a16 16 0 1 1 0 32 16 16 0 1 1 0-32z\\"/></svg>\\n");\n\n//# sourceURL=webpack://CKEditor5.buttonPlugin/./icons/paint.svg?')},"./icons/simpleBox.svg":(__unused_webpack_module,__webpack_exports__,__webpack_require__)=>{"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("<svg width=\\"20\\" height=\\"20\\" viewBox=\\"0 0 20 20\\" fill=\\"none\\" xmlns=\\"http://www.w3.org/2000/svg\\"><path fill-rule=\\"evenodd\\" clip-rule=\\"evenodd\\" d=\\"M1.95154 2.84131C1.95154 2.28902 2.39925 1.84131 2.95154 1.84131H17.0484C17.6007 1.84131 18.0484 2.28902 18.0484 2.84131V17.1588C18.0484 17.7111 17.6007 18.1588 17.0484 18.1588H2.95154C2.39925 18.1588 1.95154 17.7111 1.95154 17.1588V2.84131ZM3.5116 8.10129H16.4926V15.3194C16.4926 15.8717 16.0449 16.3194 15.4926 16.3194H4.5116C3.95931 16.3194 3.5116 15.8717 3.5116 15.3194V8.10129ZM4.44415 3.81676C3.89187 3.81676 3.44415 4.26447 3.44415 4.81676V6.35087H16.4316V4.81676C16.4316 4.26447 15.9838 3.81676 15.4316 3.81676H4.44415Z\\" fill=\\"black\\"/></svg>\\n");\n\n//# sourceURL=webpack://CKEditor5.buttonPlugin/./icons/simpleBox.svg?')},"./icons/text-color.svg":(__unused_webpack_module,__webpack_exports__,__webpack_require__)=>{"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("<?xml version=\\"1.0\\" encoding=\\"utf-8\\"?>\x3c!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools --\x3e\\n<svg fill=\\"#000000\\" xmlns=\\"http://www.w3.org/2000/svg\\" \\r\\n\\t width=\\"800px\\" height=\\"800px\\" viewBox=\\"0 0 52 52\\" enable-background=\\"new 0 0 52 52\\" xml:space=\\"preserve\\">\\r\\n<path d=\\"M10.4,36h4.1c0.6,0,1.2-0.5,1.4-1.1l3.2-8.9h13.4l3.5,8.9c0.2,0.6,0.8,1.1,1.4,1.1h4.1\\r\\n\\tc0.7,0,1.2-0.7,0.9-1.3L30.4,5c-0.2-0.6-0.7-1-1.3-1H22c-0.6,0-1.2,0.4-1.4,1l-11,29.7C9.3,35.3,9.8,36,10.4,36z M25.1,10H26l4.3,10\\r\\n\\th-9L25.1,10z\\"/>\\r\\n<path d=\\"M48.5,42h-45C2.7,42,2,42.7,2,43.5v3C2,47.3,2.7,48,3.5,48h45c0.8,0,1.5-0.7,1.5-1.5v-3\\r\\n\\tC50,42.7,49.3,42,48.5,42z\\"/>\\r\\n</svg>");\n\n//# sourceURL=webpack://CKEditor5.buttonPlugin/./icons/text-color.svg?')},"ckeditor5/src/core.js":(module,__unused_webpack_exports,__webpack_require__)=>{eval('module.exports = (__webpack_require__(/*! dll-reference CKEditor5.dll */ "dll-reference CKEditor5.dll"))("./src/core.js");\n\n//# sourceURL=webpack://CKEditor5.buttonPlugin/delegated_./core.js_from_dll-reference_CKEditor5.dll?')},"ckeditor5/src/ui.js":(module,__unused_webpack_exports,__webpack_require__)=>{eval('module.exports = (__webpack_require__(/*! dll-reference CKEditor5.dll */ "dll-reference CKEditor5.dll"))("./src/ui.js");\n\n//# sourceURL=webpack://CKEditor5.buttonPlugin/delegated_./ui.js_from_dll-reference_CKEditor5.dll?')},"ckeditor5/src/utils.js":(module,__unused_webpack_exports,__webpack_require__)=>{eval('module.exports = (__webpack_require__(/*! dll-reference CKEditor5.dll */ "dll-reference CKEditor5.dll"))("./src/utils.js");\n\n//# sourceURL=webpack://CKEditor5.buttonPlugin/delegated_./utils.js_from_dll-reference_CKEditor5.dll?')},"ckeditor5/src/widget.js":(module,__unused_webpack_exports,__webpack_require__)=>{eval('module.exports = (__webpack_require__(/*! dll-reference CKEditor5.dll */ "dll-reference CKEditor5.dll"))("./src/widget.js");\n\n//# sourceURL=webpack://CKEditor5.buttonPlugin/delegated_./widget.js_from_dll-reference_CKEditor5.dll?')},"dll-reference CKEditor5.dll":e=>{"use strict";e.exports=CKEditor5.dll}},__webpack_module_cache__={};function __webpack_require__(e){var t=__webpack_module_cache__[e];if(void 0!==t)return t.exports;var n=__webpack_module_cache__[e]={exports:{}};return __webpack_modules__[e](n,n.exports,__webpack_require__),n.exports}__webpack_require__.d=(e,t)=>{for(var n in t)__webpack_require__.o(t,n)&&!__webpack_require__.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},__webpack_require__.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),__webpack_require__.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})};var __webpack_exports__=__webpack_require__("./js/ckeditor5_plugins/buttonPlugin/src/index.js");return __webpack_exports__=__webpack_exports__.default,__webpack_exports__})()));