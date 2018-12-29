<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends API_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
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
     * @SWG\Post(path="/users/add_student",
     *   tags={"users"},
     *   summary="Add student as user",
     *   description="",
     *   operationId="addStudent",
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
    public function add_student_post()
    {
        $result = $this->_validate();
        if($result['status'] == false){
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
            exit;
        }
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
     * @SWG\Post(path="/users/add_parent",
     *   tags={"users"},
     *   summary="Add parent as user",
     *   description="",
     *   operationId="addParent",
     *   produces={"application/xml", "application/json"},
     *  @SWG\Parameter(
     *     name="student_id",
     *     in="query",
     *     description="student_id",
     *     required=true,
     *     type="number"
     *   ),
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
    public function add_parent_post()
    {
        $result = $this->_validate();
        if($result['status'] == false || empty($this->input->get_post('student_id'))){
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
            exit;
        }
        //$data = map_column_with_array_key($this->table,$this->input->post('detail'));
        $data = array();
        $data['first_name'] = $this->input->get_post('first_name');
        $data['last_name'] = $this->input->get_post('last_name');
        $data['email'] = $this->input->get_post('email');
        $data['phone'] = $this->input->get_post('phone');
        $data['password'] = $this->input->get_post('password');
        //$insert = $this->{$this->model_name}->save($data);
        $data['username'] = $data['email'];
        $data['group_ids'] = array(PARENT);
        $user_id = $this->ion_auth->register($data['email'],$data['password'],$data['email'],$data,$data['group_ids'] );

        if($user_id){

            $students_parents['student_id'] = $this->input->get_post('student_id');
            $students_parents['parent_id'] = $user_id;
            $this->Users_model->save_students_parents($students_parents);
            $this->response(array("status" => TRUE,"user_id" => $user_id));

        }else{
            $this->response(array("status" => FALSE), REST_Controller::HTTP_BAD_REQUEST);
        }

    }

    private function _validate()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters("<p>", "</p>");

        $this->form_validation->set_rules('first_name', 'first_name', 'required');
        $this->form_validation->set_rules('last_name', 'last_name', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('email', 'Email', array('required', array('validate_username', function($email){
            //return false;
            $condition['id !='] = $this->input->post('id');
            $condition['email'] = $email;
            $condition = array_filter($condition);
            //cidb($condition );
            $result = $this->db->get_where('users', $condition)->row_array();
            //cidb($result);exit;

            if(is_array($result) && array_key_exists('email', $result))
            {
                $this->form_validation->set_message('validate_username', 'The  field must contain a unique value.');
                return FALSE;
            }else
            {
                return TRUE;
            }
            // Check $value
        })));

        if($this->input->post('id') > 0){
            if(!empty($this->input->post('password'))){
                $this->form_validation->set_rules('password', 'Password', 'required|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
            }


        }else{
            $this->form_validation->set_rules('password', 'Password', 'required|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
        }

        $data = array();
        $data['error_string'] = array();
        $data['status'] = TRUE;

        if ($this->form_validation->run() == FALSE){

            $data['error_string'] =  validation_errors();
            $data['status'] = FALSE;
        }else{
            $data['status'] = TRUE;
        }


        return $data;
    }
}
