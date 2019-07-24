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

defined('MOODLE_INTERNAL') || die;

function report_allylti_extend_navigation_course($navigation, $course, $context) {
    global $PAGE, $COURSE;

    $canview = has_capability('report/allylti:viewcoursereport', context_course::instance($COURSE->id));
    if ($COURSE->id !== SITEID && $canview) {
        // For themes with flat menu, we deliberately add to the PAGE root navigation and not rely on a param passed
        // into this function.
        $url = new moodle_url('/report/allylti/launch.php', [
                'reporttype' => 'course',
                'report' => 'admin',
                'course' => $COURSE->id]
        );
        $icon = new pix_icon('i/ally_logo', '', 'report_allylti');
        $item = $PAGE->navigation->add(
            get_string('coursereport', 'report_allylti'),
            $url,
            navigation_node::TYPE_CUSTOM, null, null, $icon);
        $item->showinflatnavigation = true;

        // Non flat menu themes.
        $navigation->add(get_string('coursereport', 'report_allylti'), $url, navigation_node::TYPE_SETTING, null, null, $icon);
    }
}

function report_allylti_before_standard_html_head() {
    global $PAGE;
    $PAGE->requires->js_call_amd('report_allylti/main', 'init');
}