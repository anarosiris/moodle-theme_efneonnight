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

namespace theme_efneonnight;

use core\hook\output\before_html_attributes;

/**
 * Theme Neon Night - Hook callbacks.
 *
 * @package    theme_efneonnight
 * @copyright  2026 eLearning Fácil
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class hook_callbacks {
    /**
     * Keeps the theme in its own colours when the site has turned on the experimental colour modes of Moodle 5.3.
     *
     * The theme is a complete design with a single palette. Boost's dark colour mode re-points the greyscale and the
     * design system tokens under it, which leaves parts of the theme unreadable, so the page is always rendered in
     * the light colour mode while this theme (or a child of it) is the one in use. Nothing is added to the page when
     * Boost has not set a colour mode: Moodle 5.2, or Moodle 5.3 with colour modes turned off.
     *
     * @param before_html_attributes $hook The hook object.
     */
    public static function before_html_attributes(before_html_attributes $hook): void {
        global $PAGE;

        $theme = $PAGE->theme;
        if ($theme->name !== 'efneonnight' && !in_array('efneonnight', $theme->parents, true)) {
            return;
        }

        if (!array_key_exists('data-bs-theme', $hook->get_attributes())) {
            return;
        }

        // Boost resolves "auto" in the browser from data-colourmode, so both attributes are set.
        $hook->add_attribute('data-bs-theme', 'light');
        $hook->add_attribute('data-colourmode', 'light');
    }
}
