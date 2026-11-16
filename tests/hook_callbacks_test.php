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
 * Theme Neon Night - Tests that the theme keeps its own colours when the site uses colour modes.
 *
 * @package    theme_efneonnight
 * @copyright  2026 eLearning Fácil
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[\PHPUnit\Framework\Attributes\CoversClass(hook_callbacks::class)]
final class hook_callbacks_test extends \advanced_testcase {
    /**
     * Builds the hook as Boost leaves it once it has chosen a colour mode.
     *
     * @param array $attributes The attributes already added to the html tag.
     * @return before_html_attributes
     */
    private function hook_with(array $attributes): before_html_attributes {
        global $PAGE;

        $hook = new before_html_attributes($PAGE->get_renderer('core'));
        foreach ($attributes as $name => $value) {
            $hook->add_attribute($name, $value);
        }
        return $hook;
    }

    /**
     * With this theme in use, a dark or automatic colour mode is rendered as light.
     */
    public function test_colour_mode_is_always_light(): void {
        global $PAGE;
        $this->resetAfterTest();
        set_config('theme', 'efneonnight');
        $PAGE->reset_theme_and_output();

        foreach (['dark', 'auto'] as $mode) {
            $hook = $this->hook_with(['data-bs-theme' => $mode === 'auto' ? 'light' : $mode, 'data-colourmode' => $mode]);
            hook_callbacks::before_html_attributes($hook);
            $this->assertSame('light', $hook->get_attributes()['data-bs-theme']);
            $this->assertSame('light', $hook->get_attributes()['data-colourmode']);
        }
    }

    /**
     * The callback is registered: dispatching the hook through the hook manager, after a colour mode has been set,
     * leaves the page in the light colour mode.
     */
    public function test_callback_is_registered(): void {
        global $PAGE;
        $this->resetAfterTest();
        set_config('theme', 'efneonnight');
        $PAGE->reset_theme_and_output();

        $callbacks = array_column(
            \core\di::get(\core\hook\manager::class)->get_callbacks_for_hook(before_html_attributes::class),
            'priority',
            'callback',
        );
        $this->assertArrayHasKey(hook_callbacks::class . '::before_html_attributes', $callbacks);
        // Boost registers its own callback with the default priority (100): this one has to run after it.
        $this->assertLessThan(100, $callbacks[hook_callbacks::class . '::before_html_attributes']);
    }

    /**
     * Nothing is added when Boost has not set a colour mode (Moodle 5.2, or colour modes turned off).
     */
    public function test_nothing_is_added_without_colour_modes(): void {
        global $PAGE;
        $this->resetAfterTest();
        set_config('theme', 'efneonnight');
        $PAGE->reset_theme_and_output();

        $hook = $this->hook_with(['lang' => 'en']);
        hook_callbacks::before_html_attributes($hook);
        $this->assertSame(['lang' => 'en'], $hook->get_attributes());
    }

    /**
     * Other themes are left alone.
     */
    public function test_other_themes_are_left_alone(): void {
        global $PAGE;
        $this->resetAfterTest();
        set_config('theme', 'boost');
        $PAGE->reset_theme_and_output();

        $hook = $this->hook_with(['data-bs-theme' => 'dark', 'data-colourmode' => 'dark']);
        hook_callbacks::before_html_attributes($hook);
        $this->assertSame('dark', $hook->get_attributes()['data-bs-theme']);
        $this->assertSame('dark', $hook->get_attributes()['data-colourmode']);
    }
}
