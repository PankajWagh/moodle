<?php

defined('MOODLE_INTERNAL') || die();

function codecheckbylanguage_add_instance($codecheckbylanguage) {
    global $DB;

	$cmid = $codecheckbylanguage->coursemodule;
	
	$codecheckbylanguage->timecreated  = time();
    $codecheckbylanguage->timemodified = $codecheckbylanguage->timecreated;
    $id = $DB->insert_record("codecheckbylanguage", $codecheckbylanguage);
	$DB->set_field('course_modules', 'instance', $id, array('id'=>$cmid));
    return $id;

}

function codecheckbylanguage_update_instance($codecheckbylanguage) {
    global $DB;
    $codecheckbylanguage->timemodified = time();
    $id = $DB->update_record("codecheckbylanguage", $codecheckbylanguage);
	
    return $id;

}

function codecheckbylanguage_delete_instance($id) {
   global $CFG, $DB;

    if (! $codecheckbylanguage = $DB->get_record('codecheckbylanguage', array('id' => $id))) {
        return false;
    }
	 $result = true;
	
	 if (! $DB->delete_records('codecheckbylanguage', array('id' => $codecheckbylanguage->id))) {
        $result = false;
    }
	return $result;
}