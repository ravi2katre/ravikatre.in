<?php
/**
 * Created by PhpStorm.
 * User: ravi
 * Date: 8/7/2017
 * Time: 7:13 PM
 */
use Pusher;

class Messaging extends MY_Controller
{
    private $serverID = '1';


    function __construct()
    {
        parent::__construct();
        //$this->load->library('job_scheduler');
        $this->load->helper('array');    //This model loads the categories locally
    }

    function msg(){
       // require __DIR__ . '/vendor/autoload.php';
        $options = array(
            'cluster' => 'ap2',
            'encrypted' => false
        );

        $pusher = new Pusher\Pusher(
            '464fe91876e8af33346d',
            '2440b551c629f13b1d19',
            '379900',
            $options
        );
       // print_r($pusher);
        $data['message'] = 'hello world';
        $pusher->trigger('my-channel', 'my-event', $data);
        //$this->render('home');
        exit;
    }
}
