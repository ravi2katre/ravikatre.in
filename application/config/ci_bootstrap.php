<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| CI Bootstrap 3 Configuration
| -------------------------------------------------------------------------
| This file lets you define default values to be passed into views
| when calling MY_Controller's render() function.
|
| See example and detailed explanation from:
| 	/application/config/ci_bootstrap_example.php
*/

$config['ci_bootstrap'] = array(

	// Site name
	'site_name' => 'ASF',

	// Default page title prefix
	'page_title_prefix' => '',

	// Default page title
	'page_title' => 'ASF',

	// Default meta data
	'meta_data'	=> array(
		'author'		=> 'ASF',
		'description'	=> 'ASF',
		'keywords'		=> 'ASF'
	),

	// Default scripts to embed at page head or end
	'scripts' => array(
		'head'	=> array(
            'https://js.pusher.com/4.1/pusher.min.js'
		),
		'foot'	=> array(
			//'assets/dist/frontend/lib.min.js',
			//'assets/dist/frontend/app.min.js',

			'assets/dist/frontend/js/jquery.js',
			'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js',
			'assets/dist/frontend/js/bootstrap.min.js',
			'assets/dist/frontend/js/bootsnav.js',
			'assets/dist/frontend/js/jquery.sticky.js',
			'assets/dist/frontend/js/progressbar.js',
			'assets/dist/frontend/js/jquery.appear.js',
			'assets/dist/frontend/js/owl.carousel.min.js',
			'https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js',
			'assets/dist/frontend/js/custom.js',
		),
	),

	// Default stylesheets to embed at page head
	'stylesheets' => array(
		'screen' => array(
			//'assets/dist/frontend/lib.min.css',
			//'assets/dist/frontend/app.min.css',

			'https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&amp;subset=devanagari,latin-ext',
			'assets/dist/frontend/css/font-awesome.min.css',
			'assets/dist/frontend/css/flaticon.css',
			'assets/dist/frontend/css/animate.css',
			'assets/dist/frontend/css/owl.carousel.min.css',
			'assets/dist/frontend/css/owl.theme.default.min.css',
			'assets/dist/frontend/css/bootstrap.min.css',
			'assets/dist/frontend/css/bootsnav.css',
			'assets/dist/frontend/css/style.css',
			'assets/dist/frontend/css/responsive.css',
		)
	),

	// Default CSS class for <body> tag
	'body_class' => '',

	// Multilingual settings
	/*'languages' => array(
		'default'		=> 'en',
		'autoload'		=> array('general'),
		'available'		=> array(
			'en' => array(
				'label'	=> 'English',
				'value'	=> 'english'
			),
			'zh' => array(
				'label'	=> '繁體中文',
				'value'	=> 'traditional-chinese'
			),
			
			'es' => array(
				'label'	=> 'Español',
				'value' => 'spanish'
			)
		)
	),*/

	// Google Analytics User ID
	'ga_id' => '',

	// Menu items
	'menu' => array(
		'home' => array(
			'name'		=> 'Home',
			'url'		=> '',
		),
	),

	// Login page
	'login_url' => '',

	// Restricted pages
	'page_auth' => array(
	),

	// Email config
	'email' => array(
		'from_email'		=> '',
		'from_name'			=> '',
		'subject_prefix'	=> '',

		// Mailgun HTTP API
		'mailgun_api'		=> array(
			'domain'			=> '',
			'private_api_key'	=> ''
		),
	),

	// Debug tools
	'debug' => array(
		'view_data'	=> FALSE,
		'profiler'	=> FALSE
	),
);

/*
| -------------------------------------------------------------------------
| Override values from /application/config/config.php
| -------------------------------------------------------------------------
*/
$config['sess_cookie_name'] = 'ci_session_frontend';