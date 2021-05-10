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
 * Stack management
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
defined('MOODLE_INTERNAL') || die;

// Course_module ID.
$id = required_param('cmid', PARAM_INT);
$action = optional_param('action', '', PARAM_ALPHA);

$cm = get_coursemodule_from_id('stackview', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);
$stackview = $DB->get_record('stackview', ['id' => $cm->instance], '*', MUST_EXIST);

require_login($course, true, $cm);

$modulecontext = context_module::instance($cm->id);
require_capability('mod/stackview:management', $modulecontext);

// Load stack instance.
$stack = new \mod_stackview\stack(0, $stackview);
$PAGE->set_url('/mod/stackview/view.php', [
    'id' => $cm->id,
    'action' => $action,
]);

$PAGE->set_title(format_string($stackview->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($modulecontext);

$renderer = $PAGE->get_renderer('mod_stackview');

$PAGE->requires->js_call_amd('mod_stackview/stackview', 'init', [[]]);

switch ($action) {

    case 'edit':

        break;

    default:

        echo $OUTPUT->header();
        echo $renderer->get_table_stack_images($stack);
        echo $OUTPUT->footer();
}
