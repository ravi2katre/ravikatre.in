<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends API_Controller {

public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Menus_model');
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
     * @SWG\Get(path="/site/countries",
     *   tags={"Site"},
     *   summary="get countries record",
     *   description="",
     *   operationId="site_countries",
     *   produces={"application/xml", "application/json"},
	 *   @SWG\Parameter(
     *     name="country_name",
     *     in="query",
     *     description="search by country_name",
     *     required=false,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="country_id",
     *     in="query",
     *     description="country_name",
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
	public function countries_get()
	{
		$where = '';
		$country_name = strtolower($this->input->get_post('country_name'));
		//$output['country_name'] = $country_name;
		if(!empty($country_name)){
			$where .= " AND LOWER(name) = '".$country_name."'";
		}
		$country_id = (int)$this->input->get_post('country_id');
		if(!empty($country_id)){
			$where .= " AND id = '".$country_id."'";
		}
		$where = ' WHERE '.trim($where," AND ");
  $where = rtrim($where," WHERE ");

		$output['message'] = 'countries list';
		$output['status'] = 'SUCCESS';
		$sql = "SELECT * FROM countries ".$where;
		//$output['sql'] = $sql;
		$query = $this->db->query($sql);
        $output['response']  =  $query->result();

        $this->response($output, REST_Controller::HTTP_OK);
	}
	/**
     * @SWG\Get(path="/site/states",
     *   tags={"Site"},
     *   summary="get states record",
     *   description="",
     *   operationId="site_states",
     *   produces={"application/xml", "application/json"},
	 * 	 @SWG\Parameter(
     *     name="state_name",
     *     in="query",
     *     description="search by state_name",
     *     required=false,
     *     type="string"
     *   ),
	 * 	@SWG\Parameter(
     *     name="state_id",
     *     in="query",
     *     description="search by state_id",
     *     required=false,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="country_id",
     *     in="query",
     *     description="country_id",
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
	public function states_get()
	{
		$where = '';
		$state_name = strtolower($this->input->get_post('state_name'));
		//$output['country_name'] = $country_name;
		if(!empty($state_name)){
			$where .= " AND LOWER(name) = '".$state_name."'";
		}
		$state_id = (int)$this->input->get_post('state_id');
		if(!empty($state_id)){
			$where .= " AND id = '".$state_id."'";
		}

		$country_id = (int)$this->input->get_post('country_id');
		if(!empty($country_id)){
			$where .= " AND country_id = '".$country_id."'";
		}

		$where = ' WHERE '.trim($where," AND ");
  $where = rtrim($where," WHERE ");

		$output['message'] = 'states list';
		$output['status'] = 'SUCCESS';
		$sql = "SELECT * FROM states".$where;
		$query = $this->db->query($sql);
        $output['response']  =  $query->result();

        $this->response($output, REST_Controller::HTTP_OK);
	}
	/**
     * @SWG\Get(path="/site/cities",
     *   tags={"Site"},
     *   summary="get cities record",
     *   description="",
     *   operationId="site_cities",
     *   produces={"application/xml", "application/json"},
	 *  @SWG\Parameter(
     *     name="city_name",
     *     in="query",
     *     description="search by city_name",
     *     required=false,
     *     type="string"
     *   ),
	 * 	@SWG\Parameter(
     *     name="city_id",
     *     in="query",
     *     description="search by city_id",
     *     required=false,
     *     type="number"
     *   ),
     *  @SWG\Parameter(
     *     name="state_id",
     *     in="query",
     *     description="state_id",
     *     required=false,
     *     type="number"
     *   ),
	 *   @SWG\Parameter(
     *     name="country_id",
     *     in="query",
     *     description="country_id",
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
	public function cities_get()
	{
		$where = '';
		$city_name = strtolower($this->input->get_post('city_name'));
		//$output['country_name'] = $country_name;
		if(!empty($city_name)){
			$where .= " AND LOWER(name) = '".$city_name."'";
		}
		$city_id = (int)$this->input->get_post('city_id');
		if(!empty($city_id)){
			$where .= " AND id = '".$city_id."'";
		}

		$state_id = (int)$this->input->get_post('state_id');
		if(!empty($state_id)){
			$where .= " AND state_id = '".$state_id."'";
		}

		$country_id = (int)$this->input->get_post('country_id');
		if(!empty($country_id)){
			$sql = "select id from states where country_id=".$country_id;
			$where .= " AND state_id IN (".$sql.")";
		}

  $term = $this->input->get_post('term');
		if(!empty($term)){
			
			$where .= " AND LOWER(name) LIKE '%".strtolower($term)."%'";
		}
  
		$where = ' WHERE '.trim($where," AND ");
  $where = rtrim($where," WHERE ");

		$output['message'] = 'cities list';
		$output['status'] = 'SUCCESS';
		$sql = "SELECT * FROM cities".$where;
		$query = $this->db->query($sql);
        $output['response']  =  $query->result();

        $this->response($output, REST_Controller::HTTP_OK);
	}

 /**
     * @SWG\Post(path="/site/add_city",
     *   tags={"Site"},
     *   summary="Add city",
     *   description="",
     *   operationId="add_city",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     description="city name",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="state_id",
     *     in="query",
     *     description="state_id",
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
    public function add_city_post()
    {

        //$data = map_column_with_array_key($this->table,$this->input->post('detail'));
        $data = array();
        $data['name'] = $this->input->get_post('name');
        $data['state_id'] = (int)$this->input->get_post('state_id');
        
        $query = $this->db->get_where('cities', array("LOWER(name) "=> strtolower($data['name'])));
        $row = $query->row_array();
        $output['message'] = 'citi added to list';
        $output['status'] = 'SUCCESS';
        //$output['sql'] = $this->db->last_query();
        //$output['row'] = $row;
        if($row['id']){
         $output['response']['id'] = $row['id'];
        }else{
        $this->db->insert("cities", $data);
        $output['response']['id'] = $this->db->insert_id();
        }

        
        
        $this->response($output, REST_Controller::HTTP_OK);

    }
    
    /**
     * @SWG\Post(path="/site/add_product_cities",
     *   tags={"Products"},
     *   summary="Add add_product_cities",
     *   description="",
     *   operationId="add_product_cities",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="product_id",
     *     in="query",
     *     description="product_id",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="tagsinput_values",
     *     in="query",
     *     description="tagsinput_values ex: nagpur, mumbai, delhi....",
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
    public function add_product_cities_post()
    {

        //$data = map_column_with_array_key($this->table,$this->input->post('detail'));
        $data = array();
        $product_id = (int)$this->input->get_post('product_id');
        //$state_id = (int)$this->input->get_post('state_id');
        $tagsinput_values = explode(",",$this->input->get_post('tagsinput_values'));
      $insert_values =array();
      foreach($tagsinput_values as $key=>$val){
         
          $row = array();
          $row['product_id'] = $product_id;
          $row['city'] = trim($val);
          if(empty($val)){
          continue;
          }
          
        $city_data['name'] = trim($val);
        $method = 'POST';
        $url= 'api/site/add_city'; 
        $list = CallAPI($method, $url, $city_data);
        $row['city_id'] = (int)$list['response']['id'];
          
          
          $insert_values[] = $row;
         
      }
      //print_r($insert_values);
      $this->Menus_model->add_update_product_cities($product_id,$insert_values);
        $output['message'] = 'citi added to list';
        $output['status'] = 'SUCCESS';
        $output['response']['tagsinput_values'] = $tagsinput_values;
        $this->response($output, REST_Controller::HTTP_OK);

    }
}
