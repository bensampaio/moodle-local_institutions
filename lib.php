<?php

/**
 * Library of useful functions
 * @copyright 2013 Bruno Sampaio
 * @package core
 * @subpackage institution
 */

defined('MOODLE_INTERNAL') || die;

define('INSTITUTIONS_TABLE', 'local_institutions');

/**
 * Verify if institutions tables exists.
 * @return bool
 */
function local_institutions_table_exists() {
	global $DB;
	
	$dbman = $DB->get_manager();
	
	return $dbman->table_exists(INSTITUTIONS_TABLE);
}

/**
 * Print Table Error
 * @return string (HTML)
 */
function local_institutions_print_table_error($classes='') {
	return 
		html_writer::start_tag('div', array('class' => "notifyproblem $classes")).
			get_string('error-database-table', 'local_institutions').
		html_writer::end_tag('div');
}

/**
 * Print Id Error
 * @return string (HTML)
 */
function local_institutions_print_id_error() {
	return 
		'<p class="errormessage">'.
			get_string('error-noid', 'local_institutions').
		'</p>';
}

/**
 * Print Permissions Error
 * @return string (HTML)
 */
function local_institutions_print_permissions_error($classes='') {
	return 
		html_writer::start_tag('div', array('class' => "notifyproblem $classes")).
			get_string('error-permissions', 'local_institutions').
		html_writer::end_tag('div');
}

/**
 * Get all institution records.
 * @return objects array
 */
function local_institutions_get_all() {
	global $DB;
	
	$institutions = $DB->get_records(INSTITUTIONS_TABLE, null, 'fullname');
	
	return $institutions;
}

/**
 * Create a institution and either return a $institution object
 *
 * Please note this functions does not verify any access control,
 * the calling code is responsible for all validation (usually it is the form definition).
 *
 * @param object $data - all the data needed for an entry in the 'institutions' table
 * @return object new institution instance
 */
function local_institutions_create($data) {
	global $DB;
	
	//check if the shortname already exist
    if (!empty($data->shortname)) {
        if ($DB->record_exists(INSTITUTIONS_TABLE, array('shortname' => $data->shortname))) {
            throw new moodle_exception('shortnametaken');
        }
    }

	$id = $DB->insert_record(INSTITUTIONS_TABLE, $data);
	$institution = $DB->get_record(INSTITUTIONS_TABLE, array('id'=>$id));
	
	add_to_log(SITEID, INSTITUTIONS_TABLE, 'new', 'view.php?id='.$id, $institution->fullname.' (ID '.$id.')');
	
	return $institution;
}

/**
 * Update an institution.
 *
 * Please note this functions does not verify any access control,
 * the calling code is responsible for all validation (usually it is the form definition).
 *
 * @param object $data  - all the data needed for an entry in the 'institution' table
 * @return void
 */
function local_institutions_update($data) {
	global $DB;
	
	// Update with the new data
    $DB->update_record(INSTITUTIONS_TABLE, $data);

	$institution = $DB->get_record(INSTITUTIONS_TABLE, array('id'=>$data->id));
	
	add_to_log($institution->id, INSTITUTIONS_TABLE, "update", "edit.php?id=$institution->id", $institution->id);
}

/**
 * Delete an institution.
 *
 * Please note this functions does not verify any access control,
 * the calling code is responsible for all validation (usually it is the form definition).
 *
 * @param object $id  - institution identifier
 * @return boolean
 */
function local_institutions_delete($id) {
	global $DB;
	
	$institution = $DB->get_record(INSTITUTIONS_TABLE, array('id'=>$id));
	if(empty($institution)) {
		return false;
	}
	else {
		$DB->delete_records(INSTITUTIONS_TABLE, array('id' => $id));
		
		add_to_log(SITEID, INSTITUTIONS_TABLE, "delete", "view.php?id=$institution->id", "$institution->fullname (ID $institution->id)");
		
		return true;
	}
}

/**
 * Can the current user edit institutions
 * @return boolean
 */
function local_institutions_can_edit() {
    global $USER;
	
    return isloggedin() && !isguestuser() && is_siteadmin($USER->id);
}