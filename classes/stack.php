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
 * Stack model
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

namespace mod_stackview;
defined('MOODLE_INTERNAL') || die;

/**
 * Class stack
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 */
class stack {

    protected $record = null;

    /**
     * stack constructor.
     *
     * @param int         $id
     * @param object|null $recordraw
     *
     * @throws \dml_exception
     */
    public function __construct(int $id, ?object $recordraw) {
        global $DB;

        if ($id > 0) {
            $this->record = $DB->get_record('stackview', ['id' => $id], '*', MUST_EXIST);

            return;
        }

        $this->record = $recordraw;
    }

    /**
     * @return string
     */
    public function get_name() : string{
        return $this->record->name;
    }

}
