<?php
defined('MOODLE_INTERNAL') || die;
global $CFG;

if ($hassiteconfig) {
    $ADMIN->add('localplugins',new admin_externalpage('institutionspage', get_string('institutions', 'local_institutions'), "{$CFG->wwwroot}/local/institutions/index.php"));
}