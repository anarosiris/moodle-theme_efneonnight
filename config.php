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
 * Theme Neon Night - Theme config.
 *
 * Child theme of Boost Union: it inherits Boost Union's layouts, settings and features
 * (block regions, smart menus, flavours...) and only replaces the theme preset.
 * Based on Boost Union Child by Alexander Bias and Daniel Poggenpohl.
 *
 * @package    theme_efneonnight
 * @copyright  2026 eLearning Fácil
 *             based on code from Boost Union Child by Alexander Bias and Daniel Poggenpohl
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Theme config file, not a page: no login check here.
// phpcs:ignore moodle.Files.RequireLogin.Missing
require($CFG->dirroot . '/theme/boost_union/config.php');

$THEME->name = 'efneonnight';
$THEME->scss = function ($theme) {
    return theme_efneonnight_get_main_scss_content($theme);
};
$THEME->parents = ['boost_union', 'boost'];
$THEME->extrascsscallback = 'theme_efneonnight_get_extra_scss';
$THEME->prescsscallback = 'theme_efneonnight_get_pre_scss';
$THEME->rendererfactory = 'theme_overridden_renderer_factory';

// Boost Union settings that Moodle reads from the active theme: copy them over.
foreach (['unaddableblocks', 'scss', 'scsspre'] as $efneonnightsetting) {
    $efneonnightvalue = get_config('theme_boost_union', $efneonnightsetting);
    if (!empty($efneonnightvalue)) {
        $THEME->settings->{$efneonnightsetting} = $efneonnightvalue;
    }
}
unset($efneonnightsetting, $efneonnightvalue);
