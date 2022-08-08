<?php

namespace local_institutions\event;
defined('MOODLE_INTERNAL') || die();

class institution_created extends \core\event\base {
    protected function init() {
        global $CFG;
        $this->data['crud'] = 'c'; // c(reate), r(ead), u(pdate), d(elete)
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = "local_institutions";
        $this->data['other'] = array("baseurl"=>$CFG->wwwroot."/local/institutions/");
    }

    public static function get_name() {
        return get_string('eventinstitutioncreated', 'local_institutions');
    }

    public function get_description() {
        return "The user with id {$this->userid} created an institution with id {$this->objectid}.";
    }

    public function get_url() {
        return new \moodle_url($this->other['baseurl']."/edit.php");
    }

    public function get_legacy_logdata() {
        // Override if you are migrating an add_to_log() call.
        global $DB;
        $institution = $DB->get_record($this->objecttable,array("id"=>$this->objectid));
        return array(SITEID, $this->objecttable, 'new', 'view.php?id='.$this->objectid, $institution->fullname.' (ID '.$this->objectid.')');
    }

}