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
 * Prints an instance of mod_stackview.
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');

//require_once(__DIR__ . "/../../repository/lib.php");
//require_once("$CFG->libdir/filelib.php");

defined('MOODLE_INTERNAL') || die;

// Course_module ID.
$id = optional_param('id', 0, PARAM_INT);
$g = optional_param('g', 0, PARAM_INT);
$action = optional_param('action', '', PARAM_ALPHA);

if ($id) {
    $cm = get_coursemodule_from_id('stackview', $id, 0, false, MUST_EXIST);
    $course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);
    $stackview = $DB->get_record('stackview', ['id' => $cm->instance], '*', MUST_EXIST);
} else if ($g) {
    $stackview = $DB->get_record('stackview', ['id' => $g], '*', MUST_EXIST);
    $course = $DB->get_record('course', ['id' => $stackview->course], '*', MUST_EXIST);
    $cm = get_coursemodule_from_instance('stackview', $stackview->id, $course->id, false, MUST_EXIST);
} else {
    print_error(get_string('missingidandcmid', mod_stackview));
}

require_login($course, true, $cm);

$modulecontext = context_module::instance($cm->id);

$event = \mod_stackview\event\course_module_viewed::create([
    'objectid' => $stackview->id,
    'context' => $modulecontext,
]);
$event->add_record_snapshot('course', $course);
$event->add_record_snapshot('stackview', $stackview);
$event->trigger();

// Load stack instance.
$stack = new \mod_stackview\stack(0 , $stackview);

$PAGE->set_url('/mod/stackview/view.php', [
    'id' => $cm->id,
    'action' => $action,
    'g' => $g,
]);

$PAGE->set_title(format_string($stackview->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($modulecontext);

$renderer = $PAGE->get_renderer('mod_stackview');

switch ($action) {
    case 'embedded':

        break;

    default:

        echo $OUTPUT->header();
        echo $renderer->render_stack($stack);
        echo $OUTPUT->footer();
}
