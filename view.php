<?php

/**
 * A page to display an institution.
 * @copyright 2022 Esdras Caçeb
 * TODO exibir instituição
 */

require_once('../../config.php');
require_once('lib.php');

$id = required_param('id', PARAM_INT);	// institution id

$site = get_site();

$strinstitution = get_string('institution', 'local_institutions');
$strinstitutions = get_string('institutions', 'local_institutions');
$strempty = get_string('no');

$PAGE->set_url('/local/institutions/view.php');
$PAGE->set_context(context_system::instance());

if(!local_institutions_table_exists()) {	//Table not exists
	redirect(new moodle_url($CFG->wwwroot.'/local/institutions/error.php'));
}
else {
	$title = get_string('no-institution', 'local_institutions');
	$PAGE->navbar->add($strinstitutions, new moodle_url('/local/institutions/index.php'));
	
	$institution = $DB->get_record(INSTITUTIONS_TABLE, array('id'=>$id), '*', MUST_EXIST);
	$PAGE->url->param('id',$id);
	
	if(!empty($institution)) {
		$title = $institution->shortname;
		
		$PAGE->navbar->add($title);
		$PAGE->set_title("$site->shortname: $title");

		//now the page contents
		echo $OUTPUT->header();
		echo html_writer::start_tag('div', array('class'=>'institutionbox clearfix'));

		//Institution Name
		echo html_writer::start_tag('h3', array('class'=>'name'));
		echo html_writer::link($institution->url, $institution->fullname,array("target"=>"_blank"));
		echo "</br>";
		//Institution Icon
		echo html_writer::link($institution->url, '<img src="'.$institution->icon.'" style="max-height:100px; max-width:200px;" alt="'.$institution->shortname.'"/>', array('class' => '',"target"=>"_blank"));
		echo html_writer::end_tag('h3');

		//Institution Address
		if(!empty($institution->address)) {
			echo '<p class="address"><b>'.get_string('address').'</b>: '.$institution->address.'</p>';
		}

		//Institution Phone
		if(!empty($institution->phone)) {
			echo '<p class="phone"><b>'.get_string('phone').'</b>: '.$institution->phone.'</p>';
		}

		

		//Institution Description
		echo html_writer::start_tag('div', array('class'=>'summary'));
		echo '<p>'.$institution->description.'</p>';
		echo html_writer::end_tag('div');



		echo html_writer::end_tag('div');
		if(is_siteadmin()) {
			echo html_writer::start_tag('div', array('class'=>'options'));

				//Edit
				$options = array('title' => get_string('edit'));
				$image = '<img src="'.$OUTPUT->pix_url('t/edit').'" alt="'.$options['title'].'" />';
				echo html_writer::link(new moodle_url('edit.php', $url_options), $image, $options);

				//Delete
				$options = array('title' => get_string('delete'));
				$image = $OUTPUT->pix_icon('t/delete','delete');

				echo html_writer::link(new moodle_url('delete.php', $url_options), $image, $options);

			echo html_writer::end_tag('div');
		}
		
	}
	else {
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