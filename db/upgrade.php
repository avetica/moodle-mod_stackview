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
 * Upgrade code for install
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 15/05/2022 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

/**
 * xmldb_stackview_upgrade
 *
 * @param int $oldversion
 * @return bool
 * @throws ddl_exception
 * @throws downgrade_exception
 * @throws upgrade_exception
 */
function xmldb_stackview_upgrade($oldversion): bool {
    global $DB;

    $dbman = $DB->get_manager();

    // Moodle 4.5 upgrade: Add missing fields to stackview table.
    if ($oldversion < 2025101600) {

        // Define field has_horizontal_ruler to be added to stackview.
        $table = new xmldb_table('stackview');
        $field = new xmldb_field('has_horizontal_ruler', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'introformat');

        // Conditionally launch add field has_horizontal_ruler.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field timecreated to be added to stackview.
        $field = new xmldb_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'has_horizontal_ruler');

        // Conditionally launch add field timecreated.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Stackview savepoint reached.
        upgrade_mod_savepoint(true, 2025101600, 'stackview');
    }

    return true;
}
