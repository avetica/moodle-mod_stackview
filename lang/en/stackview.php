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
 * Plugin EN strings are defined here.
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/
defined('MOODLE_INTERNAL') || die;

$string['pluginname'] = 'Stackviewer';
$string['modulename'] = 'Stackviewer';
$string['modulename_help'] = 'Met de stackviewer kan de cursusontwikkelaar radiologische beelden presenteren. De cursist kan door de beelden scrollen, vergelijkbaar met het gebruik van radiologische software. De beelden worden genummerd zodat over het gepresenteerde beeld een dialoog kan plaatvinden. De stackviewer kan op elke gewenste plek in een cursus geïntegreerd worden. Geaccepteerde bestandstypes: JPEG, PNG, SVG, TIFF, GIF.';
$string['modulenameplural'] = 'Stackviewer';
$string['pluginadministration'] = 'Stackviewer administration';
$string['privacy:metadata'] = 'The mod_stackview plugin does not store any personal data.';

// Form.
$string['form:stackviewname'] = 'Name';

// Heading.
$string['thead:icon'] = 'Image';
$string['thead:name'] = 'Name';

// Buttons.
$string['btn:management'] = 'Management Stackview';
$string['btn:confirm'] = 'Yes';
$string['btn:cancel'] = 'Cancel';
$string['btn:add'] = 'Add';
$string['btn:file_management'] = 'File management';

// Text.
$string['text:embedcode'] = 'Filter embed code: <b id="stack-code">{$a->code}</b>
                                <span class="tooltiptext">Click to copy to clipboard</span>';
$string['text:no_image'] = 'There are no images added.';

// Form.
$string['form:file'] = 'Select file';
