<?php
require_once('../../config.php');
require_once('lib.php');
require_once('codecheckbylanguage_edit_form.php');

$id = required_param('id', PARAM_INT);    // Course Module ID

if (!$cm = get_coursemodule_from_id('codecheckbylanguage', $id)) {
    print_error('Course Module ID was incorrect'); // NOTE this is invalid use of print_error, must be a lang string id
}
if (!$course = $DB->get_record('course', array('id'=> $cm->course))) {
    print_error('course is misconfigured');  // NOTE As above
}
if (!$codecheckbylanguage = $DB->get_record('codecheckbylanguage', array('id'=> $cm->instance))) {
    print_error('course module is incorrect'); // NOTE As above
}

// Check login and get context.
require_login($course, false, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/codecheckbylanguage:view', $context);


$args = array(
    'course' => $course,
    'codecheckbylanguage' => $codecheckbylanguage,
	'filecontent'=>'',
	
	
);
$formurl = new moodle_url("/mod/codecheckbylanguage/view.php",array('id'=>$id));
$editform = new codecheckbylanguage_edit_form( $formurl->out(true), $args,'post',null);

$output= '';
if ($editform->is_submitted()) {
		global $CFG,$USER;
		$validateddata = $editform->get_data();
		switch($codecheckbylanguage->language)
		{
			case 'HTML':
			case 'CSS':
			case 'JAVASCRIPT':
							$output= $CFG->dataroot."/temp/".time()."_HTML_".$USER->id.".html";
							
							file_put_contents($output,$validateddata->code);
							break;
			case 'PHP':
							$content = "<?php ini_set('display_errors', 1); ";
							$content .= " ini_set('display_startup_errors', 1); ";
							$content .= " error_reporting(E_ALL); ?> ";
							$content .= $validateddata->code;
							$name= $CFG->dataroot."/temp/".time()."_PHP_".$USER->id.".php";
							$output= $CFG->dataroot."/temp/".time()."_PHP_".$USER->id.".html";
							file_put_contents($name,$content);
							
							if( substr($_SERVER['HTTP_SEC_CH_UA_PLATFORM'],1,-1)=="Windows")
							{
								ob_start();
								passthru("php -q $name");
								$outputcontent = ob_get_clean();
								file_put_contents($output,nl2br($outputcontent));
								ob_end_flush();
								
							}
							else
							{
								exec("php -q $name",$output);
							}
							break;
		case 'PHP':
							
							$content = $validateddata->code;
							$name= $CFG->dataroot."/temp/".time()."_PHP_".$USER->id.".java";
							$output= $CFG->dataroot."/temp/".time()."_PHP_".$USER->id.".html";
							file_put_contents($name,$content);
							
							if( substr($_SERVER['HTTP_SEC_CH_UA_PLATFORM'],1,-1)=="Windows")
							{
								ob_start();
								passthru("javac $name");
								$outputcontent = ob_get_clean();
								file_put_contents($output,nl2br($outputcontent));
								ob_end_flush();
								
							}
							else
							{
								exec("javac $name",$output);
							}
							break;
			case 'TYPESCRIPT':
							
							$content = $validateddata->code;
							$name= $CFG->dataroot."/temp/".time()."_PYTHON_".$USER->id.".ts";
							file_put_contents($name,$content);
							
							$output= $CFG->dataroot."/temp/".time()."_PYTHON_".$USER->id.".html";
							if(substr($_SERVER['HTTP_SEC_CH_UA_PLATFORM'],1,-1)=="Windows")
							{
								ob_start();
								passthru("tsc $name");
								$outputcontent = ob_get_clean();
								file_put_contents($output,nl2br($outputcontent));
								ob_end_flush();
							}
							else
							{
								exec("tsc $name", $output);
							}
							break;
			case 'NODE':
							
							$content = $validateddata->code;
							$name= $CFG->dataroot."/temp/".time()."_PYTHON_".$USER->id.".ts";
							file_put_contents($name,$content);
							
							$output= $CFG->dataroot."/temp/".time()."_PYTHON_".$USER->id.".html";
							if(substr($_SERVER['HTTP_SEC_CH_UA_PLATFORM'],1,-1)=="Windows")
							{
								ob_start();
								passthru("node $name");
								$outputcontent = ob_get_clean();
								file_put_contents($output,nl2br($outputcontent));
								ob_end_flush();
							}
							else
							{
								exec("node $name", $output);
							}
							break;
			case 'PYTHON':
							
							$content = $validateddata->code;
							$name= $CFG->dataroot."/temp/".time()."_PYTHON_".$USER->id.".py";
							file_put_contents($name,$content);
							
							$output= $CFG->dataroot."/temp/".time()."_PYTHON_".$USER->id.".html";
							if(substr($_SERVER['HTTP_SEC_CH_UA_PLATFORM'],1,-1)=="Windows")
							{
								ob_start();
								passthru("python $name");
								$outputcontent = ob_get_clean();
								file_put_contents($output,nl2br($outputcontent));
								ob_end_flush();
							}
							else
							{
								exec("py $name", $output);
							}
							break;
		}

}
else
{
	
	$filecontent='';
}

$formurl = new moodle_url("view.php",array('id'=>$id));


$title = 'Run Code';
$fullname = $course->fullname;
$pagedesc=$codecheckbylanguage->name.":".$codecheckbylanguage->language;

$PAGE->set_title($title);
$PAGE->set_heading($fullname);

echo $OUTPUT->header();
echo $OUTPUT->heading($pagedesc);
    
$editform->display();


if(trim($output) !='')
{
	$tempurl = new moodle_url("./../../get_temporary.php",array('tempfilename'=>basename($output)));
	echo "<iframe src='". $tempurl->out(true)."' width='100%' frameborder='1' />";
}

echo $OUTPUT->footer();
?>