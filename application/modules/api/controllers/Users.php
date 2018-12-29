<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends API_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Menus_model');
        //error_reporting(0);
        // Report all errors except E_NOTICE
        //error_reporting(E_ALL & ~E_NOTICE | E_WARNING );
    }
	public function index()
	{
		// API Doc page only accessible during development/testing environments
		if (in_array(ENVIRONMENT, array('development', 'testing')))
		{
			$this->mBodyClass = 'swagger-section';
			$this->render('home', 'empty');
		}
		else
		{
			redirect();
		}
	}
 /**
     * @SWG\Post(path="/users/login",
     *   tags={"Users"},
     *   summary="Add/GET user record",
     *   description="",
     *   operationId="login_post",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="mobile",
     *     in="query",
     *     description="Phone No to get user details",
     *     required=true,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="city",
     *     in="query",
     *     description="city",
     *     required=true,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="role",
     *     in="query",
     *     description="role to post user details",
     *     required=true,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="device_id",
     *     in="query",
     *     description="device_id for notification",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="device",
     *     in="query",
     *     description="device  for notification",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="device_os",
     *     in="query",
     *     description="device_os for notification",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
    public function login_post()
    {
    //print_r($_REQUEST); exit;
    //logit(print_r($_REQUEST,true),'login_post');
       $output = array();
       $output['status'] = 'SUCCESS';
       $output['message'] = '';
       $groups = array(
           "FARMER"=>FARMER,
           "SUPPLIER"=>SUPPLIER,
       );
       @$user_groups = array(
        $groups[$this->input->get_post('role')]
       );

       if(!isset($user_groups[0])){
            $output['status'] = 'ERROR';
            $output['message'] = 'Invalid Role';
            $this->response($output, REST_Controller::HTTP_OK);
       }
       if(empty($this->input->get_post('mobile'))){
            $output['status'] = 'ERROR';
            $output['message'] = 'mobile empty';
            $this->response($output, REST_Controller::HTTP_OK);
       }
       if(empty($this->input->get_post('city'))){
            $output['status'] = 'ERROR';
            $output['message'] = 'city empty';
            $this->response($output, REST_Controller::HTTP_OK);
        }
        //$data = map_column_with_array_key($this->table,$this->input->post('detail'));
        $data = array();
        $data['phone'] = $this->input->get_post('mobile');
        $data['city'] = $this->input->get_post('city');
        if(!empty($this->input->get_post('device_id'))){
            $data['device_id'] = $this->input->get_post('device_id');
        }
        if(!empty($this->input->get_post('device'))){
            $data['device'] = $this->input->get_post('device');
        }
        if(!empty($this->input->get_post('device_os'))){
            $data['device_os'] = $this->input->get_post('device_os');
        }

       $sql = "select u.* from users u
            LEFT JOIN users_groups ug ON ug.user_id = u.id
            where
            u.phone = '".$data['phone']."'
            AND ug.group_id = ".$user_groups[0]."
       ";
       $query = $this->db->query($sql);
       $output['response'] = $query->row_array();
        if(isset($output['response']['id'])){
            //unset($output['response']['username']);
            unset($output['response']['password']);
            //$output['data']= $data;
            $this->Users_model->update(array('phone' => $data['phone']), $data);
            $output['message'] = 'Record Updated!';
            $this->response($output, REST_Controller::HTTP_OK);
        }else{
            //$data = array();
            $data['first_name'] = null;
            $data['last_name'] = null;
            $data['email'] = '';
            $data['password'] = $data['phone'];
            //$insert = $this->{$this->model_name}->save($data);
            $data['username'] = $data['phone'];
            $user_id = $this->ion_auth->register($data['phone'],$data['password'],$data['email'],$data,array($user_groups[0]));

            $query = $this->db->query($sql);
            $output['response'] = $query->row_array();
            unset($output['response']['password']);
            $output['message'] = 'Record Inserted!';
            $output['status'] = 'SUCCESS';
            $this->response($output, REST_Controller::HTTP_OK);
        }
        $this->response($output, REST_Controller::HTTP_OK);
    }

    /**
     * @SWG\Post(path="/users/add_user",
     *   tags={"Users"},
     *   summary="Add record as user",
     *   description="",
     *   operationId="add_user",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="first_name",
     *     in="query",
     *     description="first name",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="last_name",
     *     in="query",
     *     description="last name",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     description="email",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="password",
     *     in="query",
     *     description="The password for login in clear text",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="password_confirm",
     *     in="query",
     *     description="password_confirm",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="phone",
     *     in="query",
     *     description="phone",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
    public function add_user_post()
    {
        //$data = map_column_with_array_key($this->table,$this->input->post('detail'));
        $data = array();
        $data['first_name'] = $this->input->get_post('first_name');
        $data['last_name'] = $this->input->get_post('last_name');
        $data['email'] = $this->input->get_post('email');
        $data['phone'] = $this->input->get_post('phone');
        $data['password'] = $this->input->get_post('password');
        //$insert = $this->{$this->model_name}->save($data);
        $data['username'] = $data['email'];
        $user_id = $this->ion_auth->register($data['email'],$data['password'],$data['email'],$data,array(5));
        if($user_id){
            $this->response(array("status" => TRUE,"user_id" => $user_id));
        }else{
            $this->response(array("status" => FALSE), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @SWG\Get(path="/users/list",
     *   tags={"Users"},
     *   summary="get users record",
     *   description="",
     *   operationId="users_list",
     *   produces={"application/xml", "application/json"},
     *  @SWG\Parameter(
     *     name="role",
     *     in="query",
     *     description=" role",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="city",
     *     in="query",
     *     description="city",
     *     required=false,
     *     type="string"
     *   ),
	 *  @SWG\Parameter(
     *     name="user_id",
     *     in="query",
     *     description=" user_id",
     *     required=false,
     *     type="number"
     *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
    public function list_get()
    {
        $where = ' ';
        $role = strtolower($this->input->get_post('role'));
		if(!empty($role)){
			$where .= " AND LOWER(g.name) = '".$role."'";
        }
		$city = strtolower($this->input->get_post('city'));
		if(!empty($city)){
			$where .= " AND LOWER(u.city) = '".$city."'";
		}
		$user_id = (int) $this->input->get_post('user_id');
		if(!empty($user_id)){
			$where .= " AND LOWER(u.id) = '".$user_id."'";
		}
        $where = ' WHERE '.trim($where," AND ");
        $where = rtrim($where," WHERE ");
        $sql = "select
            u.username,
            u.email,
            u.created_on,
            u.first_name,
            u.middle_name,
            u.last_name,
            u.company,
            u.phone,
            u.address,
            u.city,
			u.device_id,
			u.device_os,
			u.device,
            ug.group_id,
            ug.user_id,
            g.name as group_name
            FROM users u
            LEFT JOIN users_groups ug ON ug.user_id = u.id
            LEFT JOIN groups g ON g.id = ug.group_id
       ". $where;
       $query = $this->db->query($sql);
       $output['response'] = $query->result();
        //echo "fddfdfdf";
        //$this->system_message->add_success("nnnnnnnnnnnnn");
		$output['message'] = 'users list';
		$output['status'] = 'SUCCESS';

        $this->response($output, REST_Controller::HTTP_OK);
        //return $this->mViewData['list'];
    }

    /**
     * @SWG\Post(path="/users/product_add",
     *   tags={"Products"},
     *   summary="ADD Products",
     *   description="",
     *   operationId="product_add",
     *   produces={"application/xml", "application/json"},
     *  @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     description="product name",
     *     required=false,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="url",
     *     in="query",
     *     description="seo url ",
     *     required=false,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="image_url",
     *     in="query",
     *     description="image name with etention Ex: imagename.png ",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="city_id",
     *     in="query",
     *     description="city_id",
     *     required=false,
     *     type="number"
     *   ),
     *   @SWG\Parameter(
     *     name="product_id",
     *     in="query",
     *     description="product_id",
     *     required=false,
     *     type="number"
     *   ),
	    *  @SWG\Parameter(
     *     name="user_id",
     *     in="query",
     *     description=" user_id",
     *     required=true,
     *     type="number"
     *   ),
     *  @SWG\Parameter(
     *     name="category",
     *     in="query",
     *     description="category",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
    public function product_add_post()
  {
      //$this->_validate();
      $city_id = (int) $this->input->get_post('city_id');
      $product_id = (int) $this->input->get_post('product_id');
      $data = array(
              'name' => $this->input->get_post('name'),
              //'icon' => $this->input->post('icon'),
              //'url' => $this->input->get_post('url'),
              //'sort_by' => $this->input->post('sort_by'),
              'parent_id' => ($this->input->get_post('parent_id') > 0)?$this->input->get_post('parent_id'):PRODUCT_MENU,
              'user_id' => $this->input->get_post('user_id'),
          );
          if(!empty($this->input->get_post('url'))){
            $data['url'] = $this->input->get_post('url');
          }
          if(!empty($this->input->get_post('image_url'))){
            $data['image_url'] = $this->input->get_post('image_url');
          }
          if(!empty($this->input->get_post('content'))){
            $data['content'] = $this->input->get_post('content');
          }
          /*if(isset($_FILES['userfile']) && $_FILES['userfile']['error'] == 0){
                $file = $this->upload_file('userfile');
                if (isset($file['error'])) {
                    $data = array();
                    $data['error_string'] = $file['error'];
                    $data['status'] = false;
                    $this->render_json($data);
                    exit();
                }else{
                    //print_r($file);
                    $data['image_url'] = $file['upload_data']['file_name'];
                }
            }*/
      if($this->input->post('content')){
        $data['content'] =  $this->input->post('content');
      }
      if($product_id == 0){
        $insert = $this->Menus_model->save($data);
        if($data['parent_id'] > 0){
            $parent = $this->Menus_model->get_by_id($data['parent_id']);
            $data = array(
                'liniage' => $parent->liniage."/".$insert,
            );
        }else{
            $data = array(
                'liniage' => "/".$insert,
            );
        }
        $output['message'] = 'product added';
    }else{
        $output['message'] = 'product updated';
        $insert = $product_id;
    }
      $this->Menus_model->update(array('menu_id' => $insert), $data);
      //$this->Menus_model->insert_menus_groups($this->input->post('group_ids'),$insert);
      if($city_id > 0){

        $product_city = array();
        $product_city['product_id'] = $insert;
        $product_city['city_id'] = $city_id;
        $pro_city = $this->db->where($product_city)->get('product_cities')->result_array();
        if(!isset($pro_city[0]['id'])){
            $this->db->insert('product_cities', $product_city);
        }
      }
         $output['status'] = 'SUCCESS';
         $output['response']['product_id'] = (int)$insert;
        $this->response($output, REST_Controller::HTTP_OK);
        //return $this->mViewData['list'];
  }
    /**
     * @SWG\Get(path="/users/product_list",
     *   tags={"Products"},
     *   summary="get products record",
     *   description="",
     *   operationId="product_list",
     *   produces={"application/xml", "application/json"},
     *  @SWG\Parameter(
     *     name="product_id",
     *     in="query",
     *     description="product_id",
     *     required=false,
     *     type="number"
     *   ),
	 *  @SWG\Parameter(
     *     name="city_id",
     *     in="query",
     *     description="city_id",
     *     required=false,
     *     type="number"
     *   ),
	 *  @SWG\Parameter(
     *     name="user_id",
     *     in="query",
     *     description=" user_id",
     *     required=false,
     *     type="number"
     *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
	 public function product_list_get()
    {
        $this->load->helper('url');
        $this->db->where("menu_id !=", PRODUCT_MENU);
        $user_id = (int)$this->input->get_post('user_id');
        if($user_id > 0){
        $this->db->where("user_id", $user_id);
        }
        $product_id = (int)$this->input->get_post('product_id');
        if($product_id > 0){
        $this->db->where("menu_id", $product_id);
        }

		$city_id = (int)$this->input->get_post('city_id');
        if($city_id > 0){

				$this->db->where("`menu_id` IN (SELECT  `product_id` FROM `product_cities` where city_id='".$city_id."')", NULL, FALSE);
        }


        $list = $this->Menus_model->get_liniage_rows(PRODUCT_MENU);
        //$this->mViewData['groups'] = $this->db->get('groups')->result();
        //cidb($this->mViewData['list']); exit;
        //echo "fddfdfdf";
        //$this->system_message->add_success("nnnnnnnnnnnnn");
        $output['message'] = 'product list';
        $output['status'] = 'SUCCESS';
        $output['response']  =  $list;
        $this->response($output, REST_Controller::HTTP_OK);
        //return $this->mViewData['list'];
    }

	/**
     * @SWG\Post(path="/users/delete_product",
     *   tags={"Products"},
     *   summary="delete_product",
     *   description="",
     *   operationId="delete_product",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="product_id",
     *     in="query",
     *     description="product_id",
     *     required=true,
     *     type="number"
     *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
    public function delete_product_post()
    {
        //$this->load->model('Notifications_model');
        //$data = map_column_with_array_key($this->table,$this->input->post('detail'));
        $data = array();
        //$data['device_id'] = $this->input->get_post('device_id');
        $data['product_id'] = (int) $this->input->get_post('product_id');


        $this->db->where('menu_id', $data['product_id']);
		$this->db->where('parent_id', 28);


        if($this->db->delete('menus')){

			$this->db->where('product_id', $data['product_id']);
			$this->db->delete('supplier_orders');

			$this->db->where('product_id', $data['product_id']);
			$this->db->delete('inquiries');

            $output['message'] = 'Product  deleted';
            $output['status'] = 'SUCCESS';
            $output['response'] =true;



            $this->response($output, REST_Controller::HTTP_OK);
        }else{
            $output['message'] = 'not found';
            $output['status'] = 'ERROR';
            $output['response'] =false;
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }



	/**
     * @SWG\Get(path="/users/plans",
     *   tags={"Plans"},
     *   summary="get products record",
     *   description="",
     *   operationId="plans",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
	 public function plans_get()
    {

        $user_id = (int)$this->input->get_post('user_id');
        if($user_id > 0){
        $this->db->where("user_id", $user_id);
        }
		$this->db->from('plans');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        $list =  $query->result();

        $output['message'] = 'plans list';
        $output['status'] = 'SUCCESS';
        $output['response']  =  $list;
        $this->response($output, REST_Controller::HTTP_OK);
        //return $this->mViewData['list'];
    }



    /**
     * @SWG\Get(path="/users/menu_list",
     *   tags={"Menu"},
     *   summary="get menus record",
     *   description="",
     *   operationId="menu_list",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
	 public function menu_list_get()
     {
         $this->load->helper('url');
         $this->db->where("menu_id !=", FRONT_MENU);
         $list = $this->Menus_model->get_liniage_rows(FRONT_MENU);
         //$this->mViewData['groups'] = $this->db->get('groups')->result();
         //cidb($this->mViewData['list']); exit;
         //echo "fddfdfdf";
         //$this->system_message->add_success("nnnnnnnnnnnnn");
         $output['message'] = 'pages list';
         $output['status'] = 'SUCCESS';
         $output['response']  =  $list;
         $this->response($output, REST_Controller::HTTP_OK);
         //return $this->mViewData['list'];
     }
     /**
     * @SWG\Post(path="/users/inquiry_add",
     *   tags={"Inquiry"},
     *   summary="Inquiry add",
     *   description="",
     *   operationId="inquiry_add",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="product_id",
     *     in="query",
     *     description="please enter Product Id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="user_id",
     *     in="query",
     *     description="User Id ",
     *     required=true,
     *     type="integer"
     *   ),
	 *   @SWG\Parameter(
     *     name="farmer_id",
     *     in="query",
     *     description="farmer_id ",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     description="email",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     description="Name",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="details",
     *     in="query",
     *     description="Details",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="delevery_date",
     *     in="query",
     *     description="delevery_date Ex: 2018-09-13 06:10:11",
     *     required=true,
     *     type="string"
     *   ),     *
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
    public function inquiry_add_post()
    {
        $this->load->model('Inquiry_model');
        //$data = map_column_with_array_key($this->table,$this->input->post('detail'));
        $data = array();
        $data['product_id'] = $this->input->get_post('product_id');
        $data['user_id'] = $this->input->get_post('user_id');
		$data['farmer_id'] = $this->input->get_post('farmer_id');
		$data['delevery_date '] = date("Y-m-d H:i:s",strtotime($this->input->get_post('delevery_date')));
        $data['email'] = $this->input->get_post('email');
        $data['name'] = $this->input->get_post('name');
        $data['details'] = $this->input->get_post('details');
        //$insert = $this->{$this->model_name}->save($data);
        //$data['username'] = $data['email'];
        $output['response']['request_id'] = $this->Inquiry_model->save($data);
        $output['message'] = 'Inquiry added';
        $output['status'] = 'SUCCESS';
        if($output['response']['request_id']){
            $this->response($output, REST_Controller::HTTP_OK);
        }else{
        $output['message'] = 'Inquiry insert error';
        $output['status'] = 'ERROR';
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }
    /**
     * @SWG\Get(path="/users/inquiry",
     *   tags={"Inquiry"},
     *   summary="get inquiry record",
     *   description="inquiry_list",
     *   operationId="inquiry_list",
     *   produces={"application/xml", "application/json"},
	 *   @SWG\Parameter(
     *     name="city",
     *     in="query",
     *     description="search by city",
     *     required=false,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="product_id",
     *     in="query",
     *     description="search by product_id",
     *     required=false,
     *     type="number"
     *   ),
     *  @SWG\Parameter(
     *     name="user_id",
     *     in="query",
     *     description="search by user_id",
     *     required=false,
     *     type="number"
     *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
	public function inquiry_get()
	{
		$where = ' ';
        $city = strtolower($this->input->get_post('city'));
		if(!empty($city)){
			$where .= " AND LOWER(u.city) = '".$city."'";
        }
		$product_id = (int)$this->input->get_post('product_id');
		if(!empty($product_id)){
			$where .= " AND i.product_id = '".$product_id."'";
		}
        $user_id = (int)$this->input->get_post('user_id');
        if($user_id > 0){
            $where .= " AND i.user_id = '".$user_id."'";

        }
        $where = ' WHERE '.trim($where," AND ");
        $where = rtrim($where," WHERE ");

		$output['message'] = 'inquiry list';
		$output['status'] = 'SUCCESS';
        $sql = "SELECT i.*,
		m.name as product_name,
		u.city as user_city,
		u.city,
		m.image_url,
		concat('".base_url()."uploads/images/', m.image_url) as image

		FROM inquiries i
        LEFT JOIN menus m ON m.menu_id = i.product_id
        LEFT JOIN users u ON u.id = i.user_id
        ".$where;
		//$output['sql'] = $sql;
		$query = $this->db->query($sql);
        $output['response']  =  $query->result();
        $this->response($output, REST_Controller::HTTP_OK);
	}
 /**
     * @SWG\Get(path="/users/city_products",
     *   tags={"Products"},
     *   summary="get city_products",
     *   description="Ex. 2",
     *   operationId="city_products",
     *   produces={"application/xml", "application/json"},
	    *   @SWG\Parameter(
     *     name="city_id",
     *     in="query",
     *     description="search by city_id",
     *     required=false,
     *     type="number"
     *   ),
     *   @SWG\Parameter(
     *     name="user_id",
     *     in="query",
     *     description="search by user_id",
     *     required=false,
     *     type="number"
     *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
	public function city_products_get()
	{
   $statement = array();
   $user_id = (int)$this->input->get_post('user_id');
   if($user_id > 0){
     $statement['p.user_id'] = (int) $this->input->get_post('user_id');
   }

   $city_id = (int)$this->input->get_post('city_id');
   if($city_id > 0){
     $statement['pc.city_id'] = (int) $this->input->get_post('city_id');
   }

  $list = $this->Menus_model->get_product_cities($statement);
  $list = json_encode($list);
  $list = json_decode($list, true);
  /*foreach($list as $key=>$val){
  //$val = array $val;
            $product_data = array();
        $product_data['product_id'] = (int)$val['product_id'];
        $method = 'GET';
        $url= 'api/users/product_list';
        $details = CallAPI($method, $url, $product_data);
        if(is_array($details['response'][0])){
        @$list[$key] = array_merge($list[$key], $details['response'][0]);
        }else{
            $list[$key]['roduct_details'] = $details;
        }
  }*/
		$output['message'] = 'city products';
		$output['status'] = 'SUCCESS';
		//$output['sql'] = $sql;
        $output['response']  =  $list;
        $this->response($output, REST_Controller::HTTP_OK);
	}
 /**
     * @SWG\Post(path="/users/supplier_orders_add",
     *   tags={"Supplier Orders"},
     *   summary="supplier_orders_add",
     *   description="",
     *   operationId="supplier_orders_add",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="user_id",
     *     in="query",
     *     description="User Id ",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="product_id",
     *     in="query",
     *     description="product_id",
     *     required=false,
     *     type="integer"
     *   ),
	 *  @SWG\Parameter(
     *     name="parent_product_id",
     *     in="query",
     *     description="parent_product_id",
     *     required=true,
     *     type="number"
     *   ),
     *   @SWG\Parameter(
     *     name="city_id",
     *     in="query",
     *     description="city_id",
     *     required=true,
     *     type="number"
     *   ),
     *   @SWG\Parameter(
     *     name="owner_name",
     *     in="query",
     *     description="owner_name",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="owner_address",
     *     in="query",
     *     description="owner_address",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="owner_gender",
     *     in="query",
     *     description="owner_gender",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="owner_email",
     *     in="query",
     *     description="owner_email",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="owner_phone",
     *     in="query",
     *     description="owner_phone",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="owner_aadhaar",
     *     in="query",
     *     description="owner_aadhaar",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="owner_licence",
     *     in="query",
     *     description="owner_licence",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="url",
     *     in="query",
     *     description="image name with etention Ex: imagename.png ",
     *     required=false,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="machine_name",
     *     in="query",
     *     description="machine_name",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="machine_category",
     *     in="query",
     *     description="machine_category",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="machine_company",
     *     in="query",
     *     description="machine_company",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="machine_model_type",
     *     in="query",
     *     description="machine_model_type",
     *     required=false,
     *     type="string"
     *   ),
	  *   @SWG\Parameter(
     *     name="machine_description",
     *     in="query",
     *     description="machine_description",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="machine_purchase_year",
     *     in="query",
     *     description="machine_purchase_year",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="machine_registration_number",
     *     in="query",
     *     description="machine_registration_number",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="machine_insurance_details",
     *     in="query",
     *     description="machine_insurance_details",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="operator_name",
     *     in="query",
     *     description="operator_name",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="operator_address",
     *     in="query",
     *     description="operator_address",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="operator_gender",
     *     in="query",
     *     description="operator_gender",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="operator_email",
     *     in="query",
     *     description="operator_email",
     *     required=false,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="operator_phone",
     *     in="query",
     *     description="operator_phone",
     *     required=false,
     *     type="string"
     *   ),
	 *    @SWG\Parameter(
	 *     name="operator_aadhaar",
	 *     in="query",
	 *     description="operator_aadhaar",
	 *     required=false,
	 *     type="string"
	 *   ),
	 *    @SWG\Parameter(
	 *     name="operator_licence",
	 *     in="query",
	 *     description="operator_licence",
	 *     required=false,
	 *     type="string"
	 *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
    public function supplier_orders_add_post()
    {
        $this->load->model('Supplier_orders_model');
        //$data = map_column_with_array_key($this->table,$this->input->post('detail'));
        $data = array();
        $product_id = (int)$this->input->get_post('product_id');
		$data['user_id'] = (int)$this->input->get_post('user_id');
		$data['parent_product_id'] = (int)$this->input->get_post('parent_product_id');
        $data['owner_name'] = $this->input->get_post('owner_name');
		$data['owner_address'] = $this->input->get_post('owner_address');
		$data['owner_gender'] = $this->input->get_post('owner_gender');
		$data['owner_email'] = $this->input->get_post('owner_email');
		$data['owner_phone'] = $this->input->get_post('owner_phone');
		$data['owner_aadhaar'] = $this->input->get_post('owner_aadhaar');
        $data['owner_licence'] = $this->input->get_post('owner_licence');
        $data['machine_name'] = $this->input->get_post('machine_name');
		$data['machine_category'] = $this->input->get_post('machine_category');
		$data['machine_company'] = $this->input->get_post('machine_company');
		$data['machine_model_type'] = $this->input->get_post('machine_model_type');
		$data['machine_description'] = $this->input->get_post('machine_description');
		$data['machine_purchase_year'] = date("Y-m-d H:i:s",strtotime($this->input->get_post('machine_purchase_year')));
		$data['machine_registration_number'] = $this->input->get_post('machine_registration_number');
		$data['machine_insurance_details'] = $this->input->get_post('machine_insurance_details');
		$data['operator_name'] = $this->input->get_post('operator_name');
		$data['operator_address'] = $this->input->get_post('operator_address');
		$data['operator_gender'] = $this->input->get_post('operator_gender');
		$data['operator_email'] = $this->input->get_post('operator_email');
		$data['operator_phone'] = $this->input->get_post('operator_phone');
  $data['operator_aadhaar'] = $this->input->get_post('operator_aadhaar');
  $data['operator_licence'] = $this->input->get_post('operator_licence');
        $city_id = $this->input->get_post('city_id');
        $data['machine_city_id'] = $city_id;

        //// product api start /////////////
        //$insert = $this->{$this->model_name}->save($data);
        //$data['username'] = $data['email'];
        $product_data['name'] = $data['machine_name'];
        $product_data['user_id'] = $data['user_id'];
        $product_data['product_id'] = $product_id;
        $product_data['city_id'] = $city_id;
        $product_data['content'] = $data['machine_description'];
        if(!empty($this->input->get_post('url'))){
            $product_data['url'] = $this->input->get_post('url');
        }
        $method = 'POST';
        $url= 'api/users/product_add';
        $details = CallAPI($method, $url, $product_data);
        //// product api end /////////////
        $data['product_id'] = (int) $details['response']['product_id'];
        //$this->response($details, REST_Controller::HTTP_OK);
        if($product_id > 0){
            $output['message'] = 'Supplier order updated';
            $output['response']['request_id'] = $this->Supplier_orders_model->update(array("product_id"=>$product_id), $data);
            $output['response']['product_id']= $data['product_id'];
        }else{
            $output['message'] = 'Supplier order added';
            //$output['data'] = $data;
            $output['response']['request_id'] = $this->Supplier_orders_model->save($data);
            $output['response']['product_id'] = $details['response']['product_id'];
        }
		$filter_data = array();
		$filter_data['product_id'] = $output['response']['product_id'];
		$method = 'GET';
        $url= 'api/users/supplier_orders_list';
        $row = CallAPI($method, $url, $filter_data);
		$output['response'] = $row['response'][0];
        $output['status'] = 'SUCCESS';
        if($output['response']['product_id']){
            $this->response($output, REST_Controller::HTTP_OK);
        }else{
        $output['message'] = 'Supplier order error';
        $output['status'] = 'ERROR';
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

 /**
     * @SWG\Get(path="/users/supplier_orders_list",
     *   tags={"Supplier Orders"},
     *   summary="get supplier_orders_list",
     *   description="",
     *   operationId="supplier_orders_list",
     *   produces={"application/xml", "application/json"},
     *  @SWG\Parameter(
     *     name="user_id",
     *     in="query",
     *     description=" user_id",
     *     required=false,
     *     type="number"
     *   ),
     *  @SWG\Parameter(
     *     name="product_id",
     *     in="query",
     *     description=" product_id",
     *     required=false,
     *     type="number"
     *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
    public function supplier_orders_list_get()
    {
       $this->load->model('Supplier_orders_model');
       $user_id = (int)$this->input->get_post('user_id');
        if($user_id > 0){
        $this->db->where("sm.user_id", $user_id);
        }
        $product_id = (int)$this->input->get_post('product_id');
        if($product_id > 0){
        $this->db->where("sm.product_id", $product_id);
        }
        $list = $this->Supplier_orders_model->get_rows_with_products();
        $output['response'] = $list;
        $output['message'] = 'Supplier order list';
        $output['status'] = 'SUCCESS';
            $this->response($output, REST_Controller::HTTP_OK);
    }
/**
     * @SWG\Post(path="/users/upload_file",
     *   tags={"Upload File"},
     *   summary="Upload File",
     *   description="",
     *   operationId="upload_file",
     *   produces={"application/xml", "application/json"},
     *  @SWG\Parameter(
     *     name="userfile",
     *     in="query",
     *     description="userfile",
     *     required=false,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="product_id",
     *     in="query",
     *     description=" product_id",
     *     required=false,
     *     type="number"
     *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
    public function upload_file_post()
    {
        //$output['FILES'] = $_FILES;
        //echo "nnn";
        //mkdir_if_not_exist(FCPATH.'uploads/images/');
        $config['upload_path'] = FCPATH.'uploads/images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|JPEG|GIF';
        $config['max_size'] = 10000;
        $config['max_width'] = (2048 * 4);
        $config['max_height'] = (768 * 4);
        $this->load->library('upload', $config);
        if (!$result = $this->upload->do_upload()) {
            //$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $output['message'] = 'Faild';
            $output['status'] = 'ERROR';
            $output['response'] = $this->upload->display_errors();
        } else {
            $output['message'] = 'Fileuploaded';
            $output['status'] = 'SUCCESS';
            $output['response'] = $this->upload->data();
            $output['response']['image'] = base_url("uploads/images/".$output['response']['file_name']);
			$product_id = (int)$this->input->get_post('product_id');
			if($product_id > 0){
				$data_product = array();
				$data_product['image_url'] = $output['response']['file_name'];
				$this->Menus_model->update(array('menu_id' => $product_id), $data_product);
			}
        }
            $this->response($output, REST_Controller::HTTP_OK);
    }

/**
     * @SWG\Get(path="/users/notifications_list",
     *   tags={"Notifications"},
     *   summary="get Notifications record",
     *   description="",
     *   operationId="notifications_list",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
    public function notifications_list_get()
    {
        $whare = array();
        $id = (int)$this->input->get_post('id');
        if($id > 0){
            $whare['id'] = $id;
        }else{
            $whare['id >'] = $id;
        }
        $this->load->helper('url');
        $output['message'] = 'Notifications list';
        $output['status'] = 'SUCCESS';
        $output['response']  =  $this->db->where('id >',0)->get('notifications')->result();;
        $this->response($output, REST_Controller::HTTP_OK);
        //return $this->mViewData['list'];
    }
    /**
     * @SWG\Post(path="/users/notifications_add",
     *   tags={"Notifications"},
     *   summary="notifications add",
     *   description="",
     *   operationId="notifications_add",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="msg_type",
     *     in="query",
     *     description="EMAIL/SMS",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="group_name",
     *     in="query",
     *     description="group_name",
     *     required=true,
     *     type="string"
     *   ),
	 *   @SWG\Parameter(
     *     name="subject",
     *     in="query",
     *     description="subject",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="msg",
     *     in="query",
     *     description="Msg content",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
    public function notifications_add_post()
    {
        $this->load->model('Notifications_model');
        //$data = map_column_with_array_key($this->table,$this->input->post('detail'));
        $data = array();
        $data['msg_type'] = $this->input->get_post('msg_type');
        $data['group_name'] = $this->input->get_post('group_name');
		$data['subject'] = $this->input->get_post('subject');
        $data['msg'] = $this->input->get_post('msg');
        $output['response']['request_id'] = $this->Notifications_model->save($data);
        $output['message'] = 'Notification added';
        $output['status'] = 'SUCCESS';
        if($output['response']['request_id']){
            $this->response($output, REST_Controller::HTTP_OK);
        }else{
        $output['message'] = 'Notification insert error';
        $output['status'] = 'ERROR';
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }
    /**
     * @SWG\Post(path="/users/notifications_send",
     *   tags={"Notifications"},
     *   summary="notifications send",
     *   description="",
     *   operationId="notifications_add",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="group_name",
     *     in="query",
     *     description="Ex. Supplier",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="user_ids",
     *     in="query",
     *     description="Ex. 1,2,3,678,89,234",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="phone",
     *     in="query",
     *     description="phone only 10 digit, please select msg_type SMS then it will be valid",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="msg_type",
     *     in="query",
     *     description="EMAIL/SMS/PUSH",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="subject",
     *     in="query",
     *     description="subject",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="msg",
     *     in="query",
     *     description="msg body",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
    public function notifications_send_post()
    {
        $this->load->library(array("Fcm","system_message","email"));
        $this->load->model('Notifications_model');

        //$data = map_column_with_array_key($this->table,$this->input->post('detail'));
        $data = array();
        $id = $this->input->get_post('id');
        $group_name = $this->input->get_post('group_name');
        $user_ids = $this->input->get_post('user_ids');
        $phone = $this->input->get_post('phone');
        $msg = $this->input->get_post('msg');
        $subject = $this->input->get_post('subject');
        $msg_type = strtoupper($this->input->get_post('msg_type'));

        if(!empty($group_name)){
            $users = $this->Users_model->get_users_by_group_name($group_name);
        }
        if(!empty($user_ids)){
            $users = $this->Users_model->get_users_by_user_ids($user_ids);
        }



        if(isset($users[0]) || !empty($phone)){
            switch($msg_type){
                case 'SMS':
                    if(!empty($phone)){
                        $text = $msg.PHP_EOL;
                        $output['response']['result']= $this->system_message->sms($text, $phone);
                        //$output['response']['result'] = true;
                    }else{

                        foreach($users as $key=>$val){
                            if(!empty($val['phone'])){
                                $text = $msg.PHP_EOL;
                                $output['response']['result'][$val['user_id']]= $this->system_message->sms($text, $val['phone']);
                            }else{
                                $output['response']['result'][$val['user_id']] = "Empty phone!";
                            }
                        }
                    }
                    $output['message'] = 'SMS Sent';


                break;
                case 'EMAIL':
                    foreach($users as $key=>$val){
                        if(!empty($val['email'])){
                            $text = $msg.PHP_EOL;
                            $to_email = $val['email'];
                            $to_name=$val['email'];
                            $subject= $subject;
                            $view='general';
                            $view_data = array("email_content"=>$msg);
                            $output['response']['result'][$val['user_id']]= $this->email->send_email_template($to_email, $to_name, $subject, $view, $view_data = NULL);
                        }else{
                            $output['response']['result'][$val['user_id']] = "Empty email!";
                        }
                    }
                    $output['message'] = 'EMAIL Sent';
                break;
                case 'PUSH':
                    $output['message'] = 'PUSH Sent';
                    foreach($users as $key=>$val){
                        if(!empty($val['device_id'])){
                            $fields = array();
                            $fields['title']         = $subject;
                            $fields['message']       = $msg;
                            $fields['regId'] = $val['device_id'];
                            //$fields['push_type']     = $this->input->get_post('push_type');
                            //$fields['include_image'] = $this->input->get_post('include_image');
                            $output['response']['result'][$val['user_id']] = $this->fcm->test($fields);
                        }else{
                            $output['response']['result'][$val['user_id']] = "Empty device id!";
                        }
                    }
                break;
            }
        }

        $output['status'] = 'SUCCESS';
        if(isset($output['response']['result'])){
            $this->response($output, REST_Controller::HTTP_OK);
        }else{
        $output['message'] = 'Notification insert error';
        $output['status'] = 'ERROR';
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    /**
     * @SWG\Post(path="/users/register_device",
     *   tags={"Users"},
     *   summary="register_device",
     *   description="",
     *   operationId="register_device",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="device_id",
     *     in="query",
     *     description="device_id",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="user_id",
     *     in="query",
     *     description="group_name",
     *     required=true,
     *     type="number"
     *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
    public function register_device_post()
    {
        //$this->load->model('Notifications_model');
        //$data = map_column_with_array_key($this->table,$this->input->post('detail'));
        $data = array();
        $data['device_id'] = $this->input->get_post('device_id');
        $data['user_id'] = (int) $this->input->get_post('user_id');

		if(empty($data['device_id'])){
            $output['message'] = 'Device_id empty';
			$output['status'] = 'ERROR';
            $this->response($output, REST_Controller::HTTP_OK);
        }

		if(empty($data['user_id'])){
            $output['message'] = 'user_id empty';
			$output['status'] = 'ERROR';
            $this->response($output, REST_Controller::HTTP_OK);
        }


        if($this->db->insert('user_devices',$data)){
            $output['message'] = 'Device  Registered';
            $output['status'] = 'SUCCESS';
            $output['response'] =true;

            $data_user = array();
            $data_user['device_id'] = $data['device_id'];
            $this->Users_model->update(array('id' => $data['user_id']), $data_user);

            $this->response($output, REST_Controller::HTTP_OK);
        }else{
            $output['message'] = 'insert error';
            $output['status'] = 'ERROR';
            $output['response'] =false;
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }

    /**
     * @SWG\Post(path="/users/unregister_device",
     *   tags={"Users"},
     *   summary="unregister_device",
     *   description="",
     *   operationId="unregister_device",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="user_id",
     *     in="query",
     *     description="group_name",
     *     required=true,
     *     type="number"
     *   ),
     *   @SWG\Parameter(
     *     name="x-api-key",
     *     in="header",
     *     description="anonymous",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     )
     * )
     */
    public function unregister_device_post()
    {
        //$this->load->model('Notifications_model');
        //$data = map_column_with_array_key($this->table,$this->input->post('detail'));
        $data = array();
        //$data['device_id'] = $this->input->get_post('device_id');
        $data['user_id'] = (int) $this->input->get_post('user_id');



        $this->db->where('user_id', $data['user_id']);


        if($this->db->delete('user_devices')){
            $output['message'] = 'Device  deleted';
            $output['status'] = 'SUCCESS';
            $output['response'] =true;

            $data_user = array();
            $data_user['device_id'] = '';
            $this->Users_model->update(array('id' => $data['user_id']), $data_user);

            $this->response($output, REST_Controller::HTTP_OK);
        }else{
            $output['message'] = 'not found';
            $output['status'] = 'ERROR';
            $output['response'] =false;
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }
}
