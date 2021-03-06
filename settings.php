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
 * Global settings.
 *
 * @package    local_coursetemplates
 * @category   local
 * @author     Valery Fremaux <valery.fremaux@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

// Settings default init.
if (is_dir($CFG->dirroot.'/local/adminsettings')) {
    // Integration driven code.
    require_once($CFG->dirroot.'/local/adminsettings/lib.php');
    list($hasconfig, $hassiteconfig, $capability) = local_adminsettings_access();
} else {
    // Standard Moodle code.
    $capability = 'moodle/site:config';
    $hasconfig = $hassiteconfig = has_capability($capability, context_system::instance());
}

if ($hassiteconfig) {
    // Needs this condition or there is error on login page.
    $settings = new admin_settingpage('local_massinsertmetadata', get_string('pluginname', 'local_massinsertmetadata'));
    $ADMIN->add('localplugins', $settings);

    $encoptions = array(
        'UTF-8' => 'UTF8',
        'ISO-8859-1' => 'ISO-8859-1'
    );

    $key = 'local_massinsertmetadata/encoding';
    $label = get_string('configencoding', 'local_massinsertmetadata');
    $desc = get_string('configencoding_desc', 'local_massinsertmetadata');
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, 'UTF-8', $encoptions));

    $sepoptions = array(',' => ',',
                        ';' => ';',
                        ':' => ':',
                        "\t" => '[TAB]');

    $key = 'local_massinsertmetadata/separator';
    $label = get_string('configseparator', 'local_massinsertmetadata');
    $desc = get_string('configseparator_desc', 'local_massinsertmetadata');
    $settings->add(new admin_setting_configselect($key, $label, $desc, ';', $sepoptions));

}
