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
 *
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 10/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

namespace mod_stackview\form;

use mod_stackview\helper;

defined('MOODLE_INTERNAL') || die;
global $CFG;
require_once($CFG->libdir . '/formslib.php');

/**
 * Class form_addfile
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 10/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 */
class addfile extends \moodleform {

    /**
     * @var mixed
     */
    private $modulecontext;

    /**
     * @var \mod_stackview\stack
     */
    private $stack;

    /**
     * The constructor function calls the abstract function definition() and it will then
     * process and clean and attempt to validate incoming data.
     *
     * It will call your custom validate method to validate data and will also check any rules
     * you have specified in definition using addRule
     *
     * The name of the form (id attribute of the form) is automatically generated depending on
     * the name you gave the class extending moodleform. You should call your class something
     * like
     *
     * @param mixed $action     the action attribute for the form. If empty defaults to auto detect the
     *                          current url. If a moodle_url object then outputs params as hidden variables.
     * @param mixed $customdata if your form defintion method needs access to data such as $course
     *                          $cm, etc. to construct the form definition then pass it in this array. You can
     *                          use globals for somethings.
     *
     */
    public function __construct($action = null, $customdata = null) {
        parent::__construct($action, $customdata);

        // Init.
        $this->modulecontext = $customdata['context'];
        $this->stack = $customdata['stack'];
    }

    /**
     * Form definition. Abstract method - always override!
     */
    protected function definition() {
        $mform = &$this->_form;
        $mform->addElement('filepicker', 'slide',
            get_string('form:file', 'mod_stackview'), null, helper::get_file_options());

        $this->add_action_buttons(true, get_string('btn:add', 'mod_stackview'));
    }


    /**
     * After data
     *
     * definition_after_data
     */
    public function definition_after_data() : void {

        $draftitemid = file_get_submitted_draft_itemid('slide');
        file_prepare_draft_area(
            $draftitemid,
            $this->modulecontext->id,
            'mod_stackview',
            'slide',
            $this->stack->get_id(),
            helper::get_file_options()
        );

        // Set data.
        $this->set_data([
            'slide' => $draftitemid,
        ]);
    }
}
