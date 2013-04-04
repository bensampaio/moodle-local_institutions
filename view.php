<?php

/**
 * A page to display an institution.
 * @copyright 2013 Bruno Sampaio
 */

require_once('../../config.php');
require_once('lib.php');

$id = optional_param('id', 0, PARAM_INT);	// institution id

$site = get_site();

$strinstitution = get_string('institution', 'local_institutions');
$strinstitutions = get_string('institutions', 'local_institutions');
$strempty = get_string('no');

$PAGE->set_pagelayout('embedded');
$PAGE->set_url('/local/institutions/view.php');
$PAGE->set_context(context_system::instance());

if(!local_institutions_table_exists()) {	//Table not exists
	redirect(new moodle_url($CFG->wwwroot.'/local/institutions/error.php'));
}
else {
	$title = get_string('no-institution', 'local_institutions');
	$empty = true;
	$PAGE->navbar->add($strinstitutions, new moodle_url('/local/institutions/index.php'));
	
	if($id) {
		$institution = $DB->get_record(INSTITUTIONS_TABLE, array('id'=>$id), '*', MUST_EXIST);
	    $PAGE->url->param('id',$id);
	
		if(!empty($institution)) {
			$title = $institution->shortname;
			$empty = false;
			
			$PAGE->navbar->add($title);
			$PAGE->set_title("$site->shortname: $title");

			//now the page contents
			echo $OUTPUT->header();

			echo '<script src="effects.js"></script>';
			echo '<iframe src="'.$institution->url.'" frameborder="0" allowtransparency="true">';
				echo get_string('error-iframe', 'local_institutions');
			echo '</iframe>';
		}
	}
	
	if($empty) {
		$PAGE->navbar->add($title);
		$PAGE->set_title("$site->shortname: $title");
		$PAGE->set_heading($title);

		//now the page contents
		echo $OUTPUT->header();
		echo $OUTPUT->heading($title);
		
		echo '<p class="errormessage">'.get_string('error-noid', 'local_institutions').'</p>';
	}
	
	echo $OUTPUT->footer();
}