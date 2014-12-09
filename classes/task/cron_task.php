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
 * A scheduled task for forum cron.
 *
 * @todo MDL-44734 This job will be split up properly.
 *
 * @package    mod_forum
 * @copyright  2014 Dan Poltawski <dan@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_failmail\task;

class cron_task extends \core\task\scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('crontask', 'mod_failmail');
    }

    /**
     * Run forum cron.
     */
    public function execute() {
        global $CFG, $USER;

        $group = rand(0, 1000);

        for ($i=0; $i < 30; $i++) {
            $eventdata = new \stdClass();
            $eventdata->component           = 'mod_failmail';
            $eventdata->name                = 'tests';
            $eventdata->userfrom            = $USER;
            $eventdata->userto              = $USER;
            $eventdata->subject             = get_string('testsubject', 'mod_failmail', array('group' => $group, 'number' => ($i+1)));
            $eventdata->fullmessage         = get_string('testbody', 'mod_failmail');
            $eventdata->fullmessageformat   = FORMAT_PLAIN;
            $eventdata->fullmessagehtml     = get_string('testbody', 'mod_failmail');
            $eventdata->smallmessage        = get_string('testbody', 'mod_failmail');
            $eventdata->notification        = 1;

            $mailresult = message_send($eventdata);
        }
    }

}
