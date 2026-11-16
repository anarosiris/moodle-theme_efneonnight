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
 * Theme Neon Night - Library.
 *
 * @package    theme_efneonnight
 * @copyright  2026 eLearning Fácil
 *             based on code from Boost Union Child by Alexander Bias and Daniel Poggenpohl
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Returns the main SCSS content: this theme's preset instead of Boost's, followed by Boost Union's own SCSS
 * (post SCSS, the external SCSS configured by the administrator and the enabled SCSS snippets).
 *
 * @param \core\output\theme_config $theme The theme config object.
 * @return string
 */
function theme_efneonnight_get_main_scss_content($theme) {
    global $CFG, $DB;

    require_once($CFG->dirroot . '/theme/boost_union/lib.php');

    // The preset carries its own imports (design system, Font Awesome, Bootstrap and Moodle),
    // so it replaces the main SCSS that Boost Union would take from Boost.
    $scss = file_get_contents($CFG->dirroot . '/theme/efneonnight/scss/fonts.scss');
    $scss .= file_get_contents($CFG->dirroot . '/theme/efneonnight/scss/preset.scss');

    // Then the same SCSS that Boost Union adds after the preset.
    $scss .= file_get_contents($CFG->dirroot . '/theme/boost_union/scss/boost_union/post.scss');
    $scss .= theme_boost_union_get_external_scss('post');
    if ($DB->get_manager()->table_exists('theme_boost_union_snippets')) {
        $scss .= \theme_boost_union\snippets::get_enabled_snippet_scss();
    }

    return $scss;
}

/**
 * Get SCSS to prepend. Moodle already adds Boost Union's pre SCSS as the parent theme's.
 *
 * @param \core\output\theme_config $theme The theme config object.
 * @return string
 */
function theme_efneonnight_get_pre_scss($theme) {
    return '';
}

/**
 * Inject additional SCSS. Moodle already adds Boost Union's extra SCSS as the parent theme's.
 *
 * @param \core\output\theme_config $theme The theme config object.
 * @return string
 */
function theme_efneonnight_get_extra_scss($theme) {
    return '';
}

/**
 * Lets Boost Union switch the CSS URL to the flavour CSS URL when a flavour applies.
 *
 * @param mixed $urls The CSS URLs (passed as reference).
 */
function theme_efneonnight_alter_css_urls(&$urls) {
    global $CFG;

    require_once($CFG->dirroot . '/theme/boost_union/lib.php');
    theme_boost_union_alter_css_urls($urls);
}
