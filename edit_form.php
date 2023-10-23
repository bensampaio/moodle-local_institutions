<?php

/**
 * Edit institution form
 * @copyright 2013 Bruno Sampaio
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

class institution_edit_form extends moodleform {
    protected $institution;
    protected $context;

    function definition() {
        global $USER, $CFG, $DB;

        $mform = $this->_form;

        $institution = $this->_customdata['institution']; // this contains the data of this form
        $context   =  context_system::instance();

        $this->institution  = $institution;
        $this->context = $context;

		/// form definition with new course defaults
		//--------------------------------------------------------------------------------
        $mform->addElement('header','general', get_string('general', 'form'));

		//Fullname
        $mform->addElement('text', 'fullname', get_string('field-fullname', 'local_institutions'), 'maxlength="254" size="100"');
        $mform->addRule('fullname', get_string('missingfullname'), 'required', null, 'client');
        $mform->setType('fullname', PARAM_MULTILANG);

		//Shortname
        $mform->addElement('text', 'shortname', get_string('field-shortname', 'local_institutions'), 'maxlength="9" size="10"');
        $mform->addRule('shortname', get_string('missingshortname'), 'required', null, 'client');
        $mform->setType('shortname', PARAM_MULTILANG);

		//URL
        $mform->addElement('text', 'url', get_string('field-url', 'local_institutions'), 'maxlength="2082" size="100"');
        $mform->addRule('url', get_string('missingurl'), 'required', null, 'client');
        $mform->setType('url', PARAM_MULTILANG);

		//Icon
        $mform->addElement('text', 'icon', get_string('field-icon', 'local_institutions'), 'maxlength="2082" size="100"');
        $mform->addRule('icon', get_string('missingurl'), 'required', null, 'client');
        $mform->setType('icon', PARAM_MULTILANG);

		//Address
        $mform->addElement('text','address', get_string('field-address', 'local_institutions'),'maxlength="254"  size="100"');
        $mform->setType('address', PARAM_MULTILANG);

		//Phone
        $mform->addElement('text','phone', get_string('field-phone', 'local_institutions'),'maxlength="49"  size="20"');
        $mform->setType('phone', PARAM_RAW);

		//Description
        $mform->addElement('textarea','description', get_string('field-description', 'local_institutions'), 'wrap="virtual" rows="10" cols="100"');
        $mform->setType('description', PARAM_RAW);

		//--------------------------------------------------------------------------------
        $this->add_action_buttons();
		//--------------------------------------------------------------------------------
        
		$mform->addElement('hidden', 'id', null);
        $mform->setType('id', PARAM_INT);

		/// finally set the current form data
		//--------------------------------------------------------------------------------
        $this->set_data($institution);
	}
}

