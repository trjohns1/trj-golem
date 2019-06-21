Plugin Documentation


Golem is a WordPress plugin template that can be used to create other WordPress plugins. It is a fully functional plugin that can be modified to create a database-driven web application. It has the following features:

    Enables the creation of database-driven web applications.
    Full installation and clean uninstallation.
    Supports database upgrades as the plugin versions increase.
    User management and authorization via standard WordPress capabilities.
    Robust tabbed administrative settings interface.
    HTML form classes for easy form creation and management.
    Error logging.
    Creation of custom database tables for complex data management.
    The core plugin is fully internationalized to support translations.
    Support for CSS styling of plugin elements.
    Queues .js files for plugin development requiring javascript.


Make a Working Copy of the Plugin

In order to use the plugin as a template, first create a copy of the plugin giving it a new name and replacing the plugin prefix with a new prefix to ensure that all functions and variables have a unique namespace.

    Make a copy of the entire trj_golem directory and put it in the WordPress plugins directory, giving it a new name as you do so.
    Change the name of the new plugin core file "trj_golem.php" to something descriptive and unique, such as "trj_foo".
    Search the entire new plugin directory, including all files and subdirectories for occurences of "trj_golem" and replace them with a new prefix string, such as "trj_foo".

    find -name '*.php' -type f -print0 | xargs -0 sed -i 's/trj_golem/trj_foo/g'


User Management

The plugin uses standard WordPress user accounts and can be used straightaway without modification. To enable single sign-on with SAML/Shiboleth, install the plugin miniOrangeSAML SSO and configure according to specifications provided by your identity management service provider.


Authorization

The plugin uses the WordPress capabilities model to control access to individual scripts and handle authorization. When the plugin is installed it creates the capabilities it needs and assigns them to the administrator role. The plugin does not have a built-in user capabilities editor. Instead use the "User Role Editor" plugin or similar capabilities editor to assign plugin capabilities to the roles of your choice. These capabilities should be prefixed by the plugin prefix created when the working copy of the plugin was created.

The programmer should do two things to enable authorization:

    The file admin/version_functions.php contains an array $capabilities which holds a list of capabilities that are created when the plugin is installed. Edit this list to create the capabilities required for the application.
    Each script features a $script_permission variable which the programmer should set to a capability that should have access to the script. Generally, this capability corresponds to one of the capabilities created in admin/version_functions, although it could refer to any WordPress capability.


Creating Scripts

When installed, the plugin creates a single WordPress page. All of the scripts run on this page, creating different forms and views for the user. The individual scripts to run are based on the script name being provided in the query string. For example

https://www.example.com/wordpress/?page_id=3012&trj_golem_script=trj_golem_template_form&trj_golem_color=red

describes a WordPress instance running encrypted on www.example.com. The page_id of 3012 indicates the plugin home page from which all plugin scripts will run. The particular script to be invoked is "trj_golem_template_form" and "red" is an argument used by that script.


Files and How to Use Them

---------- Top level files ----------
trj_golem.php
     The core plugin logic. Initializes the plugin and calls the appropriate script. There is generally not a need to modify this file.
uninstall.php
     Actions needed when the plugin is uninstalled from the administrative interface. Put code here to delete custom options, database tables, and capabilities.

---------- Files used by the administrative user interface and to configure the plugin. ----------
admin/admin_page.php
     Main code to create the administrative user interface. Use this to create individual tabs.
admin/admin_page_documentation.php
     Creates the documentation tab of the administrative user interface.
admin/admin_page_error_log.php
     Creates the error_log tab of the administrative user interface.
admin/admin_page_general.php
     Creates the general tab of the administrative user interface.
admin/admin_page_templates.php
     Creates the templates tab of the administrative user interface.
admin/comment_style.php
     Sample comments to show documentation style. For reference only.
admin/config.php
     Sets basic options for the plugin. Modify PHP behavior here.
admin/load_admin_settings.php
     Get plugin options for use by the plugin. These are the options set in the administrative user interface.
admin/script_registry.php
     A list of all scripts that are allowed to run for the plugin. Unregistered scripts will not be called. List new scripts here.
admin/version_functions.php
     Code to install the initial database and options, and to upgrade them as the plugin version increases. Put upgrade code here.

---------- Files included to be used by scripts ----------
includes/includes.php
     Included automaticall by the core plugin. List here any files you wish to be included by ALL scripts.
includes/error_handling.php
     A set of functions that register a page error, log a page error to the database, and display a page error.
includes/form_classes.php
     A set of classes for creating and managing forms. Used only on application pages, not in the administrative user interface.
includes/get_query_vars.php
     Gets query variables requested by the user regardless of http message type.
includes/paginate.php
     A utility that generates an HTML pagination widget.
includes/record_in_db.php
     Tests if a particular record exists in the database. Used to prevent processing a record that does not exist.
includes/register_css_and_javascript.php
     Registers and enqueues css stylesheets and javascript programs. Edit this to include css and js files.
includes/save_for_redisplay.php
     A utility that copies user data into a form so that a user does not have to retype all form data just because there are validation errors in some form fields.

---------- CSS ----------
css/adminstyles.css
     CSS file for styling administrative settings pages
css/styles.css
     CSS file for styling plugin elements

---------- Javascript ----------
js/script.js
     A sample javascript file that is properly enqueued.

---------- Sample scripts to be used as templates for building applications ----------
scripts/cars_create.php
     A script that allows a user to create a new record
scripts/cars_edit.php
     A script that allows a user to update or delete an existing record.
scripts/cars_list.php
     A script that allows a user to search for records based on filter criteria and display the results in a paginated list.
scripts/default.php
     A script that runs when no specific script is included in the query request. This is often used as the application home or splash page.
