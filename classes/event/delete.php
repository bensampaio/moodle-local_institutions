<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * The EVENTNAME event.
 *
 * @package    FULLPLUGINNAME
 * @copyright  2014 YOUR NAME
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace FULLPLUGINNAME\event;
defined('MOODLE_INTERNAL') || die();
/**
 * The EVENTNAME event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - PUT INFO HERE
 * }
 *
 * @since     Moodle MOODLEVERSION
 * @copyright 2014 YOUR NAME
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 **/
class EVENTNAME extends \core\event\base {
    protected function init() {
        $this->data['crud'] = 'c'; // c(reate), r(ead), u(pdate), d(elete)
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = INSTITUTIONS_TABLE;
        $this->data['other'] = array("baseurl"=>$CFG->wwwroot."/local/institutions/");
    }

    public static function get_name() {
        return get_string('eventdelete', 'local_institutions');
    }

    public function get_description() {
        return "The user with id {$this->userid} deleted an institution with id {$this->objectid}.";
    }

    public function get_url() {
        return new \moodle_url($this->other['baseurl']."/delete.php", array('parameter' => 'id', $this->objectid));
    }

    public function get_legacy_logdata() {
        // Override if you are migrating an add_to_log() call.
        global $DB;
        $institution = $DB->get_record($this->objecttable,array("id"=>$this->objectid));
        return array(SITEID, $this->objecttable, 'delete', 'view.php?id='.$this->objectid, $institution->fullname.' (ID '.$this->objectid.')');
    }
}