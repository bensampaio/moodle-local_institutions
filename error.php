<?php

/**
 * Institutions Error Page
 * @copyright 2013 Bruno Sampaio
 */

require_once('../../config.php');
require_once('lib.php');

$site = get_site();

$strinstitution = get_string('institution', 'local_institutions');
$strinstitutions = get_string('institutions', 'local_institutions');
$strinstitutionerror = get_string('error-institution', 'local_institutions');
$strerror = get_string('error');

$PAGE->set_pagelayout('admin');
$PAGE->set_url('/local/institutions/error.php');
$PAGE->set_context(context_system::instance());

if(local_institutions_table_exists()) {
	redirect(new moodle_url($CFG->wwwroot.'/local/institutions/'));
}
else {
	$PAGE->navbar->add($strinstitutions, new moodle_url('/local/institutions/index.php'));
	$PAGE->navbar->add($strerror);

	$PAGE->set_title("$site->shortname: $strinstitutionerror");
	$PAGE->set_heading("$strinstitutionerror");

	echo $OUTPUT->header();
	echo $OUTPUT->heading("$strinstitutionerror");
	
	echo local_institutions_print_table_error();
	
	echo $OUTPUT->footer();
}