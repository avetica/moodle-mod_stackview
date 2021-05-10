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
 * Rendering UI methods
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

defined('MOODLE_INTERNAL') || die;

/**
 * Class mod_stackview_renderer
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 */
class mod_stackview_renderer extends plugin_renderer_base {

    /**
     * render_stack
     *
     * @param \mod_stackview\stack $stack
     *
     * @return bool|string
     * @throws \moodle_exception
     */
    public function render_stack(\mod_stackview\stack $stack) {
        $context = (new \mod_stackview\output\stackview_output($stack))
            ->export_for_template($this);

        return $this->render_from_template('mod_stackview/stackview', $context);
    }

    /**
     * Get embed code
     *
     * @param \mod_stackview\stack $stack
     *
     * @return string
     * @throws \coding_exception
     */
    public function show_filter_code(\mod_stackview\stack $stack) : string {
        global $PAGE;

        if (has_capability('mod/stackview:management', $PAGE->cm->context)) {
            return html_writer::div($stack->get_filter_code() , 'stackviewer-embedcode');
        }

        return '';
    }

    /**
     * Get stack images table
     *
     * @param \mod_stackview\stack $stack
     *
     * @return string
     * @throws \moodle_exception
     */
    public function get_table_stack_images(\mod_stackview\stack $stack) : string{
        $context = (new \mod_stackview\output\stackview_images_output($stack))
            ->export_for_template($this);

        return $this->render_from_template('mod_stackview/stackview_table', $context);
    }

}
