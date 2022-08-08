<?php

namespace local_institutions\event;
defined('MOODLE_INTERNAL') || die();

class institution_updated extends \core\event\base {
    protected function init() {
        $this->data['crud'] = 'u'; // c(reate), r(ead), u(pdate), d(elete)
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = "local_institutions";
        $this->data['other'] = array("baseurl"=>$CFG->wwwroot."/local/institutions/");
    }

    public static function get_name() {
        return get_string('eventinstitutiondeleted', 'local_institutions');
    }

    public function get_description() {
        return "The user with id {$this->userid} updated an institution with id {$this->objectid}.";
    }

    public function get_url() {
        return new \moodle_url($this->other['baseurl']."/edit.php", array('parameter' => 'id', $this->objectid));
    }

    public function get_legacy_logdata() {
        // Override if you are migrating an add_to_log() call.
        return array($this->objectid, $this->objecttable, "update", "edit.php?id=$this->objectid", $this->objectid);
    }
}