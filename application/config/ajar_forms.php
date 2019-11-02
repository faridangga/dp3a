<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Input Types
| -------------------------------------------------------------------
| This file contains arrays of html form element type. DB field used 
| this config meta_type.
|	1 =  Input[text]
|	2 =  Input[password]
|	3 =  Input[radio]	=> have options
|	4 =  Input[checkbox]	=> have options
|	5 =  Input[color]
|	6 =  Input[date]
|	7 =  Input[datetime-local]
|	8 =  Input[email]
|	9 =  Input[number]
|	10 =  Input[month]
|	11 =  Input[week]
|	12 =  Input[time]
|	13 =  Texarea
|	14 =  Select box	=> have options
}	15 =  Button Submit
*/

$config['input_types_html'] = array(
	1 	=> 'input',
	2 	=> 'password',
	3 	=> 'radio',
	4 	=> 'checkbox',
	5 	=> 'color',
	6 	=> 'date',
	7 	=> 'datetime-local',
	8 	=> 'email',
	9 	=> 'number',
	10 	=> 'month',
	11 	=> 'week',
	12 	=> 'time',
	13	=> 'textarea',
	14	=> 'select',
	15	=> 'submit'
);


$config['input_types_desc'] = array(
	1 	=> 'simple Text',
	2 	=> 'Password',
	3 	=> 'Radio',
	4 	=> 'Checkbox',
	5 	=> 'Color',
	6 	=> 'Date',
	7 	=> 'Datetime-local',
	8 	=> 'Email',
	9 	=> 'Number',
	10 	=> 'Month',
	11 	=> 'Week',
	12 	=> 'Time',
	13	=> 'Paragraph',
	14	=> 'Combobox',
	15	=> 'Button Submit'
);

$config['ajarform_home_url'] 		= '/community';

$config['ajarform_register_url']	= '/community/register';

$config['ajarform_submission_url'] 	= '/community/save';

$config['ajarform_mail_notify']		= TRUE;

$config['ajarform_mail_admin']		= 'yogi@ajar.co.id';

$config['ajarform_mail_sender']		= 'no-reply@ajar.co.id';
$config['ajarform_mail_sender_name']	= 'AJAR.id Trainer Community';

$config['ajarform_mail_config']		= array(
						'protocol' 	=> 'sendmail',
						'smtp_host' 	=> 'hotelier.co.id',
						'smtp_user' 	=> 'no-reply@ajar.co.id',
						'smtp_pass' 	=> 'ajar2018',
						'smtp_port' 	=> '143',
						'smtp_crypto' 	=> 'no',
						'mailtype' 	=> 'html',
						'mailpath'	=> '/usr/sbin/sendmail -t -i',
						'wordwrap' 	=> TRUE
					);

$config['ajarform_confirmation_type'] 	= array(
						1 => 'Message',
						2 => 'Page',
						3 => 'Go to URL (redirect)'
					);

