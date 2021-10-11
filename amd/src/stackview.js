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
/*eslint-disable no-console*/
define(['jquery', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js'], function ($) {

    'use strict';

    let $slick = $('#slick-slider');

    let copyToClipboard = function (containerid) {

        const el = document.createElement('textarea');
        el.value = document.getElementById(containerid).innerHTML;
        el.setAttribute('readonly', '');
        el.style.position = 'absolute';
        el.style.left = '-9999px';
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);

        alert("Copied to clipboard");
    };

    let loadSlick = function () {

        $.fn.extend({
            disableSelection: function () {
                this.each(function () {
                    this.onselectstart = function () {
                        return false;
                    };
                    this.unselectable = "on";
                    $(this).css('-moz-user-select', 'none');
                    $(this).css('-webkit-user-select', 'none');
                });
                return this;
            }
        });

        $(document).ready(function () {

            $slick.on('init reInit afterChange', function (event, slick, currentSlide) {
                let i = (currentSlide ? currentSlide : 0) + 1;
                let calc = ((i) / (slick.slideCount)) * 100;

                $('#slick-counter').text(i + '/' + slick.slideCount);
                $('#slick-progressbar').css('background-size', '100% ' + calc + '%')
                    .attr('aria-valuenow', calc);
            });

            let slider = $slick.slick({
                vertical: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: false,
                dots: false,
                speed: 1,
                arrows: false,
                swipeToSlide: false,
            });

            slider.on('wheel click', (function (e) {
                e.preventDefault();
                let $el = $(this);

                if (e.target.tagName === 'IMG' || e.target.tagName === 'DIV') {

                    if (e.type === 'click') {
                        $el.slick('slickNext');
                        return;
                    }

                    if (e.originalEvent.deltaY > 0) {
                        $el.slick('slickNext');
                    } else {
                        $el.slick('slickPrev');
                    }
                }
            }));

            $('.slick-list').before('<span class="previous-slide"><i class="fa fa-angle-up"></i></span>' +
                '<span id="slick-counter">1/' + $slick.slick("getSlick").slideCount + '</span>' +
                '<div id="slick-progressbar"></div>' +
                '<span class="next-slide"><i class="fa fa-angle-down"></i></span>');

            $('body').disableSelection();

            let touchCounter;
            $('.previous-slide').on('touchstart', (function () {
                touchCounter = setInterval(function () {
                    $slick.slick('slickPrev');
                }, 200);
            })).on('touchend', (function () {
                clearInterval(touchCounter);
                touchCounter = null;
            })).on("mousedown", function () {
                $slick.slick('slickPrev');
            });

            $('.next-slide').on('touchstart', (function () {
                touchCounter = setInterval(function () {
                    $slick.slick('slickNext');
                }, 200);
            })).on('touchend', (function () {
                clearInterval(touchCounter);
                touchCounter = null;
            })).on("mousedown", function () {
                $slick.slick('slickNext');
            });

            // Mouse click and hold.
            let clickTimeout = 0;
            $('.next-slide').on('mousedown', function () {
                clickTimeout = setInterval(function () {
                    $slick.slick('slickNext');
                }, 200);
            }).on('mouseup mouseleave', function () {
                clearTimeout(clickTimeout);
            });

            $('.previous-slide').on('mousedown', function () {
                clickTimeout = setInterval(function () {
                    $slick.slick('slickPrev');
                }, 200);
            }).on('mouseup mouseleave', function () {
                clearTimeout(clickTimeout);
            });

            $(window).on('resize orientationchange', function () {
                $slick.slick('resize');
            });

            $('.stackviewer-embedcode').on('click', function () {
                copyToClipboard("stack-code");
            });
        });
    };

    return {
        init: function () {
            // eslint-disable-next-line
            console.log('Load Stackviewer v3.9.2 (based on slick.js)');
            loadSlick();
        }
    };
});