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
 * Library functions for the mod_quicklinks module.
 *
 * @package    mod_quicklinks
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Adds an instance of the mod_quicklinks module.
 *
 * @param stdClass $data
 * @param mod_quicklinks_mod_form $mform
 * @return int The id of the newly inserted quicklinks record
 */
function quicklinks_add_instance($data, $mform = null) {
    global $DB;

    $data->timecreated = time();

    // Insert the record into the database.
    return $DB->insert_record('quicklinks', $data);
}

/**
 * Updates an instance of the mod_quicklinks module.
 *
 * @param stdClass $data
 * @param mod_quicklinks_mod_form $mform
 * @return bool true on success, false otherwise
 */
function quicklinks_update_instance($data, $mform = null) {
    global $DB;

    $data->timemodified = time();
    $data->id = $data->instance;

    // Update the record in the database.
    return $DB->update_record('quicklinks', $data);
}

/**
 * Deletes an instance of the mod_quicklinks module.
 *
 * @param int $id
 * @return bool true on success, false otherwise
 */
function quicklinks_delete_instance($id) {
    global $DB;

    if (!$quicklinks = $DB->get_record('quicklinks', array('id' => $id))) {
        return false;
    }

    // Delete the record from the database.
    $DB->delete_records('quicklinks', array('id' => $quicklinks->id));

    return true;
}

/**
 * Return the list of view actions.
 *
 * @return array
 */
function quicklinks_get_view_actions() {
    return array('view', 'view all');
}

/**
 * Return the list of post actions.
 *
 * @return array
 */
function quicklinks_get_post_actions() {
    return array('update', 'add');
}

function mod_quicklinks_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $DB, $CFG;

    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }

    require_login($course, true, $cm);

    if ($filearea !== 'monologo') {
        return false;
    }

    $itemid = array_shift($args);
    $filename = array_pop($args);
    $filepath = '/' . implode('/', $args) . '/';

    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'mod_quicklinks', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        return false;
    }

    send_stored_file($file, 0, 0, $forcedownload, $options);
}

function mod_quicklinks_get_coursemodule_info() {


    $info = new cached_cm_info();
    $info->icon = 'quicklinks/pix/monologo.svg';
    return $info;
}
mod_quicklinks_get_coursemodule_info() ;