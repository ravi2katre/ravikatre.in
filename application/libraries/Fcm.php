<?php
/**
*
*/

class Fcm
{
	private $CI;
	//private $table_name = 'job_schedule';
	//private $job_status = array();
	//private $job_server = '1';

	function __construct()
	{
        $this->CI = &get_instance();
        require_once APPPATH.'third_party/FCM/config.php';
        require_once APPPATH.'third_party/FCM/firebase.php';
        require_once APPPATH.'third_party/FCM/push.php';
    }


    function test($fields = array()){
        //$fields['title']         = $this->input->get_post('title');
        //$fields['message']       = $this->input->get_post('message');
        //$fields['push_type']     = $this->input->get_post('push_type');
        //$fields['include_image'] = $this->input->get_post('include_image');
        //$fields['regId'] = $this->input->get_post('regId');

        $firebase = new Firebase();
        $push = new Push();

        // optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';

        // notification title
        $title = (!empty($fields['title']))? $fields['title'] : '';

        // notification message
        $message = (!empty($fields['message'])) ? $fields['message'] : '';

        // push type - single user / topic
        $push_type = (!empty($fields['push_type'])) ? $fields['push_type'] : 'individual';

        // whether to include to image or not
        $include_image = (!empty($fields['include_image'])) ? TRUE : FALSE;


        $push->setTitle($title);
        $push->setMessage($message);
        if ($include_image) {
            $push->setImage('https://api.androidhive.info/images/minion.jpg');
        } else {
            $push->setImage('');
        }
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $push->getPush();
            $response = $firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $push->getPush();
            $regId = isset($fields['regId']) ? $fields['regId'] : '';
            $response = $firebase->send($regId, $json);
        }

        return $response;
    }
}