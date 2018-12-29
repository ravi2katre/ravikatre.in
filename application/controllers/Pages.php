<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pages page
 */
class Pages extends MY_Controller {

	public function index()
	{
	    //echo "fddfdfdf";
        //$this->system_message->add_success("nnnnnnnnnnnnn");
        //$this->system_message->set_success("nnnnnnnnnnnnn");

		$this->render('home', 'full_width');
	}

    public function product_detail()
    {
        $this->render('pages/product_detail', 'full_width');

    }
	
	public function sub_about()
    {
        $this->render('pages/product_detail', 'full_width');

    }
}
