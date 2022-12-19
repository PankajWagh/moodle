<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/mod/codecheckbylanguage/lib.php');

class mod_codecheckbylanguage_mod_form extends moodleform_mod {

    function definition() {
        global $CFG, $DB, $OUTPUT;

        $mform =& $this->_form;
		
		$mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('text', 'code', get_string('name', 'codecheckbylanguage'), array('size'=>'64'));
      
        $mform->setType('name', PARAM_TEXT);
		
		$mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        
		
		$options = array(
			''=>'',
			'HTML' => 'HTML',
			'CSS' => 'CSS',
			'JAVASCRIPT' => 'JAVASCRIPT',
			
			'NODE' => 'NODE',
			'PYTHON' => 'PYTHON',
			'PHP' => 'PHP',
			'TYPESCRIPT' => 'TYPESCRIPT',
		);
		$select = $mform->addElement('select', 'language', get_string('language', 'codecheckbylanguage'), $options);
		$mform->addRule('language', null, 'required', null, 'client');

        $this->standard_coursemodule_elements();

        $this->add_action_buttons();
    }
	 public function validation($data, $files) {
        $errors = parent::validation($data, $files);
	 }
}
?>