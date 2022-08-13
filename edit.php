<?php

/**
 * Edit institution settings
 * @copyright 2013 Bruno Sampaio
 */

require_once('../../config.php');
require_once('lib.php');
require_once('edit_form.php');
require_login();

$id = optional_param('id', 0, PARAM_INT);	// institution id

$site = get_site();

$strinstitution = get_string('institution', 'local_institutions');
$strinstitutions = get_string('institutions', 'local_institutions');
$straddinstitution = get_string('add-institution', 'local_institutions');
$streditinstitution = get_string('edit-institution', 'local_institutions');
$stradministration = get_string("administration");

$PAGE->set_pagelayout('admin');
$PAGE->set_url('/local/institutions/edit.php');
$PAGE->set_context(context_system::instance());

$sitecontext = context_system::instance();
if(has_capability('moodle/site:config', $sitecontext)) {
	
	if(!local_institutions_table_exists()) {	//Table not exists
		redirect(new moodle_url($CFG->wwwroot.'/local/institutions/error.php'));
	}
	else {
		// basic access control checks
		if($id) { // editing institution
			$institution = $DB->get_record(INSTITUTIONS_TABLE, array('id'=>$id), '*', MUST_EXIST);
		    $PAGE->url->param('id',$id);
		}
		else {
			$institution = array();
		}

		// first create the form
		$editform = new institution_edit_form(NULL, array('institution'=>$institution));
		if($editform->is_cancelled()) {
			redirect(new moodle_url($CFG->wwwroot.'/local/institutions/'));
		} 
		else if($data = $editform->get_data()) {
		    // process data if submitted

			if(empty($institution->id)) {

		        // Create the institution
		        $institution = local_institutions_create($data);

		    } else {
		        // Update the institution
		        local_institutions_update($data);
		    }
		    redirect(new moodle_url($CFG->wwwroot.'/local/institutions/view.php?id='.$institution->id));
		}

		$PAGE->navbar->add($stradministration, new moodle_url('/admin/index.php'));
		$PAGE->navbar->add($straddinstitution, new moodle_url('/local/institutions/index.php'));

		if (!empty($institution->id)) {
		    $PAGE->navbar->add($streditinstitution);
		    $title = "$site->shortname: $streditinstitution";
		    $fullname = $institution->fullname;
		} else {
		    $PAGE->navbar->add($straddinstitution);
		    $title = "$site->shortname: $straddinstitution";
		    $fullname = $site->fullname;
		}

		$PAGE->set_title($title);
		$PAGE->set_heading($fullname);

		echo $OUTPUT->header();
		echo $OUTPUT->heading($streditinstitution);

		// Print the form
		$editform->display();

		echo $OUTPUT->footer();
	}
} 
else {
	redirect(new moodle_url($CFG->wwwroot));
}


