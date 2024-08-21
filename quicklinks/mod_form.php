<?php
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');
require_once($CFG->dirroot . '/course/moodleform_mod.php');

class mod_quicklinks_mod_form extends moodleform_mod {

    function definition() {
        $mform = $this->_form;

        // Section header title according to language file.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Add a text input for the name of the quicklinks module.
        $mform->addElement('text', 'name', get_string('name', 'mod_quicklinks'), ['size' => '64']);
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        // Add a select menu for the number of links.
        $options = array_combine(range(1, 5), range(1, 5));
        $mform->addElement('select', 'quicklinks_num_links', get_string('num_links', 'mod_quicklinks'), $options);
        $mform->setDefault('quicklinks_num_links', 3);
        $mform->addHelpButton('quicklinks_num_links', 'num_links', 'mod_quicklinks');

        // Add the initial link fields.
        $num_links = $this->get_num_links();
        $this->render_link_fields($mform, $num_links);

        // Add JavaScript to dynamically update the form when the number of links is changed.
        $this->add_dynamic_js();

        // Standard Moodle course module elements (course, category, etc.).
        $this->standard_coursemodule_elements();

        // Standard Moodle form buttons.
        $this->add_action_buttons();
    }

    /**
     * Get the number of links from the form data or default value.
     * 
     * @return int
     */
    protected function get_num_links() {
        if ($data = $this->get_submitted_data()) {
            return isset($data->quicklinks_num_links) ? (int)$data->quicklinks_num_links : 3;
        }
        return 3;
    }

    /**
     * Render the link title and URL fields based on the selected number of links.
     * 
     * @param MoodleQuickForm $mform
     * @param int $num_links
     */
    protected function render_link_fields($mform, $num_links) {
        for ($i = 1; $i <= $num_links; $i++) {
            $mform->addElement('text', "link_title_$i", get_string('link_title', 'mod_quicklinks', $i));
            $mform->setType("link_title_$i", PARAM_TEXT);
            $mform->addHelpButton("link_title_$i", 'link_title', 'mod_quicklinks');

            $mform->addElement('text', "link_url_$i", get_string('link_url', 'mod_quicklinks', $i));
            $mform->setType("link_url_$i", PARAM_URL);
            $mform->addHelpButton("link_url_$i", 'link_url', 'mod_quicklinks');
        }
    }

    /**
     * Add JavaScript to dynamically update the form when the number of links is changed.
     */
    protected function add_dynamic_js() {
        global $PAGE;

        $js = <<<JS
        require(['jquery'], function($) {
            $('#id_quicklinks_num_links').change(function() {
                this.form.submit();
            });
        });
JS;
        $PAGE->requires->js_init_code($js);
    }
}