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
 * Output a stackview_images_output
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

namespace mod_stackview\output;
defined('MOODLE_INTERNAL') || die;

use mod_stackview\stack;
use moodle_url;
use renderable;
use renderer_base;
use templatable;

/**
 * Class stackview_images_output
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 */
class stackview_images_output implements renderable, templatable {

    /**
     * @var \mod_stackview\stack
     */
    private $stack;

    /**
     * stackview_images_output constructor.
     *
     * @param \mod_stackview\stack $stack
     */
    public function __construct(stack $stack) {
        $this->stack = $stack;
    }

    /**
     * @param \renderer_base $output
     *
     * @return object
     * @throws \coding_exception
     * @throws \moodle_exception
     */
    public function export_for_template(renderer_base $output) : object {
        global $PAGE;
        $params = $PAGE->url->params();

        return (object)[
            'name' => $this->stack->get_name(),
            'files' => $this->stack->get_images(),
            'addurl' => (new moodle_url('/mod/stackview/management.php', ['action' => 'add'] + $params))
                ->out(false),
        ];
    }

}
