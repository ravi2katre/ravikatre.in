<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Home page

 */

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->libraries(array('rest'));
        $this->add_stylesheet('https://fonts.googleapis.com/css?family=Hind', true, 'screen');

    }
    public function index()
    {
        //echo "fddfdfdf";
        //$this->system_message->add_success("nnnnnnnnnnnnn");
        //$this->system_message->set_success("nnnnnnnnnnnnn");

        $this->mViewData['pages'] = $this->get_pages();
        //cidb($this->mViewData['pages']); exit;
        foreach($this->mViewData['pages'] as $key=>$val){

            $this->mViewData['pages'][$val['url']] = $val['content'];
        }

        $this->mViewData['products'] = $this->get_products();
        //cidb($this->mViewData['products']); exit;
        $this->render('home', 'full_width');
    }

    public function home_msg()
    {
        //echo "fddfdfdf";
        //$this->system_message->add_success("nnnnnnnnnnnnn");
        $this->system_message->set_success("nnnnnnnnnnnnn");

        //$this->mViewData['list'] = $this->get_products();
        redirect("home/index");

    }

    public function get_pages()
    {

        $method = 'GET';
        $url = 'api/users/menu_list';
        $data = false;

        // Run some setup
        $list = $this->rest->CallAPI($method, $url, $data);

        return $list['response'];

    }

    public function get_products()
    {

        $method = 'GET';
        $url = 'api/users/product_list';
        $data['user_id'] = 1;

        // Run some setup
        $list = $this->rest->CallAPI($method, $url, $data);

        return $list['response'];

    }

    public function test()
    {
        print_r($_REQUEST);exit;
    }

    public function inquiry_add()
    {

        $data = array();
        $data['product_id'] = $this->input->get_post('product_id');
        $data['email'] = $this->input->get_post('email');
        $data['name'] = $this->input->get_post('name');
        $data['details'] = $this->input->get_post('details');

        $data_users_login = array();
        $data_users_login['mobile'] = $this->input->get_post('phone');
        $data_users_login['city'] = $this->input->get_post('city');
        $data_users_login['role'] = 'FARMER';

        $method = 'POST';
        $url = 'api/users/login';
        $result = $this->rest->CallAPI($method, $url, $data_users_login);
        if ($result['status'] == 'ERROR') {
            $this->render_json($result);
        }

        $data['user_id'] = $result['response']['id'];

        $method = 'POST';
        $url = 'api/users/inquiry_add';
        $list = $this->rest->CallAPI($method, $url, $data);

        $this->render_json($list);

    }

    public function contact_frm()
    {

        $method = 'POST';
        $url = 'api/users/inquiry_add';
        $data = array();
        $data['product_id'] = $this->input->get_post('product_id');
        $data['user_id'] = $this->input->get_post('user_id');
        $data['email'] = $this->input->get_post('email');
        $data['name'] = $this->input->get_post('name');
        $data['details'] = $this->input->get_post('details');

        // Run some setup
        $list = $this->rest->CallAPI($method, $url, $data);
        $this->render_json($list);

    }

}
