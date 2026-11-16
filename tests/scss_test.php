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

/**
 * Theme Neon Night - Tests that the theme loads and its SCSS compiles.
 *
 * @package    theme_efneonnight
 * @copyright  2026 eLearning Fácil
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[\PHPUnit\Framework\Attributes\CoversFunction('theme_efneonnight_get_main_scss_content')]
final class scss_test extends \advanced_testcase {
    /**
     * The theme is a Boost Union child and uses the expected callbacks.
     */
    public function test_theme_config(): void {
        $theme = \core\output\theme_config::load('efneonnight');
        $this->assertSame('efneonnight', $theme->name);
        $this->assertSame(['boost_union', 'boost'], $theme->parents);
        $this->assertSame('theme_efneonnight_get_extra_scss', $theme->extrascsscallback);
        $this->assertSame('theme_efneonnight_get_pre_scss', $theme->prescsscallback);
    }

    /**
     * The main SCSS is the preset (with Moodle's imports) followed by Boost Union's post SCSS.
     */
    public function test_main_scss_content(): void {
        $theme = \core\output\theme_config::load('efneonnight');
        $scss = theme_efneonnight_get_main_scss_content($theme);
        $this->assertStringContainsString('@import "design-system";', $scss);
        $this->assertStringContainsString('@import "fontawesome";', $scss);
        $this->assertStringContainsString('@import "bootstrap";', $scss);
        $this->assertStringContainsString('@import "moodle";', $scss);
        // Boost Union's post SCSS comes after the preset.
        global $CFG;
        $post = file_get_contents($CFG->dirroot . '/theme/boost_union/scss/boost_union/post.scss');
        $this->assertStringContainsString(substr($post, 0, 300), substr($scss, strpos($scss, '@import "moodle";')));
    }

    /**
     * The SCSS compiles without errors (a compilation error would make Moodle fall back to the backup CSS).
     */
    public function test_scss_compiles(): void {
        $this->resetAfterTest();
        $theme = \core\output\theme_config::load('efneonnight');
        $compile = new \ReflectionMethod($theme, 'get_css_content_from_scss');
        $css = $compile->invoke($theme, false);
        // False means the compiler failed (Moodle also emits a debugging message, which fails the test).
        $this->assertIsString($css);
        $this->assertGreaterThan(500000, strlen($css));
        $this->assertStringContainsString('.navbar', $css);
    }
}
