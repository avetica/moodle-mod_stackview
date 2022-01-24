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
 * The task that provides a complete restore of mod_stackview is defined here.
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/stackview/backup/moodle2/restore_stackview_stepslib.php');

/**
 * Restore task for mod_stackview.
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 */
class restore_stackview_activity_task extends restore_activity_task {

    /**
     * Defines particular settings that this activity can have.
     */
    protected function define_my_settings() {

    }

    /**
     * Defines particular steps that this activity can have.
     *
     * @return void .
     * @throws base_task_exception
     */
    protected function define_my_steps(): void {
        $this->add_step(new restore_stackview_activity_structure_step('stackview_structure', 'stackview.xml'));
    }

    /**
     * Defines the contents in the activity that must be processed by the link decoder.
     *
     * @return array.
     */
    public static function define_decode_contents(): array {
        $contents = [];
        $contents[] = new restore_decode_content('stackview', ['intro']);

        return $contents;
    }

    /**
     * Defines the decoding rules for links belonging to the activity to be executed by the link decoder.
     *
     * @return array.
     */
    public static function define_decode_rules(): array {
        return [];
    }

    /**
     * Defines the restore log rules that will be applied by the
     * when restoring mod_stackview logs. It must return one array of objects.
     *
     * @return array.
     */
    public static function define_restore_log_rules(): array {
        return [];
    }

}
