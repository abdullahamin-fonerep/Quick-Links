<?php
defined('MOODLE_INTERNAL') || die();

require_once('../../config.php');

$cmid = required_param('id', PARAM_INT); // Course Module ID.
$cm = get_coursemodule_from_id('quicklinks', $cmid, 0, false, MUST_EXIST);
$course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);

// Set up the page.
$PAGE->set_url('/mod/quicklinks/view.php', ['id' => $cmid]);
$PAGE->set_title(format_string($cm->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->navbar->add(get_string('pluginname', 'mod_quicklinks'), new moodle_url('/mod/quicklinks/view.php', ['id' => $cmid]));

// Start output.
echo $OUTPUT->header();

// Display the title.
echo $OUTPUT->heading(format_string($cm->name));

// Hardcoded links for demonstration.
$links = [
    ['title' => 'Moodle Documentation', 'url' => 'https://docs.moodle.org/'],
    ['title' => 'Moodle Community', 'url' => 'https://moodle.org/'],
    ['title' => 'Moodle Plugins Directory', 'url' => 'https://moodle.org/plugins/'],
];
if ($data = $this->get_submitted_data()) {
    error_log(print_r($data, true)); // Log the submitted data to the PHP error log.
}
// Check if there are any links to display.
if (!empty($links)) {
    // Start the table.
    echo html_writer::start_tag('table', ['class' => 'generaltable', 'cellspacing' => '0', 'width' => '100%']);
    echo html_writer::start_tag('thead');
    echo html_writer::start_tag('tr');
    echo html_writer::tag('th', get_string('link_title', 'mod_quicklinks'), ['class' => 'header']);
    echo html_writer::tag('th', get_string('link_url', 'mod_quicklinks'), ['class' => 'header']);
    echo html_writer::end_tag('tr');
    echo html_writer::end_tag('thead');
    echo html_writer::start_tag('tbody');

    // Populate the table with hardcoded links.
    foreach ($links as $link) {
        echo html_writer::start_tag('tr');
        echo html_writer::tag('td', html_writer::link($link['url'], $link['title'], ['target' => '_blank']));
        echo html_writer::tag('td', html_writer::link($link['url'], $link['url'], ['target' => '_blank']));
        echo html_writer::end_tag('tr');
    }

    echo html_writer::end_tag('tbody');
    echo html_writer::end_tag('table');
} else {
    echo $OUTPUT->notification(get_string('no_links', 'mod_quicklinks'), 'notifymessage');
}

// Finish the page.
echo $OUTPUT->footer();