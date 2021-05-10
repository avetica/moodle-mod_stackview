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
 * Javascript for needed to load the stackviewer
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   mod_stackview
 * @copyright 09/05/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

define(['jquery', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js'], function($) {

    'use strict';

    /**
     *
     * @param {string} containerid
     */
    let copyToClipboard = function(containerid) {

        if (window.getSelection) {
            if (window.getSelection().empty) { // Chrome
                window.getSelection().empty();
            } else if (window.getSelection().removeAllRanges) { // Firefox
                window.getSelection().removeAllRanges();
            }
        } else if (document.selection) { // IE?
            document.selection.empty();
        }

        if (document.selection) {
            let range = document.body.createTextRange();
            range.moveToElementText(document.getElementById(containerid));
            range.select().createTextRange();
            document.execCommand("copy");
        } else if (window.getSelection) {
            let range = document.createRange();
            range.selectNode(document.getElementById(containerid));
            window.getSelection().addRange(range);
            document.execCommand("copy");
        }

        alert("Copied to clipboard");
    };

    let loadSlick = function() {
        $(document).ready(function() {

            let slider = $('.slick-slider').slick({
                vertical: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: false,
                dots: true,
                speed: 1,
                arrows: false,
                swipeToSlide: false,
                customPaging: function(slider, i) {
                    return (++i);
                },
            });

            slider.on('wheel', (function(e) {
                e.preventDefault();

                if (e.originalEvent.deltaY > 0) {
                    $(this).slick('slickNext');
                } else {
                    $(this).slick('slickPrev');
                }

            })).on("beforeChange", function() {
                $(".slick-list").addClass("do-tans");
            }).on("afterChange", function() {
                $(".slick-list").removeClass("do-tans");
            });

            $('.stackviewer-embedcode').on('click', function() {
                copyToClipboard("stack-code");
            });
        });
    };

    return {
        init: function() {
            // eslint-disable-next-line
            console.log('Load Stackviewer v3.9.1 (based on slick.js)');
            loadSlick();
        }
    };
});