<?php
defined('MOODLE_INTERNAL') || die;
// Include lib.php to access custom functions
require_once($CFG->dirroot . '/local/emailsender/lib.php');
if ($hassiteconfig) {
    $settings = new admin_settingpage('local_emailsender', get_string('pluginname', 'local_emailsender'));

    // Heading for the settings page
    $settings->add(new admin_setting_heading(
        'local_emailsender_settings',
        get_string('pluginname', 'local_emailsender'),
        get_string('settingsdesc', 'local_emailsender')
    ));

    // Email address setting
    $settings->add(new admin_setting_configtext(
        'local_emailsender_testemail',
        get_string('testemail', 'local_emailsender'),
        get_string('testemail_desc', 'local_emailsender'),
        '', // Default value
        PARAM_EMAIL
    ));

    // Email message setting
    $settings->add(new admin_setting_configtextarea(
        'local_emailsender_testmessage',
        get_string('testmessage', 'local_emailsender'),
        get_string('testmessage_desc', 'local_emailsender'),
        '', // Default value
        PARAM_TEXT
    ));

    // Email subject setting
    $settings->add(new admin_setting_configtext(
        'local_emailsender_subject',
        get_string('testsubject', 'local_emailsender'),
        get_string('testsubject_desc', 'local_emailsender'),
        'Test Email from Moodle', // Default subject
        PARAM_TEXT
    ));

    $ADMIN->add('localplugins', $settings);

    // Check if settings are being saved and send an email
    if ($data = data_submitted() && confirm_sesskey()) {
        $recipient = ''; 
        $message = optional_param('local_emailsender_testmessage', 'Default message content', PARAM_TEXT);
        $subject = optional_param('local_emailsender_subject', 'Test Email from Moodle', PARAM_TEXT);
        $from = get_config('local_emailsender', 'testemail') ?: $CFG->noreplyaddress; // Default from address

        if ($recipient && $message) {
            // Call custom SMTP email sender function
            if (my_custom_smtp_email_sender($recipient, $from, $subject, $message)) {
                echo $OUTPUT->notification(get_string('emailsent', 'local_emailsender'), 'notifsuccess');
            } else {
                echo $OUTPUT->notification(get_string('emailfailed', 'local_emailsender'), 'notiferror');
            }
        }
    }
}
