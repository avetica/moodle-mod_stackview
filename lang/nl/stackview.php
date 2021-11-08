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
$string['modulename_help'] = 'Met de stackviewer kan de cursusontwikkelaar radiologische beelden presenteren. De cursist kan door de beelden scrollen, vergelijkbaar met het gebruik van radiologische software. De beelden worden genummerd zodat over het gepresenteerde beeld een dialoog kan plaatvinden. De stackviewer kan op elke gewenste plek in een cursus geïntegreerd worden. Geaccepteerde bestandstypes: JPEG, PNG, SVG, GIF.';
$string['modulenameplural'] = 'Stackviewer';
$string['pluginadministration'] = 'Stackviewer administration';
$string['privacy:metadata'] = 'De Stackviewer plug-in slaat geen persoonlijke gegevens op.';

// Form.
$string['form:stackviewname'] = 'Naam';

// Heading.
$string['thead:icon'] = 'Bestand';
$string['thead:name'] = 'Naam';

// Buttons.
$string['btn:management'] = 'Selecteer bestanden';
$string['btn:confirm'] = 'Yes';
$string['btn:cancel'] = 'Annuleer';
$string['btn:add'] = 'Toevoegen';
$string['btn:file_management'] = 'Selecteer bestanden';

// Text.
$string['text:embedcode'] = 'Kopieer stackviewer embed code: <b id="stack-code">{$a->code}</b>
                                <span class="tooltiptext">Klik om naar het klembord te kopiëren</span>';
$string['text:no_image'] = 'Geen bestanden toegevoegd. Selecteer bestanden.';

// Form.
$string['form:file'] = 'Selecteer bestanden';
