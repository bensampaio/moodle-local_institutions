<?php

/**
 * A page displaying institutions.
 * @copyright 2013 Bruno Sampaio
 */

require_once('../../config.php');
require_once('lib.php');

$strinstitutions = get_string('institutions', 'local_institutions');
$straddnewinstitution = get_string('add-institution', 'local_institutions');
$can_edit = local_institutions_can_edit();

$site = get_site();

$url = new moodle_url('/local/institutions/index.php');
$PAGE->set_url($url);

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');

if(!local_institutions_table_exists()) {	//Table not exists
	redirect(new moodle_url($CFG->wwwroot.'/local/institutions/error.php'));
}
else {
	$PAGE->navbar->add($strinstitutions);
	$PAGE->set_title("$site->shortname: $strinstitutions");
	$PAGE->set_heading($strinstitutions);

	//now the page contents
	echo $OUTPUT->header();

	echo $OUTPUT->box_start('institutionboxes');
	
	$institutions = local_institutions_get_all();
	
	//Buttons
	if($can_edit) {
		echo $OUTPUT->container_start('buttons');
			echo $OUTPUT->single_button(new moodle_url('edit.php'), $straddnewinstitution, 'get');
		echo $OUTPUT->container_end();
	}
	
	//Table is empty
	if(empty($institutions)) {	
		echo html_writer::start_tag('div', array('class' => 'empty'));
			echo get_string('warning-empty', 'local_institutions');
		echo html_writer::end_tag('div');
	}
	else {
		echo html_writer::start_tag('ul', array('class'=>'unlist'));
		foreach ($institutions as $institution) {
			$url_options = array('id' => $institution->id);
			
			echo html_writer::start_tag('li');
				echo html_writer::start_tag('div', array('class'=>'institutionbox clearfix'));
                	echo html_writer::start_tag('div', array('class'=>'info'));

					//Institution Name
				    echo html_writer::start_tag('h3', array('class'=>'name'));
						echo html_writer::link(new moodle_url('view.php', $url_options), $institution->fullname);
					echo html_writer::end_tag('h3');

					//Institution Address
					if(!empty($institution->address)) {
						echo '<p class="address"><b>'.get_string('address').'</b>: '.$institution->address.'</p>';
					}

					//Institution Phone
					if(!empty($institution->phone)) {
						echo '<p class="phone"><b>'.get_string('phone').'</b>: '.$institution->phone.'</p>';
					}

					//Institution Icon
					echo html_writer::link(new moodle_url('view.php', $url_options), '<img src="'.$institution->icon.'" alt="'.$institution->shortname.'"/>', array('class' => 'icon'));

				echo html_writer::end_tag('div');

				//Institution Description
				echo html_writer::start_tag('div', array('class'=>'summary'));
					echo '<p>'.$institution->description.'</p>';
				echo html_writer::end_tag('div');

				//Institution Options
				if($can_edit) {
					echo html_writer::start_tag('div', array('class'=>'options'));

						//Edit
						$options = array('title' => get_string('edit'));
						$image = '<img src="'.$OUTPUT->pix_url('t/edit').'" alt="'.$options['title'].'" />';
						echo html_writer::link(new moodle_url('edit.php', $url_options), $image, $options);

						//Delete
						$options = array('title' => get_string('delete'));
						$image = '<img src="'.$OUTPUT->pix_url('t/delete').'" alt="'.$options['title'].'" />';
						echo html_writer::link(new moodle_url('delete.php', $url_options), $image, $options);

					echo html_writer::end_tag('div');
				}
			echo html_writer::end_tag('li');
        }
		echo html_writer::end_tag('ul');
	}
	
	echo $OUTPUT->box_end();

	echo $OUTPUT->footer();
}


