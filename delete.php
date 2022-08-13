<?php

/**
 * Delete institution code.
 * @copyright 2013 Bruno Sampaio
 */

require_once('../../config.php');
require_once('lib.php');
require_login();

$strinstitution = get_string('institution', 'local_institutions');
$strinstitutions = get_string('institutions', 'local_institutions');
$stradministration = get_string("administration");
$strdelete = get_string("delete");
$title = get_string('delete-institution', 'local_institutions');

$sitecontext = context_system::instance();
$id = required_param('id', PARAM_INT);	// institution id

$PAGE->set_url('/local/institutions/delete.php', array('id' => $id));
$PAGE->set_context($sitecontext);

$site = get_site();

if(!local_institutions_table_exists()) {	//Table not exists
	redirect(new moodle_url($CFG->wwwroot.'/local/institutions/error.php'));
}
else {
	$PAGE->set_title("$site->shortname: $title");

	$PAGE->navbar->add($stradministration, new moodle_url('/admin/index.php/'));
	$PAGE->navbar->add($strinstitutions, new moodle_url('/local/institutions/index.php'));
	$PAGE->navbar->add($strdelete);

	$PAGE->set_heading($site->fullname);

	echo $OUTPUT->header();
	echo $OUTPUT->heading($title);
	
	if (!$institution = $DB->get_record(INSTITUTIONS_TABLE, array("id"=>$id))) {
		echo local_institutions_print_id_error();
	}
	else if (!local_institutions_can_edit() || !has_capability('moodle/site:config', $sitecontext)) {
		echo local_institutions_print_permissions_error();
	}
	else {
		if(local_institutions_delete($id)) {
			echo html_writer::start_tag('div', array('class' => 'notifysuccess'));
				echo get_string('success-delete', 'local_institutions');
			echo html_writer::end_tag('div');
		}
		else {
			echo html_writer::start_tag('div', array('class' => 'notifyproblem'));
				echo get_string('error-delete', 'local_institutions');
			echo html_writer::end_tag('div');
		}
	}

	echo $OUTPUT->continue_button("index.php");

	echo $OUTPUT->footer();
}