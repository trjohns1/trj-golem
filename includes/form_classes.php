<?php
/*
* -----------------------------------------------------------------------------
* Form Element Classes
* -----------------------------------------------------------------------------
* A collection of simple classes that model and generate HTML form controls.
* These classes make it possible for form controls to be generated 
* programmatically in the view using data set in the controller.
* These classes can also be updated from the view itself to further
* modify the form controls.
*
* The classes are intended to serve as simple data structures.
* They do not provide error handling or validation. It is expected
* that they are populated with valid data.
*
* The classes model and generate the followng HTML form elements:
* - <button>
* - <textarea>
* - <input>
* - <select>
* - <option>
* The classes also support an attribute called "inner_text" which is not
* named as part of the HTML standard but is the content between two tags.
*
* The classes include:
* - trj_golem_form_element_button
* - trj_golem_form_element_textarea
* - trj_golem_form_element_input
* - trj_golem_form_element_select // Requires class trj_golem_form_element_option
* - trj_golem_form_element_option
*
*
* The following traits are defined that model global, event, and extra
* attributes. These are used by multiple classes.
* The traits include:
* - trj_golem_form_element_global_attributes
* - trj_golem_form_element_event_attributes
* - trj_golem_form_element_extras	// non-standard but useful attributes
*
* Also defined here is a helper function:
* - trj_golem_has_form_errors()
* which determines if any objects in a form contain errors.
*
*
*	-----------------------------------------------------------------------------
*	Usage
*	-----------------------------------------------------------------------------
*	The following sample code demonstrates the use of the classes
*
*		// Create form button control
*		$trj_golem_data['form']['button'] = new trj_golem_form_element_button();
*		// Set attributes
*		$trj_golem_data['form']['button']->name='button';
*		$trj_golem_data['form']['button']->type='submit';
*		$trj_golem_data['form']['button']->inner_text='Click Me';
*		$trj_golem_data['form']['button']->class='button-primary';
*		$trj_golem_data['form']['button']->label_text='Button Element';
*		$trj_golem_data['form']['button']->helper_text='Button helper text.';
*		$trj_golem_data['form']['button']->error_message='Button error message.';
*
*		// Create form textarea control
*		$trj_golem_data['form']['textarea'] = new trj_golem_form_element_textarea();
*		// Set attributes
*		$trj_golem_data['form']['textarea']->name='textarea';
*		$trj_golem_data['form']['textarea']->inner_text='Long quote goes here.';
*		$trj_golem_data['form']['textarea']->label_text='Textarea element';
*		$trj_golem_data['form']['textarea']->helper_text='Textarea Helper text.';
*		$trj_golem_data['form']['textarea']->error_message='Textarea error message.';
*
*		// Create form input control
*		$trj_golem_data['form']['input1'] = new trj_golem_form_element_input();
*		// Set attributes
*		$trj_golem_data['form']['input1']->name='input_text';
*		$trj_golem_data['form']['input1']->type='text';
*		$trj_golem_data['form']['input1']->placeholder='Enter text...';
*		$trj_golem_data['form']['input1']->label_text='Input Element';
*		$trj_golem_data['form']['input1']->helper_text='Input helper text.';
*		$trj_golem_data['form']['input1']->error_message='Input error message.';
*
*		// Create form selectcontrol
*		$trj_golem_data['form']['select_multiple'] = new trj_golem_form_element_select();
*		// Set attributes
*		$trj_golem_data['form']['select_multiple']->name='select_multiple[]';
*		$trj_golem_data['form']['select_multiple']->multiple=true;
*		$trj_golem_data['form']['select_multiple']->label_text='Select Element';
*		$trj_golem_data['form']['select_multiple']->helper_text='Select helper text.';
*		$trj_golem_data['form']['select_multiple']->error_message='Select error message.';
*
*			// Create option 1
*			$trj_golem_data['form']['select_multiple']->options['option1'] = new trj_golem_form_element_option();
*			// Set attributes
*			$trj_golem_data['form']['select_multiple']->options['option1']->value='option1 value';
*			$trj_golem_data['form']['select_multiple']->options['option1']->inner_text='option1 inner text';
*
*			// Create option 2
*			$trj_golem_data['form']['select_multiple']->options['option2'] = new trj_golem_form_element_option();
*			// Set attributes
*			$trj_golem_data['form']['select_multiple']->options['option2']->value='option2 value';
*			$trj_golem_data['form']['select_multiple']->options['option2']->inner_text='option2 inner text';
*			$trj_golem_data['form']['select_multiple']->options['option2']->selected=true;
*
*			// Create option 3
*			$trj_golem_data['form']['select_multiple']->options['option3'] = new trj_golem_form_element_option();
*			// Set attributes
*			$trj_golem_data['form']['select_multiple']->options['option3']->value='option3 value';
*			$trj_golem_data['form']['select_multiple']->options['option3']->inner_text='option3 inner text';
*
*			// Create option 4
*			$trj_golem_data['form']['select_multiple']->options['option4'] = new trj_golem_form_element_option();
*			// Set attributes
*			$trj_golem_data['form']['select_multiple']->options['option4']->value='option4 value';
*			$trj_golem_data['form']['select_multiple']->options['option4']->inner_text='option4 inner text';
*			$trj_golem_data['form']['select_multiple']->options['option4']->selected=true;
*
*			// Create option 5
*			$trj_golem_data['form']['select_multiple']->options['option5'] = new trj_golem_form_element_option();
*			// Set attributes
*			$trj_golem_data['form']['select_multiple']->options['option5']->value='option5 value';
*			$trj_golem_data['form']['select_multiple']->options['option5']->inner_text='option5 inner text';
*			$trj_golem_data['form']['select_multiple']->options['option5']->selected=false;
*
*			// Create option 6
*			$trj_golem_data['form']['select_multiple']->options['option6'] = new trj_golem_form_element_option();
*			// Set attributes
*			$trj_golem_data['form']['select_multiple']->options['option6']->value='option6 value';
*			$trj_golem_data['form']['select_multiple']->options['option6']->inner_text='option6 inner text';
*			$trj_golem_data['form']['select_multiple']->options['option6']->selected=false;
*
*
*			// Print form elements ---------------------------------------------
*			echo "{$trj_golem_data['form']['button']->label_text} : {$trj_golem_data['form']['button']->get_form_element()} <br />";
*			echo "{$trj_golem_data['form']['textarea']->label_text} : {$trj_golem_data['form']['textarea']->get_form_element()} <br />";
*			echo "{$trj_golem_data['form']['input1']->label_text} : {$trj_golem_data['form']['input1']->get_form_element()} <br />";
*			echo "{$trj_golem_data['form']['select_multiple']->label_text} : {$trj_golem_data['form']['select_multiple']->get_form_element()} <br />";
*
*/





	/************************************************************************
	*************************************************************************
	* Traits
	*************************************************************************
	*************************************************************************
	*/

	/*
	* @trait trj_golem_form_element_global_attributes
	*
	* Models HTML global attributes
	*/
	trait trj_golem_form_element_global_attributes {

		/* ---------- Properties ---------- */

		// HTML global attributes
		public $accesskey;	// string
		public $class;	// string
		public $contenteditable;	// string ["true|false"]
		public $contextmenu;	// string 
		public $dir;	// string ["ltr|rtl|auto"]
		public $data;	// string ['data-*="value"']  (include the full attribute name and value)
		public $draggable;	// string ["true|false|auto"]
		public $dropzone;	// string ["copy|move|link"]
		public $hidden;	// boolean
		public $id;	// string
		public $lang;	// string ["language_code"]
		public $spellcheck;	// string ["true|false"]
		public $style;	// string
		public $tabindex;	// string
		public $title;	// string
		public $translate;	// string ["yes|no"]



		/* ---------- Methods ---------- */


		/*
		*	Builds and returns a formatted string containining the global attributes.
		*
		*	@return	string	A formatted string containining the global attributes
		*/
		protected function get_global_attribute_string() {
			$attribute_string = '';
			$attribute_string .= (isset($this->accesskey)) ? ' accesskey="' . $this->accesskey . '"' : '';
			$attribute_string .= (isset($this->class)) ? ' class="' . $this->class . '"' : '';
			$attribute_string .= (isset($this->contenteditable)) ? ' contenteditable="' . $this->contenteditable . '"' : '';
			$attribute_string .= (isset($this->contextmenu)) ? ' contextmenu="' . $this->contextmenu . '"' : '';
			$attribute_string .= (isset($this->dir)) ? ' dir="' . $this->dir . '"' : '';
			$attribute_string .= (isset($this->data)) ? ' ' . $this->data : '';
			$attribute_string .= (isset($this->draggable)) ? ' draggable="' . $this->draggable . '"' : '';
			$attribute_string .= (isset($this->dropzone)) ? ' dropzone="' . $this->dropzone . '"' : '';
			$attribute_string .= (isset($this->hidden) && $this->hidden) ? ' hidden' : '';
			$attribute_string .= (isset($this->id)) ? ' id="' . $this->id . '"' : '';
			$attribute_string .= (isset($this->lang)) ? ' lang="' . $this->lang . '"' : '';
			$attribute_string .= (isset($this->spellcheck)) ? ' spellcheck="' . $this->spellcheck . '"' : '';
			$attribute_string .= (isset($this->style)) ? ' style="' . $this->style . '"' : '';
			$attribute_string .= (isset($this->tabindex)) ? ' tabindex="' . $this->tabindex . '"' : '';
			$attribute_string .= (isset($this->title)) ? ' title="' . $this->title . '"' : '';
			$attribute_string .= (isset($this->translate)) ? ' translate="' . $this->translate . '"' : '';
			return $attribute_string;
		} // function

	} // trait



	/*
	* @trait trj_golem_form_element_event_attributes
	*
	* Models HTML event attributes
	*/
	trait trj_golem_form_element_event_attributes {

		/* ---------- Properties ---------- */

		// HTML event attributes
		public $onafterprint;	// string
		public $onbeforeprint;	// string
		public $onbeforeunload;	// string
		public $onerror;	// string
		public $onhashchange;	// string
		public $onload;	// string
		public $onmessage;	// string
		public $onoffline;	// string
		public $ononline;	// string
		public $onpagehide;	// string
		public $onpageshow;	// string
		public $onpopstate;	// string
		public $onresize;	// string
		public $onstorage;	// string
		public $onunload;	// string


		/* ---------- Methods ---------- */


		/*
		*	Build and returns a formatted string containining the event attributes.
		*
		*	@return	string	A formatted string containining the event attributes
		*/
		protected function get_event_attribute_string() {
			$attribute_string = '';
			$attribute_string .= (isset($this->onafterprint)) ? ' onafterprint="' . $this->onafterprint . '"' : '';
			$attribute_string .= (isset($this->onbeforeprint)) ? ' onbeforeprint="' . $this->onbeforeprint . '"' : '';
			$attribute_string .= (isset($this->onbeforeunload)) ? ' onbeforeunload="' . $this->onbeforeunload . '"' : '';
			$attribute_string .= (isset($this->onerror)) ? ' onerror="' . $this->onerror . '"' : '';
			$attribute_string .= (isset($this->onhashchange)) ? ' onhashchange="' . $this->onhashchange . '"' : '';
			$attribute_string .= (isset($this->onload)) ? ' onload="' . $this->onload . '"' : '';
			$attribute_string .= (isset($this->onmessage)) ? ' onmessage="' . $this->onmessage . '"' : '';
			$attribute_string .= (isset($this->onoffline)) ? ' onoffline="' . $this->onoffline . '"' : '';
			$attribute_string .= (isset($this->ononline)) ? ' ononline="' . $this->ononline . '"' : '';
			$attribute_string .= (isset($this->onpagehide)) ? ' onpagehide="' . $this->onpagehide . '"' : '';
			$attribute_string .= (isset($this->onpageshow)) ? ' onpageshow="' . $this->onpageshow . '"' : '';
			$attribute_string .= (isset($this->onpopstate)) ? ' onpopstate="' . $this->onpopstate . '"' : '';
			$attribute_string .= (isset($this->onresize)) ? ' onresize="' . $this->onresize . '"' : '';
			$attribute_string .= (isset($this->onstorage)) ? ' onstorage="' . $this->onstorage . '"' : '';
			$attribute_string .= (isset($this->onunload)) ? ' onunload="' . $this->onunload . '"' : '';
			return $attribute_string;
		} // function

	} // trait



	/*
	* @trait trj_golem_form_element_extras.
	*
	* Models non-standard attributes that are useful for form elements.
	*/
	trait trj_golem_form_element_extras {

		/* ---------- Properties ---------- */

		// HTML event attributes
		public $label_text;	// string
		public $helper_text;	// string
		public $error_message;	// string


		/* ---------- Methods ---------- */

		// No methods. These properties are used as is.

	} // trait












	/************************************************************************
	*************************************************************************
	* Classes
	*************************************************************************
	*************************************************************************
	*/


	/*
	* @class trj_golem_form_element_button
	*
	* Models and prints an HTML form button
	*/
	class trj_golem_form_element_button {
		use trj_golem_form_element_global_attributes, trj_golem_form_element_event_attributes, trj_golem_form_element_extras;

		/* ---------- Properties ---------- */

		// HTML attributes native to the <button> element
		public $autofocus;	// boolean
		public $disabled;	// boolean
		public $form;	// string
		public $formaction;	// string
		public $formenctype;	// string ["text/plain|multipart/form-data|application/x-www-form-urlencoded"]
		public $formmethod;	// string ["get|post"]
		public $formnovalidate;	// boolean
		public $formtarget;	// string ["_blank|_self|_parent|_top|framename"]
		public $name;	// string
		public $type;	// string
		public $value;	// string

		// Text between tags
		public $inner_text;	// string


		/* ---------- Methods ---------- */

		/*
		* Return the entire button element including all attributes and closing tag.
		*/
		public function get_form_element() {
			// Build string to hold the form element
			$element_string = '<button';
			$element_string .= $this->get_attribute_string();
			$element_string .= $this->get_global_attribute_string();
			$element_string .= $this->get_event_attribute_string();
			$element_string .= ' >';
			$element_string .= $this->inner_text;
			$element_string .= '</button>';
			// return the completed form element
			return $element_string;
		} // function


		/*
		* Build and returns a string containing all of the element's native attributes.
		*
		* @return	string	A string containing all of the element's native attributes.
		*/
		protected function get_attribute_string() {
			$attribute_string = '';
			$attribute_string .= (isset($this->autofocus) && $this->autofocus) ? ' autofocus' : '';
			$attribute_string .= (isset($this->disabled) && $this->disabled) ? ' disabled' : '';
			$attribute_string .= (isset($this->form)) ? ' form="' . $this->form . '"' : '';
			$attribute_string .= (isset($this->formaction)) ? ' formaction="' . $this->formaction . '"' : '';
			$attribute_string .= (isset($this->formenctype)) ? ' formenctype="' . $this->formenctype . '"' : '';
			$attribute_string .= (isset($this->formmethod)) ? ' formmethod="' . $this->formmethod . '"' : '';
			$attribute_string .= (isset($this->formnovalidate) && $this->formnovalidate) ? ' formnovalidate' : '';
			$attribute_string .= (isset($this->formtarget)) ? ' formtarget="' . $this->formtarget . '"' : '';
			$attribute_string .= (isset($this->name)) ? ' name="' . $this->name . '"' : '';
			$attribute_string .= (isset($this->type)) ? ' type="' . $this->type . '"' : '';
			$attribute_string .= (isset($this->value)) ? ' value="' . $this->value . '"' : '';
			return $attribute_string;
		} // function

	} // class


	/*
	* @class trj_golem_form_element_textarea
	*
	* Model and prints an HTML textarea
	*/
	class trj_golem_form_element_textarea {
		use trj_golem_form_element_global_attributes, trj_golem_form_element_event_attributes, trj_golem_form_element_extras;

		/* ---------- Properties ---------- */

		// HTML attributes native to the <textarea> element
		public $autofocus;	// boolean
		public $cols;	// string
		public $disabled;	// boolean
		public $form;	// string
		public $maxlength;	// string
		public $name;	// string
		public $placeholder;	// string
		public $readonly;	// boolean
		public $required;	// boolean
		public $rows;	// string
		public $wrap;	// string ["soft|hard"]

		// Text to be displayed betweeen tags
		public $inner_text;	// string


		/* ---------- Methods ---------- */

		/*
		* Return the entire button element including all attributes and closing tag.
		*/
		public function get_form_element() {
			// Build string to hold the form element
			$element_string = '<textarea';
			$element_string .= $this->get_attribute_string();
			$element_string .= $this->get_global_attribute_string();
			$element_string .= $this->get_event_attribute_string();
			$element_string .= ' >';
			$element_string .= $this->inner_text;
			$element_string .= '</textarea>';
			// return the completed form element
			return $element_string;
		} // function


		/*
		* Build and returns a string containing all of the element's native attributes.
		*
		* @return	string	A string containing all of the element's native attributes.
		*/
		protected function get_attribute_string() {
			$attribute_string = '';
			$attribute_string .= (isset($this->autofocus) && $this->autofocus) ? ' autofocus' : '';
			$attribute_string .= (isset($this->cols)) ? ' cols="' . $this->cols . '"' : '';
			$attribute_string .= (isset($this->disabled) && $this->disabled) ? ' disabled' : '';
			$attribute_string .= (isset($this->form)) ? ' form="' . $this->form . '"' : '';
			$attribute_string .= (isset($this->maxlength)) ? ' maxlength="' . $this->maxlength . '"' : '';
			$attribute_string .= (isset($this->name)) ? ' name="' . $this->name . '"' : '';
			$attribute_string .= (isset($this->placeholder)) ? ' placeholder="' . $this->placeholder . '"' : '';
			$attribute_string .= (isset($this->readonly) && $this->readonly) ? ' readonly' : '';
			$attribute_string .= (isset($this->required) && $this->required) ? ' required' : '';
			$attribute_string .= (isset($this->rows)) ? ' rows="' . $this->rows . '"' : '';
			$attribute_string .= (isset($this->wrap)) ? ' wrap="' . $this->wrap . '"' : '';
			return $attribute_string;
		} // function

	} // class




	/*
	* @class trj_golem_form_element_input
	*
	* Model and print an HTML form input element
	*/
	class trj_golem_form_element_input {
		use trj_golem_form_element_global_attributes, trj_golem_form_element_event_attributes, trj_golem_form_element_extras;

		/* ---------- Properties ---------- */

		// HTML attributes native to the <input> element
		public $accept;	// string ["file_extension|audio/*|video/*|image/*|media_type"]
		public $alt;	// string
		public $autocomplete; // string ["on|off"]
		public $autofocus;	// boolean
		public $checked;	// boolean
		public $disabled;	// boolean
		public $form;	// string
		public $formaction;	// string
		public $formenctype;	// string ["text/plain|multipart/form-data|application/x-www-form-urlencoded"]
		public $formmethod;	// string ["get|post"]
		public $formnovalidate;	// boolean
		public $formtarget;	// string
		public $height;	// string
		public $list;	// string
		public $max;	// string
		public $maxlength;	// string
		public $min;	// string
		public $multiple;	// boolean
		public $name;	// string
		public $pattern;	// string
		public $placeholder;	// string
		public $readonly;	// boolean
		public $required;	// boolean
		public $size;	// string
		public $src;	// string
		public $step;	// string
		public $type;	// string ["text|radio|submit"]
		public $value;	// string
		public $width;	// string


		/* ---------- Methods ---------- */

		/*
		* Return the entire input element including all attributes.
		*/
		public function get_form_element() {
			// Build string to hold the form element
			$element_string = '<input';
			$element_string .= $this->get_attribute_string();
			$element_string .= $this->get_global_attribute_string();
			$element_string .= $this->get_event_attribute_string();
			$element_string .= ' >';
			// return the completed form element
			return $element_string;
		} // function


		/*
		* Build and return a string containing all of the element's native attributes.
		*
		*	@return	string	A string containing all of the element's native attributes.
		*/
		protected function get_attribute_string() {
			$attribute_string = '';
			$attribute_string .= (isset($this->accept)) ? ' accept="' . $this->accept . '"' : '';
			$attribute_string .= (isset($this->alt)) ? ' alt="' . $this->alt . '"' : '';
			$attribute_string .= (isset($this->autocomplete)) ? ' autocomplete=' . $this->autocomplete . '"' : '';
			$attribute_string .= (isset($this->autofocus)) && $this->autofocus ? ' autofocus' : '';
			$attribute_string .= (isset($this->checked)) && $this->checked ? ' checked' : '';
			$attribute_string .= (isset($this->disabled)) && $this->disabled ? ' disabled' : '';
			$attribute_string .= (isset($this->form)) ? ' form="' . $this->form . '"' : '';
			$attribute_string .= (isset($this->formaction)) ? ' formaction="' . $this->formaction . '"' : '';
			$attribute_string .= (isset($this->formenctype)) ? ' formenctype="' . $this->formenctype . '"' : '';
			$attribute_string .= (isset($this->formmethod)) ? ' formmethod="' . $this->formmethod . '"' : '';
			$attribute_string .= (isset($this->formnovalidate) && $this->formnovalidate) ? ' formnovalidate="formnovalidate"' : '';
			$attribute_string .= (isset($this->formtarget)) ? ' formtarget="' . $this->formtarget . '"' : '';
			$attribute_string .= (isset($this->height)) ? ' height="' . $this->height . '"' : '';
			$attribute_string .= (isset($this->list)) ? ' list="' . $this->list . '"' : '';
			$attribute_string .= (isset($this->max)) ? ' max="' . $this->max . '"' : '';
			$attribute_string .= (isset($this->maxlength)) ? ' maxlength="' . $this->maxlength . '"' : '';
			$attribute_string .= (isset($this->min)) ? ' min="' . $this->min . '"' : '';
			$attribute_string .= (isset($this->multiple) && $this->multiple) ? ' multiple' : '';
//			$attribute_string .= (isset($this->name)) ? ' name="' . $this->name . '"' : '';
			// Add the name attribute, appending brackets if attribute multiple is true. This allows PHP to receive multiple submissions as an array.
			$name_string = '';
			if (isset($this->name)) {
				$name_string .= ' name="' . $this->name;
				if ((isset($this->multiple) && $this->multiple)) {
					$name_string .= '[]';
				} // if
				$name_string .= '"';
			} // if
			$attribute_string .= $name_string;
			// Continue building attribute string
			$attribute_string .= (isset($this->pattern)) ? ' pattern="' . $this->pattern . '"' : '';
			$attribute_string .= (isset($this->placeholder)) ? ' placeholder="' . $this->placeholder . '"' : '';
			$attribute_string .= (isset($this->readonly) && $this->readonly) ? ' readonly' : '';
			$attribute_string .= (isset($this->required) && $this->required) ? ' required' : '';
			$attribute_string .= (isset($this->size)) ? ' size="' . $this->size . '"' : '';
			$attribute_string .= (isset($this->src)) ? ' src="' . $this->src . '"' : '';
			$attribute_string .= (isset($this->step)) ? ' step="' . $this->step . '"' : '';
			$attribute_string .= (isset($this->type)) ? ' type="' . $this->type . '"' : '';
			$attribute_string .= (isset($this->value)) ? ' value="' . $this->value . '"' : '';
			$attribute_string .= (isset($this->width)) ? ' width="' . $this->width . '"' : '';

			return $attribute_string;
		} // function


	} // class






	/*
	* @class trj_golem_form_element_select
	*
	* Model and print an HTML form select element
	*
	* This class depends upon class trj_golem_form_element_option.
	*/
	class trj_golem_form_element_select {
		use trj_golem_form_element_global_attributes, trj_golem_form_element_event_attributes, trj_golem_form_element_extras;

		/* ---------- Properties ---------- */

		// HTML attributes native to the <button> element
		public $autofocus;	// boolean
		public $disabled;	// boolean
		public $form;	// string
		public $multiple;	// boolean
		public $name;	// string
		public $required;	// boolean
		public $size;	// string

		// Text between tags
		public $inner_text;	// string

		// An array of <option> objects
		public $options;	// array


		/* ---------- Methods ---------- */

		/*
		*	Return the entire select element including all attributes and closing tag.
		*/
		public function get_form_element() {
			// Build string to hold the form element
			$element_string = '<select';
			$element_string .= $this->get_attribute_string();
			$element_string .= $this->get_global_attribute_string();
			$element_string .= $this->get_event_attribute_string();
			$element_string .= ' >';
			$element_string .= PHP_EOL;
			// Get <option> tags
			foreach($this->options as $value) {
				$element_string .= $value->get_form_element();
				$element_string .= PHP_EOL;
			} // foreach
			// Create the closing tag
			$element_string .= '</select>';
			return $element_string;
		} // function


		/*
		* Build and return a string containing all of the element's native attributes.
		*
		* @return	string	A string containing all of the element's native attributes.
		*/
		protected function get_attribute_string() {
			$attribute_string = '';
			$attribute_string .= (isset($this->autofocus) && $this->autofocus) ? ' autofocus' : '';
			$attribute_string .= (isset($this->disabled) && $this->disabled) ? ' disabled' : '';
			$attribute_string .= (isset($this->form)) ? ' form="' . $this->form . '"' : '';
			$attribute_string .= (isset($this->multiple) && $this->multiple) ? ' multiple' : '';
			// Add the name attribute, appending brackets if attribute multiple is true. This allows PHP to receive multiple submissions as an array.
			$name_string = '';
			if (isset($this->name)) {
				$name_string .= ' name="' . $this->name;
				if ((isset($this->multiple) && $this->multiple)) {
					$name_string .= '[]';
				} // if
				$name_string .= '"';
			} // if
			$attribute_string .= $name_string;
			// Continue building attribute string
			$attribute_string .= (isset($this->required) && $this->required) ? ' required' : '';
			$attribute_string .= (isset($this->size)) ? ' size="' . $this->size . '"' : '';
			return $attribute_string;
		} // function

	} // class


	/*
	* @class trj_golem_form_element_option
	*
	* Model  and print  an HTML form option element
	*/
	class trj_golem_form_element_option {
		use trj_golem_form_element_global_attributes, trj_golem_form_element_event_attributes;

		/* ---------- Properties ---------- */

		// HTML attributes native to the <button> element
		public $disabled;	// boolean
		public $label;	// string
		public $selected;	// boolean
		public $value;	// string

		// Text between tags
		public $inner_text;	// string

		/* ---------- Methods ---------- */

		/*
		*	Return the entire option element including all attributes and closing tag.
		*/
		public function get_form_element() {
			// Build string to hold the form element
			$element_string = '<option';
			$element_string .= $this->get_attribute_string();
			$element_string .= $this->get_global_attribute_string();
			$element_string .= $this->get_event_attribute_string();
			$element_string .= ' >';
			$element_string .= $this->inner_text;
			$element_string .= '</option>';
			// Return the completed form element
			return $element_string;
		} // function


		/*
		* Build and return a string containing all of the element's native attributes.
		*
		* @return	string	A string containing all of the element's native attributes.
		*/
		protected function get_attribute_string() {
			$attribute_string = '';
			$attribute_string .= (isset($this->disabled) && $this->disabled) ? ' disabled' : '';
			$attribute_string .= (isset($this->label)) ? ' label="' . $this->label . '"' : '';
			$attribute_string .= (isset($this->selected) && $this->selected) ? ' selected' : '';
			$attribute_string .= (isset($this->value)) ? ' value="' . $this->value . '"' : '';
			return $attribute_string;
		} // function

	} // class















	/************************************************************************
	*************************************************************************
	* Functions
	*************************************************************************
	*************************************************************************
	*/

	/*
	* Check the form for errors
	*
	* Checks each form element object in an array to determine if there are any
	* errors.
	* $form is an array of objects of one of the classes defined in this file 
	* with a property error_message.
	*
	* @return true if errors are found, false otherwise.
	*/
	function trj_golem_has_form_errors($form) {

		// Counter
		$errors = 0;
		// Loop through each form element object
		foreach($form as $form_element) {
			if (isset($form_element->error_message)) {
				$errors++;
			} // if
		} // foreach
		// Return true if errors, otherwise false
		if ($errors){
			return true;
		} // if
		else {
			return false;
		} // else
	} // function

?>
