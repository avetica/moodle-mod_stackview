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
 * Backup steps for mod_stackview are defined here.
 *
 * For more information about the backup and restore process, please visit:
 * https://docs.moodle.org/dev/Backup_2.0_for_developers
 * https://docs.moodle.org/dev/Restore_2.0_for_developers
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 */

/**
 * Define the complete structure for backup, with file and id annotations.
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 */
class backup_stackview_activity_structure_step extends backup_activity_structure_step {

    /**
     * Defines the structure of the resulting xml file.
     *
     * @return backup_nested_element The structure wrapped by the common 'activity' element.
     * @throws base_element_struct_exception
     * @throws base_step_exception
     */
    protected function define_structure(): backup_nested_element {

        // Define each element separated.
        $stackview = new backup_nested_element('stackview', ['id'], [
            'name',
            'intro',
            'introformat',
            'timemodified',
        ]);
        // Define sources.
        $stackview->set_source_table('stackview', ['id' => backup::VAR_ACTIVITYID]);

        // Define file annotations.
        $stackview->annotate_files('mod_stackview', 'intro', null);
        $stackview->annotate_files('mod_stackview', 'slide', null);

        // Return the root element (stackview), wrapped into standard activity structure.
        return $this->prepare_activity_structure($stackview);
    }

}
