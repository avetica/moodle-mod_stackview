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

use mod_stackview\helper;

require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
defined('MOODLE_INTERNAL') || die;

// Course_module ID.
$cmid = required_param('cmid', PARAM_INT);
$action = optional_param('action', '', PARAM_ALPHA);
$fileid = optional_param('fileid', false, PARAM_INT);

$cm = get_coursemodule_from_id('stackview', $cmid, 0, false, MUST_EXIST);
$course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);
$stackview = $DB->get_record('stackview', ['id' => $cm->instance], '*', MUST_EXIST);

require_login($course, true, $cm);

$modulecontext = context_module::instance($cm->id);
require_capability('mod/stackview:management', $modulecontext);

// Load stack instance.
$stack = new \mod_stackview\stack(0, $stackview);
$PAGE->set_url('/mod/stackview/management.php', [
    'cmid' => $cm->id,
    'action' => $action,
    'fileid' => $fileid,
]);

$PAGE->set_title(format_string($stackview->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($modulecontext);

$renderer = $PAGE->get_renderer('mod_stackview');

$PAGE->requires->js_call_amd('mod_stackview/stackview', 'init', [[]]);

$baseurl = clone $PAGE->url;
$baseurl->param('action', '');
$baseurl->param('id', '');

switch ($action) {

    case 'delete':

        break;

    case 'add':

        $form = new \mod_stackview\form\addfile($PAGE->url, [
            'context' => $modulecontext,
            'stack' => $stack,
        ]);

        if ($form->is_cancelled()) {
            redirect($baseurl);
        }

        if (($data = $form->get_data()) != false) {
            file_save_draft_area_files(
                $data->slide,
                $modulecontext->id,
                'mod_stackview',
                'slide',
                $stack->get_id(),
                helper::get_file_options());

            redirect($baseurl);
        }

        echo $OUTPUT->header();
        echo $form->render();
        echo $OUTPUT->footer();

        break;

    default:

        echo $OUTPUT->header();
        echo $renderer->get_table_stack_images($stack);
        echo $OUTPUT->footer();
}
