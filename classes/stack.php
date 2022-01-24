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

use context_module;
use moodle_url;

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

    /**
     * @var false|object|null
     */
    protected $record;

    /**
     * stack constructor.
     *
     * @param int $id
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
     * get_name
     *
     * @return string
     */
    public function get_name(): string {
        return $this->record->name;
    }

    /**
     * get_filter_code
     *
     * @return string
     * @throws \coding_exception
     */
    public function get_filter_code(): string {
        return get_string('text:embedcode', 'mod_stackview', (object) [
            'code' => '[[stackview ' . $this->get_id() . ']]',
        ]);
    }

    /**
     * get_id
     *
     * @return int
     */
    public function get_id(): int {
        return $this->record->id;
    }

    /**
     * get_images
     *
     * @return array
     * @throws \coding_exception
     */
    public function get_images(): array {

        $cm = get_coursemodule_from_instance('stackview', $this->get_id(), $this->get_course(),
            false, MUST_EXIST);

        $modulecontext = context_module::instance($cm->id);
        $fs = get_file_storage();

        $files = $fs->get_area_files($modulecontext->id, 'mod_stackview', 'slide', 0,
            'filename asc');

        $images = [];
        foreach ($files as $file) {

            if ($file->is_valid_image() === false) {
                continue;
            }

            $images[] = [
                'fileid' => $file->get_id(),
                'filename' => $file->get_filename(),
                'image' => moodle_url::make_pluginfile_url(
                    $file->get_contextid(),
                    $file->get_component(),
                    $file->get_filearea(),
                    $file->get_itemid(),
                    $file->get_filepath(),
                    $file->get_filename()
                ),
            ];
        }

        return $images;
    }

    /**
     * get_course
     *
     * @return int
     */
    private function get_course(): int {
        return $this->record->course;
    }

}
