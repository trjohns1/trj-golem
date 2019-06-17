<?php
/**
* Create an administrative settings tab
*
* This file creates one tab of the administrative settings user interface.
* It is called by admin_page.php
*/

	/**
	* Register tab elements
	*
	* Register sections, fields, and settings for the tab
	*/
	function trj_golem_admin_settings_templates_initialize() {

		/**
		* Check for Custom Buttons
		*
		* If the settings page includes a custom button beyond the normal
		* Save Changes provided by the WordPress Settings API
		* then those custom buttons need to be detected as follows:
		*
		* One switch statement to detect each custom button:
		*	switch(true) {
		*		case (isset($_POST['custom_button'])):
		*			trj_golem_admin_error_log_button_custom_button();
		*			break;
		}	// switch
		*/

		/* ---------- Register sections ---------- */

		// input
		add_settings_section(
			'trj_golem_admin_settings_templates_section_input',						// ID used to identify this section and with which to register options
			__('INPUT', 'trj_golem'),															// Title to be displayed on the administrative page
			'trj_golem_admin_settings_templates_section_input_callback',			// Callback used to render the description of the section
			'trj_golem_admin_menu'																// Page on which to add this section of options
		);

		// select
		add_settings_section(
			'trj_golem_admin_settings_templates_section_select',						// ID used to identify this section and with which to register options
			__('SELECT', 'trj_golem'),															// Title to be displayed on the administrative page
			'trj_golem_admin_settings_templates_section_select_callback',			// Callback used to render the description of the section
			'trj_golem_admin_menu'																// Page on which to add this section of options
		);

		// textarea
		add_settings_section(
			'trj_golem_admin_settings_templates_section_textarea',					// ID used to identify this section and with which to register options
			__('TEXTAREA', 'trj_golem'),														// Title to be displayed on the administrative page
			'trj_golem_admin_settings_templates_section_textarea_callback',		// Callback used to render the description of the section
			'trj_golem_admin_menu'																// Page on which to add this section of options
		);

		// buttons
		add_settings_section(
			'trj_golem_admin_settings_templates_section_buttons',						// ID used to identify this section and with which to register options
			__('BUTTONS', 'trj_golem'),														// Title to be displayed on the administrative page
			'trj_golem_admin_settings_templates_section_buttons_callback',			// Callback used to render the description of the section
			'trj_golem_admin_menu'																// Page on which to add this section of options
		);

		/* ---------- Register fields ---------- */

		// text
		add_settings_field(
			'trj_golem_admin_settings_templates_field_text',							// ID used to identify the field throughout the theme
			__('TEXT', 'trj_golem'),															// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_text_callback',				// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="text"', 'trj_golem')										// Optional arguments
			)
		);

		// password
		add_settings_field(
			'trj_golem_admin_settings_templates_field_password',						// ID used to identify the field throughout the theme
			__('PASSWORD', 'trj_golem'),														// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_password_callback',			// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="password"', 'trj_golem')									// Optional arguments
			)
		);

		// number
		add_settings_field(
			'trj_golem_admin_settings_templates_field_number',							// ID used to identify the field throughout the theme
			__('NUMBER', 'trj_golem'),															// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_number_callback',				// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="number"', 'trj_golem')									// Optional arguments
			)
		);

		// color
		add_settings_field(
			'trj_golem_admin_settings_templates_field_color',							// ID used to identify the field throughout the theme
			__('COLOR', 'trj_golem'),															// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_color_callback',				// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="color" (hex, e.g. #ff00cc)', 'trj_golem')			// Optional arguments
			)
		);

		// range
		add_settings_field(
			'trj_golem_admin_settings_templates_field_range',							// ID used to identify the field throughout the theme
			__('RANGE', 'trj_golem'),															// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_range_callback',				// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="range"', 'trj_golem')										// Optional arguments
			)
		);

		// email
		add_settings_field(
			'trj_golem_admin_settings_templates_field_email',							// ID used to identify the field throughout the theme
			__('EMAIL', 'trj_golem'),															// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_email_callback',				// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="email"', 'trj_golem')										// Optional arguments
			)
		);

		// search
		add_settings_field(
			'trj_golem_admin_settings_templates_field_search',							// ID used to identify the field throughout the theme
			__('SEARCH', 'trj_golem'),															// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_search_callback',				// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="search"', 'trj_golem')									// Optional arguments
			)
		);

		// tel
		add_settings_field(
			'trj_golem_admin_settings_templates_field_tel',								// ID used to identify the field throughout the theme
			__('TEL', 'trj_golem'),																// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_tel_callback',					// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="tel"', 'trj_golem')										// Optional arguments
			)
		);

		// url
		add_settings_field(
			'trj_golem_admin_settings_templates_field_url',								// ID used to identify the field throughout the theme
			__('URL', 'trj_golem'),																// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_url_callback',					// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="url"', 'trj_golem')										// Optional arguments
			)
		);

		// date
		add_settings_field(
			'trj_golem_admin_settings_templates_field_date',							// ID used to identify the field throughout the theme
			__('DATE', 'trj_golem'),															// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_date_callback',				// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="date"', 'trj_golem')										// Optional arguments
			)
		);

		// month
		add_settings_field(
			'trj_golem_admin_settings_templates_field_month',							// ID used to identify the field throughout the theme
			__('MONTH', 'trj_golem'),															// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_month_callback',				// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="month"', 'trj_golem')										// Optional arguments
			)
		);

		// week
		add_settings_field(
			'trj_golem_admin_settings_templates_field_week',							// ID used to identify the field throughout the theme
			__('WEEK', 'trj_golem'),															// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_week_callback',				// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="week"', 'trj_golem')										// Optional arguments
			)
		);

		// time
		add_settings_field(
			'trj_golem_admin_settings_templates_field_time',							// ID used to identify the field throughout the theme
			__('TIME', 'trj_golem'),															// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_time_callback',				// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="time"', 'trj_golem')										// Optional arguments
			)
		);

		// datetime (actually uses datetime-local)
		add_settings_field(
			'trj_golem_admin_settings_templates_field_datetime',						// ID used to identify the field throughout the theme
			__('DATETIME-LOCAL', 'trj_golem'),												// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_datetime_callback',			// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="datetime-local"', 'trj_golem')							// Optional arguments
			)
		);

		// checkbox
		add_settings_field(
			'trj_golem_admin_settings_templates_field_checkbox',						// ID used to identify the field throughout the theme
			__('CHECKBOX', 'trj_golem'),														// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_checkbox_callback',			// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('input type ="checkbox"', 'trj_golem')									// Optional arguments
			)
		);

		// radio
		add_settings_field(
			'trj_golem_admin_settings_templates_field_radio',							// ID used to identify the field throughout the theme
			__('RADIO', 'trj_golem'),															// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_radio_callback',				// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_input',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('option 1', 'trj_golem'),													// Optional arguments
				__('option 2', 'trj_golem'),
				__('option 3', 'trj_golem')
			)
		);

		// select
		add_settings_field(
			'trj_golem_admin_settings_templates_field_select',							// ID used to identify the field throughout the theme
			__('SELECT', 'trj_golem'),															// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_select_callback',				// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_select',						// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('option 1', 'trj_golem'),													// Optional arguments
				__('option 2', 'trj_golem'),
				__('option 3', 'trj_golem')
			)
		);

		// textarea
		add_settings_field(
			'trj_golem_admin_settings_templates_field_textarea',						// ID used to identify the field throughout the theme
			__('TEXTAREA', 'trj_golem'),														// The label to the left of the option interface element
			'trj_golem_admin_settings_templates_field_textarea_callback',			// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',																// The page on which this option will be displayed
			'trj_golem_admin_settings_templates_section_textarea',					// The name of the section to which this field belongs
			array(																					// Array of arguments to pass to the callback.
				__('optional argument', 'trj_golem')
			)
		);


		/* ---------- Register settings ---------- */

		register_setting(
			'trj_golem_admin_settings_templates_group_01',								// Option group. Must exist prior to this call
			'trj_golem_admin_settings_templates',											// Option name
			'trj_golem_admin_settings_templates_validate'								// Validation callback
		);

	} // function trj_golem_admin_settings_templates_initialize




	/* ---------- Section Callbacks ---------- */


	/**
	* Display section user interface elements
	*/
	function trj_golem_admin_settings_templates_section_input_callback() {
		$html = '<p>' . __('This section demonstrates HTML5 INPUT elements of various types.', 'trj_golem') . '<p>';
		echo $html;
	} // function trj_golem_admin_settings_templates_section_input_callback


	/**
	* Display section user interface elements
	*/
	function trj_golem_admin_settings_templates_section_select_callback() {
		$html = '<p>' . __('This section demonstrates a SELECT form control.', 'trj_golem') . '<p>';
		echo $html;
	} // function trj_golem_admin_settings_templates_section_select_callback


	/**
	* Display section user interface elements
	*/
	function trj_golem_admin_settings_templates_section_textarea_callback() {
		$html = '<p>' . __('This section demonstrates a TEXTAREA form control.', 'trj_golem') . '<p>';
		echo $html;
	} // function trj_golem_admin_settings_templates_section_textarea_callback


	/**
	* Display section user interface elements
	*/
	function trj_golem_admin_settings_templates_section_buttons_callback() {
		$html = '<p>' . __('This section demonstrates HTML5 buttons.', 'trj_golem') . '<p>';
		$html .= '<button type="button" class="button-primary" value="button1" onclick="alert(' . "'Thank you for clicking the primary button!')" . '">Click Me</button>';
		$html .= ' ';
		$html .= '<button type="button" class="button-secondary" value="button2" onclick="alert(' . "'Thank you for clicking the secondary button!')" . '">Click Me</button>';
		echo $html;
	} // function trj_golem_admin_settings_templates_section_buttons_callback




	/* ---------- Field Callbacks ---------- */


	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_text_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="text" id="trj_golem_admin_templates_text" name="trj_golem_admin_settings_templates[text]" value="' . (isset($settings['text']) ? $settings['text'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_templates_text"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_text_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_password_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="password" id="trj_golem_admin_templates_password" name="trj_golem_admin_settings_templates[password]" value="' . (isset($settings['password']) ? $settings['password'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_templates_password"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_password_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_number_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="number" id="trj_golem_admin_templates_number" name="trj_golem_admin_settings_templates[number]" value="' . (isset($settings['number']) ? $settings['number'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_templates_number"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_number_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_color_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="color" id="trj_golem_admin_templates_color" name="trj_golem_admin_settings_templates[color]" value="' . (isset($settings['color']) ? $settings['color'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_templates_color"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_color_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_range_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="range" id="trj_golem_admin_templates_range" name="trj_golem_admin_settings_templates[range]" value="' . (isset($settings['range']) ? $settings['range'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_templates_range"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_range_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_email_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="email" id="trj_golem_admin_templates_email" name="trj_golem_admin_settings_templates[email]" value="' . (isset($settings['email']) ? $settings['email'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_templates_email"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_email_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_search_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="search" id="trj_golem_admin_templates_search" name="trj_golem_admin_settings_templates[search]" value="' . (isset($settings['search']) ? $settings['search'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_templates_search"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_search_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_tel_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="text" id="trj_golem_admin_templates_tel" name="trj_golem_admin_settings_templates[tel]" value="' . (isset($settings['tel']) ? $settings['tel'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_templates_tel"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_tel_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_url_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="url" id="trj_golem_admin_templates_url" name="trj_golem_admin_settings_templates[url]" value="' . (isset($settings['url']) ? $settings['url'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_templates_url"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_url_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_date_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="date" id="trj_golem_admin_templates_date" name="trj_golem_admin_settings_templates[date]" value="' . (isset($settings['date']) ? $settings['date'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_templates_date"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_date_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_month_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="month" id="trj_golem_admin_templates_month" name="trj_golem_admin_settings_templates[month]" value="' . (isset($settings['month']) ? $settings['month'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_templates_month"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_month_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_week_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="week" id="trj_golem_admin_templates_week" name="trj_golem_admin_settings_templates[week]" value="' . (isset($settings['week']) ? $settings['week'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_templates_week"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_week_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_time_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="time" id="trj_golem_admin_templates_time" name="trj_golem_admin_settings_templates[time]" value="' . (isset($settings['time']) ? $settings['time'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_templates_time"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_time_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_datetime_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="datetime-local" id="trj_golem_admin_templates_datetime" name="trj_golem_admin_settings_templates[datetime]" value="' . (isset($settings['datetime']) ? $settings['datetime'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_templates_datetime"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_datetime_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_checkbox_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="checkbox" id="trj_golem_admin_templates_checkbox" name="trj_golem_admin_settings_templates[checkbox]" value="1" ' . checked(1, isset($settings['checkbox']), false) . '/>';
		$html .= '<label for="trj_golem_admin_templates_checkbox"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_checkbox_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_radio_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<input type ="radio" id="trj_golem_admin_templates_radio_1" name="trj_golem_admin_settings_templates[radio]" value="1" ' . checked(1, (isset($settings['radio']) && $settings['radio'] == 1), false) . '/>';
		$html .= '<label for="trj_golem_admin_templates_radio_1"> ' . $args[0] . '</label>';
		$html .= '<input type ="radio" id="trj_golem_admin_templates_radio_2" name="trj_golem_admin_settings_templates[radio]" value="2" ' . checked(1, (isset($settings['radio']) && $settings['radio'] == 2), false) . '/>';
		$html .= '<label for="trj_golem_admin_templates_radio_2"> ' . $args[1] . '</label>';
		$html .= '<input type ="radio" id="trj_golem_admin_templates_radio_3" name="trj_golem_admin_settings_templates[radio]" value="3" ' . checked(1, (isset($settings['radio']) && $settings['radio'] == 3), false) . '/>';
		$html .= '<label for="trj_golem_admin_templates_radio_3"> ' . $args[2] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_checkbox_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_select_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<select id="trj_golem_admin_templates_select" name="trj_golem_admin_settings_templates[select]" >';
			$html .= '<option value="">Select a time option...</option>';
			$html .= '<option value="never"' .     (isset($settings['select']) ? selected($settings['select'], 'never', false) : '') . '>Never</option>';
			$html .= '<option value="sometimes"' . (isset($settings['select']) ? selected($settings['select'], 'sometimes', false) : '') . '>Sometimes</option>';
			$html .= '<option value="always"' . (isset($settings['select']) ? selected($settings['select'], 'always', false) : '') . '>Always</option>';
		$html .= '</select>';;
		echo $html;
	} // trj_golem_admin_settings_templates_field_select_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_templates_field_textarea_callback($args) {
		$settings = get_option('trj_golem_admin_settings_templates');
		$html = '<textarea id="trj_golem_admin_templates_textarea" name="trj_golem_admin_settings_templates[textarea]" rows="5" cols="50">' . (isset($settings['textarea']) ? $settings['textarea'] : ''). '</textarea>';
		echo $html;
	} // trj_golem_admin_settings_templates_field_textarea_callback





	/************************************************************************
	*************************************************************************
	* Validation & Sanitizing
	*************************************************************************
	*************************************************************************
	*/


	/**
	* Validate
	*
	* Validate the settings.
	* $input is an array of settings to be validated and sanitized.
	*/
	function trj_golem_admin_settings_templates_validate( $input ) {

		/* ---------- Set Option Name ---------- */
		// The name of the option as defined in register_setting, argument 2
		$option_name = 'trj_golem_admin_settings_templates';

		/* ---------- Initialize Validation ---------- */
		// Create an array to hold the validated and sanitized user input
		$output = array();
		// Assume the input is good and ready for output.
		$output = $input;
		// Get the currently stored settings values from the database
		$saved_settings = get_option($option_name);

		// ------------------------------------------------------
		// Validate array index: text 
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'text';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('TEXT', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_text';
		// Whether or not the setting is a required field
		$required = true;
		// Minimum length
		$min = 1;
		// Maximum length
		$max = 255;
		/* ---------- Validate ---------- */
		// If the input is bad, replace the output value with the saved value and set an error message.
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// If the input contains forbidden characters escape them
			$clean_str = htmlspecialchars($input[$option_key]);
			if($input[$option_key] != $clean_str) {
				$output[$option_key] = $clean_str;
				add_settings_error($id, $id, $friendly_name . __( ' contains forbidden characters. These characters have been modified for safe storage and display. Please make sure the values are still what you want.', 'trj_golem'), 'updated');
			} // if
			// Make sure input is between limits
			if((strlen($input[$option_key]) < $min) || (strlen($input[$option_key]) > $max) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . sprintf(__( ' not saved. Must be between %1$s and %2$s characters.', 'trj_golem'), $min, $max), 'error');
			} // if
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: password
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'password';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('PASSWORD', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_password';
		// Whether or not the setting is a required field
		$required = true;
		// Minimum length
		$min = 8;
		// Maximum length
		$max = 32;
		/* ---------- Validate ---------- */
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input does not contain forbidden characters
			$clean_str = htmlspecialchars($input[$option_key]);
			if($input[$option_key] != $clean_str) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Contains forbidden characters such as html, javascript, and php tags.', 'trj_golem'), 'error');
			} // if
			// Make sure input is between limits
			if((strlen($input[$option_key]) < $min) || (strlen($input[$option_key]) > $max) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . sprintf(__( ' not saved. Must be between %1$s and %2$s characters.', 'trj_golem'), $min, $max), 'error');
			} // if
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: number
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'number';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('NUMBER', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_number';
		// Whether or not the setting is a required field
		$required = true;
		// Minimum
		$min = 1;
		// Maximum
		$max = 10;
		/* ---------- Validate ---------- */
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input is numeric
			if(!is_numeric($input[$option_key])) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Must be a numeric value.', 'trj_golem'), 'error');
			} // if
			// Make sure input is between limits
			elseif(($input[$option_key] < $min) || ($input[$option_key] > $max) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . sprintf(__( ' not saved. Must be between %1$s and %2$s.', 'trj_golem'), $min, $max), 'error');
			} // if
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: color
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'color';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('COLOR', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_color';
		// Whether or not the setting is a required field
		$required = true;
		/* ---------- Validate ---------- */
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input is a color
			if(!preg_match('/^#[a-f0-9]{6}$/i', $input[$option_key])) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Not a valid color.', 'trj_golem'), 'error');
			} // if
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: range
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'range';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('RANGE', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_range';
		// Whether or not the setting is a required field
		$required = true;
		// Minimum
		$min = 0;
		// Maximum
		$max = 100;
		/* ---------- Validate ---------- */
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input is numeric
			if(!is_numeric($input[$option_key])) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Must be a numeric value.', 'trj_golem'), 'error');
			} // if
			// Make sure input is between limits
			elseif(($input[$option_key] < $min) || ($input[$option_key] > $max) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . sprintf(__( ' not saved. Must be between %1$s and %2$s.', 'trj_golem'), $min, $max), 'error');
			} // elseif
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: email 
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'email';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('EMAIL', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_email';
		// Whether or not the setting is a required field
		$required = true;
		// Minimum length
		$min = 1;
		// Maximum length
		$max = 255;
		/* ---------- Validate ---------- */
		// If the input is bad, replace the output value with the saved value and set an error message.
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input contains no forbidden characters
			$clean_str = htmlspecialchars($input[$option_key]);
			if($input[$option_key] != $clean_str) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' Not saved. Contains forbidden characters.', 'trj_golem'), 'error');
			} // if
			// Make sure input is between limits
			elseif((strlen($input[$option_key]) < $min) || (strlen($input[$option_key]) > $max) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . sprintf(__( ' not saved. Must be between %1$s and %2$s characters.', 'trj_golem'), $min, $max), 'error');
			} // elseif
			elseif(!is_email($input[$option_key])){
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Not a valid email address.', 'trj_golem'), 'error');
			} // elseif
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: search 
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'search';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('SEARCH', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_search';
		// Whether or not the setting is a required field
		$required = true;
		// Minimum length
		$min = 1;
		// Maximum length
		$max = 100;
		/* ---------- Validate ---------- */
		// If the input is bad, replace the output value with the saved value and set an error message.
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input contains no forbidden characters
			$clean_str = htmlspecialchars($input[$option_key]);
			if($input[$option_key] != $clean_str) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Contains forbidden characters.', 'trj_golem'), 'error');
			} // if
			// Make sure input is between limits
			elseif((strlen($input[$option_key]) < $min) || (strlen($input[$option_key]) > $max) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . sprintf(__( ' not saved. Must be between %1$s and %2$s characters.', 'trj_golem'), $min, $max), 'error');
			} // elseif
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: tel 
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'tel';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('TEL', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_tel';
		// Whether or not the setting is a required field
		$required = true;
		// Minimum length
		$min = 1;
		// Maximum length
		$max = 100;
		/* ---------- Validate ---------- */
		// If the input is bad, replace the output value with the saved value and set an error message.
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input contains no forbidden characters
			$clean_str = htmlspecialchars($input[$option_key]);
			if($input[$option_key] != $clean_str) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Contains forbidden characters.', 'trj_golem'), 'error');
			} // if
			// Make sure input is between limits
			elseif((strlen($input[$option_key]) < $min) || (strlen($input[$option_key]) > $max) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . sprintf(__( ' not saved. Must be between %1$s and %2$s characters.', 'trj_golem'), $min, $max), 'error');
			} // elseif
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: url 
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'url';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('URL', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_url';
		// Whether or not the setting is a required field
		$required = true;
		// Minimum length
		$min = 1;
		// Maximum length
		$max = 255;
		/* ---------- Validate ---------- */
		// If the input is bad, replace the output value with the saved value and set an error message.
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input contains no forbidden characters
			$clean_str = htmlspecialchars($input[$option_key]);
			if($input[$option_key] != $clean_str) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Contains forbidden characters.', 'trj_golem'), 'error');
			} // if
			// Make sure input is between limits
			elseif((strlen($input[$option_key]) < $min) || (strlen($input[$option_key]) > $max) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . sprintf(__( ' not saved. Must be between %1$s and %2$s characters.', 'trj_golem'), $min, $max), 'error');
			} // elseif
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: date 
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'date';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('DATE', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_date';
		// Whether or not the setting is a required field
		$required = true;
		/* ---------- Validate ---------- */
		// If the input is bad, replace the output value with the saved value and set an error message.
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input is a valid date
			$date_parts = date_parse($input[$option_key]);
			if( ! ( ($date_parts['warning_count'] == 0)  && ($date_parts['error_count']) == 0) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Not a valid date.', 'trj_golem'), 'error');
			} // if
			else {
				// Date is valid so convert it to YYYY-MM-DD format
				$date = $input[$option_key];
				$date = date_create($date);
				$date = date_format($date, 'Y-m-d');
				$output[$option_key] = $date;
			} // else
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: month 
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'month';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('MONTH', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_month';
		// Whether or not the setting is a required field
		$required = true;
		/* ---------- Validate ---------- */
		// If the input is bad, replace the output value with the saved value and set an error message.
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input is a valid date
			$date_parts = date_parse($input[$option_key]);
			if( ! ( ($date_parts['warning_count'] == 0)  && ($date_parts['error_count']) == 0) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Not a valid date.', 'trj_golem'), 'error');
			} // if
			else {
				// Date is valid so convert it to YYYY-MM-DD format
				$date = $input[$option_key];
				$date = date_create($date);
				$date = date_format($date, 'Y-m');
				$output[$option_key] = $date;
			} // else
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: week 
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'week';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('WEEK', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_week';
		// Whether or not the setting is a required field
		$required = true;
		/* ---------- Validate ---------- */
		// If the input is bad, replace the output value with the saved value and set an error message.
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input is a valid date
			$date_parts = date_parse($input[$option_key]);
			if( ! ( ($date_parts['warning_count'] == 0)  && ($date_parts['error_count']) == 0) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Not a valid date. If your browser does not have a date picker use ISO-8601 format (e.g. 1969-W02 for the second week in 1969).', 'trj_golem'), 'error');
			} // if
			else {
				// Date is valid so convert it to YYYY-MM-DD format
				$date = $input[$option_key];
				$date = date_create($date);
				$date = date_format($date, 'Y-\WW');
				$output[$option_key] = $date;
			} // else
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: time 
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'time';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('TIME', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_time';
		// Whether or not the setting is a required field
		$required = true;
		/* ---------- Validate ---------- */
		// If the input is bad, replace the output value with the saved value and set an error message.
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input is a valid date
			$date_parts = date_parse($input[$option_key]);
			if( ! ( ($date_parts['warning_count'] == 0)  && ($date_parts['error_count']) == 0) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Not a valid time. If your browser does not have a time picker use ISO-8601 format (e.g. 13:15 for 1:15PM).', 'trj_golem'), 'error');
			} // if
			else {
				// Date is valid so convert it to YYYY-MM-DD format
				$date = $input[$option_key];
				$date = date_create($date);
				$date = date_format($date, 'H:i:s');
				$output[$option_key] = $date;
			} // else
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: datetime 
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'datetime';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('DATETIME', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_datetime';
		// Whether or not the setting is a required field
		$required = true;
		/* ---------- Validate ---------- */
		// If the input is bad, replace the output value with the saved value and set an error message.
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input is a valid date
			$date_parts = date_parse($input[$option_key]);
			if( ! ( ($date_parts['warning_count'] == 0)  && ($date_parts['error_count']) == 0) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Not a valid time. If your browser does not have a time picker use ISO-8601 format (e.g. 1776-07-04T13:15).', 'trj_golem'), 'error');
			} // if
			else {
				// Date is valid so convert it to YYYY-MM-DD format
				$date = $input[$option_key];
				$date = date_create($date);
				$date = date_format($date, 'Y-m-d\TH:i:s');
				$output[$option_key] = $date;
			} // else
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: checkbox 
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'checkbox';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('CHECKBOX', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_checkbox';
		// Whether or not the setting is a required field
		$required = false; // checkboxes cannot be required.
		// Minimum length
		$min = 1;
		// Maximum length
		$max = 255;
		/* ---------- Validate ---------- */
		// If the input is bad, replace the output value with the saved value and set an error message.
		if(isset($input[$option_key])) {
			// Make sure input contains no forbidden characters
			$clean_str = htmlspecialchars($input[$option_key]);
			if($input[$option_key] != $clean_str) {
				$output[$option_key] = $saved_settings[$option_key];
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Contains forbidden characters.', 'trj_golem'), 'error');
			} // if
			// Make sure input is between limits
			elseif((strlen($input[$option_key]) < $min) || (strlen($input[$option_key]) > $max) ) {
				$output[$option_key] = $saved_settings[$option_key];
				add_settings_error($id, $id, $friendly_name . sprintf(__( ' not saved. Must be between %1$s and %2$s characters.', 'trj_golem'), $min, $max), 'error');
			} // elseif
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: select
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'select';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('SELECT', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_select';
		// Whether or not the setting is a required field
		$required = true;
		/* ---------- Validate ---------- */
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = $saved_settings[$option_key];
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input contains no forbidden characters
			$clean_str = htmlspecialchars($input[$option_key]);
			if($input[$option_key] != $clean_str) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Contains forbidden characters.', 'trj_golem'), 'error');
			} // if
			// Make sure input is a valid selection
			$valid_input = false;
			if (
					$input[$option_key] == 'never' || 
					$input[$option_key] == 'sometimes' ||
					$input[$option_key] == 'always'
				) {
				$valid_input = true;
			} // if
			if(!$valid_input) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Not a valid choice.', 'trj_golem'), 'error');
			} // if
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: textarea
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'textarea';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('TEXTAREA', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_templates_textarea';
		// Whether or not the setting is a required field
		$required = true;
		// Minimum length
		$min = 1;
		// Maximum length
		$max = 1000;
		/* ---------- Validate ---------- */
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// If the input contains forbidden characters escape them
			$clean_str = htmlspecialchars($input[$option_key]);
			if($input[$option_key] != $clean_str) {
				$output[$option_key] = $clean_str;
				add_settings_error($id, $id, $friendly_name . __( ' contains forbidden characters. These characters have been modified for safe storage and display. Please make sure the values are still what you want.', 'trj_golem'), 'updated');
			} // if
			// Make sure input is between limits
			if((strlen($input[$option_key]) < $min) || (strlen($input[$option_key]) > $max) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . sprintf(__( ' not saved. Must be between %1$s and %2$s characters.', 'trj_golem'), $min, $max), 'error');
			} // if
		} // else
		/* ---------- End Validation Code ---------- */



		/* ---------- All Validation Complete: Return ---------- */
		// Apply any filters registered to this function and return
		return apply_filters(__FUNCTION__, $output, $input);
	} // function trj_golem_admin_settings_templates_validate






	/************************************************************************
	*************************************************************************
	* Custom Buttons
	*************************************************************************
	*************************************************************************
	* Manage buttons other than submit
	*
	* The WordPress Settings API saves fields when the submit button is pressed,
	* but has no method for handling custom buttons. Functions for each custom
	* button should be defined here and called from the switch statement at the
	* top of this file.
	*/

	/**
	* Process custom button
	*/
	/*
	function trj_golem_admin_error_log_button_custom_button() {
		// insert custom button handling code here
	}
	*/

?>
