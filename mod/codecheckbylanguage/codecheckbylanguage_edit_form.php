<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/mod/codecheckbylanguage/lib.php');

class codecheckbylanguage_edit_form extends moodleform {
	
	public  $filecontent='';

    function definition() {
        global $CFG, $DB, $OUTPUT;

        $mform =& $this->_form;
		
		$mform->addElement('textarea', 'code', get_string("code", "codecheckbylanguage"), 'wrap="virtual" rows="20" cols="50" style="width:100%"');
		$mform->addRule('code', null, 'required');
		
		$mform->addElement('submit', 'CodeCheck', get_string("runcode", "codecheckbylanguage"));
		
		
	
		
		
        
    }
	 public function validation($data, $files) {
        $errors = parent::validation($data, $files);
	 }
}
?>