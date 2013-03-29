INSTITUTIONS - MOODLE LOCAL

DESCRIPTION
-----------

This local plugin introduces the intitutions concept into Moodle. It allows the Moodle administrator to add, edit, or remove intitutional pages (university page, school page, etc) that can then be accessed by any user without leaving Moodle.

I recommend you use this plugin with Cubic, a theme for Moodle that I also created (https://moodle.org/plugins/view.php?plugin=theme_cubic).


CONTENTS ORGANISATION
---------------------

	FOLDERS:
	- db: contains the "install.xml" file with institutions table structure;
	- lang: contains languages files for English and Portuguese (Portugal);
		
	FILES:
	- lib.php: defines all functions used for institutions management and errors generation;
	- index.php: page to display all existing institutional pages;
	- edit.php: page to add or edit an institution (can only be accessed by the administrator);
	- edit_form.php: form to add or edit an institution, used on "edit.php" file;
	- view.php: page to access an institutional page;
	- delete.php: page to delete an institution;
	- error.php: institutions error page;
	- version.php: plugin version information.

