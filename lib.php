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
 * Library of interface functions and constants.
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

defined('MOODLE_INTERNAL') || die();

/**
 * Return if the plugin supports $feature.
 *
 * @param string $feature Constant representing the feature.
 *
 * @return true | null True if the feature is supported, null otherwise.
 */
function stackview_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:
        case FEATURE_SHOW_DESCRIPTION:
        case FEATURE_BACKUP_MOODLE2:
            return true;
        default:
            return null;
    }
}

/**
 * Saves a new instance of the mod_stackview into the database.
 *
 * Given an object containing all the necessary data, (defined by the form
 * in mod_form.php) this function will create a new instance and return the id
 * number of the instance.
 *
 * @param object                 $moduleinstance An object from the form.
 * @param mod_stackview_mod_form $mform          The form.
 *
 * @return int The id of the newly inserted record.
 */
function stackview_add_instance(object $moduleinstance, mod_stackview_mod_form $mform) {
    global $DB;
    $moduleinstance->timecreated = time();

    return $DB->insert_record('stackview', $moduleinstance);
}

/**
 * Updates an instance of the mod_stackview in the database.
 *
 * Given an object containing all the necessary data (defined in mod_form.php),
 * this function will update an existing instance with new data.
 *
 * @param object             $moduleinstance An object from the form in mod_form.php.
 * @param stackview_mod_form $mform          The form.
 *
 * @return bool True if successful, false otherwise.
 * @throws dml_exception
 */
function stackview_update_instance($moduleinstance, $mform = null) {
    global $DB;

    $moduleinstance->has_horizontal_ruler = !empty($moduleinstance->has_horizontal_ruler);
    $moduleinstance->timemodified = time();
    $moduleinstance->id = $moduleinstance->instance;

    return $DB->update_record('stackview', $moduleinstance);
}

/**
 * Removes an instance of the mod_stackview from the database.
 *
 * @param int $id Id of the module instance.
 *
 * @return bool True if successful, false on failure.
 * @throws dml_exception
 */
function stackview_delete_instance($id) {
    global $DB;

    $exists = $DB->get_record('stackview', ['id' => $id]);
    if (!$exists) {
        return false;
    }

    $DB->delete_records('stackview', ['id' => $id]);

    return true;
}

/**
 * Returns the lists of all browsable file areas within the given module context.
 *
 * The file area 'intro' for the activity introduction field is added automatically
 *
 * @param stdClass $course  .
 * @param stdClass $cm      .
 * @param stdClass $context .
 *
 * @return string[].
 * @package     mod_stackview
 * @category    files
 *
 */
function stackview_get_file_areas($course, $cm, $context) {
    return [
        'slides' => 'slides',
    ];
}

/**
 * Serves the files from the mod_stackview file areas.
 *
 * @param stdClass $course        The course object.
 * @param stdClass $cm            The course module object.
 * @param stdClass $context       The mod_stackview's context.
 * @param string   $filearea      The name of the file area.
 * @param array    $args          Extra arguments (itemid, path).
 * @param bool     $forcedownload Whether or not force download.
 * @param array    $options       Additional options affecting the file serving.
 *
 * @return bool
 * @throws \coding_exception
 * @package     mod_stackview
 * @category    files
 */
function stackview_pluginfile(object $course, object $cm, $context, $filearea, $args, $forcedownload, array $options = []) {

    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }

    require_course_login($course, true, $cm);
    if (!has_capability('mod/stackview:view', $context)) {
        return false;
    }

    $itemid = (int)array_shift($args);

    $fs = get_file_storage();
    $relativepath = implode('/', $args);
    $fullpath = "/$context->id/mod_stackview/$filearea/$itemid/$relativepath";
    if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
        return false;
    }

    // Finally send the file.
    // For folder module, we force download file all the time.
    send_stored_file($file, 0, 0, true, $options);
}
