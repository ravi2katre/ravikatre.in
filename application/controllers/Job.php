<?php
/**
* 
*/
class Job extends MY_Controller
{
	private $serverID = '1';
	
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('portphp');
		$this->load->helper('array');	//This model loads the categories locally
	}

	function csv_export(){
	    $this->portphp->csv_export();
    }


    public function import_frm()
    {
        $this->render("import/import",'empty');
    }

    public function import($section)
    {
        $config['upload_path']          = './uploads/imports/';
        $config['allowed_types']        = '*';
        //$config['max_size']             = 100;
        //$config['max_width']            = 1024;
        //$config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('user_file'))
        {
            $error = array('error' => $this->upload->display_errors());
            $this->render_json($error );
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $this->render_json($data );
            switch($section){
                case "csv_parents":
                break;
            }
        }
    }
}
