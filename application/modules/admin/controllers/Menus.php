<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menus extends Admin_Controller{

  public function __construct()
  {
      parent::__construct();
      $this->load->libraries(array('rest'));
      $this->load->model(array('Menus_model','Users_model'));
      $this->add_stylesheet(BASE_URL.'assets/bootstrap/css/bootstrap.min.css',true,'screen');
      //$this->add_stylesheet(BASE_URL.'assets/datatables/css/dataTables.bootstrap.css',true,'screen');
      $this->add_stylesheet('https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css',true,'screen');
      //$this->add_script(BASE_URL.'assets/jquery/jquery.js',true,'foot');
      //$this->add_script(BASE_URL.'assets/bootstrap/js/bootstrap.min.js',true,'foot');
	   $this->add_stylesheet(BASE_URL.'assets/bootstrap-tagsinput/dist/bootstrap-tagsinput.css',true,'screen');

      $this->add_script(BASE_URL.'assets/datatables/js/jquery.dataTables.min.js',true,'foot');
      $this->add_script('https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js',true,'foot');
      $this->add_script('https://cdn.datatables.net/select/1.2.2/js/dataTables.select.min.js',true,'foot');
      $this->add_script('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',true,'foot');
      $this->add_script('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js',true,'foot');
      $this->add_script('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js',true,'foot');
      $this->add_script('https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js',true,'foot');
      //$this->add_script('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',true,'foot');

      $this->add_script(BASE_URL.'assets/datatables/js/dataTables.bootstrap.js',true,'foot');


	  $this->add_script(BASE_URL.'assets/bootstrap-tagsinput/dist/bootstrap-tagsinput.js',true,'head');
      $this->add_script(BASE_URL.'assets/bootstrap-tagsinput/dist/typeahead.bundle.js',true,'head');
      $this->add_stylesheet('http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css',true,'screen');
      $this->add_script('http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js',true,'foot');

  }

  public function index()
  {
      $this->load->helper('url');
      $this->mViewData['list'] = $this->Menus_model->get_rows();
      $this->mViewData['groups'] = $this->db->get('groups')->result();

      $this->render('menus/menus.php');
  }
  public function front_pages()
  {
      $this->load->helper('url');
      $this->mViewData['list'] = $this->Menus_model->get_liniage_rows(FRONT_MENU);
      $this->mViewData['groups'] = $this->db->get('groups')->result();

      $this->render('menus/front_menus.php');
  }
  public function product_pages()
  {
      $this->load->helper('url');
      $this->mViewData['list'] = $this->Menus_model->get_liniage_rows(PRODUCT_MENU);
      $this->mViewData['groups'] = $this->db->get('groups')->result();

      $this->render('menus/product_menus.php');
  }
  public function export()
  {
      $_POST = $this->session->userdata['keep_post_data'];
      //cidb($_POST);
      $data = $this->Menus_model->export();
     // cidb($list);
      header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"test".".csv\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $handle = fopen('php://output', 'w');

      foreach ($data as $data) {
          fputcsv($handle, objToArray($data));
      }
      fclose($handle);
      exit;
      //$this->render_json($list);
      //exit;
  }
  public function ajax_list()
  {
      $this->session->set_userdata('keep_post_data', $this->input->post());

      $list = $this->Menus_model->get_datatables();
      $data = array();
      $no = $this->input->post('start');
      foreach ($list as $menus) {
          $no++;
          $row = array();
          $row[] = '<input type="checkbox" class="data-check" value="'.$menus->menu_id.'" onclick="showBottomDelete()"/>';
          $row[] = $menus->name;
          $row[] = $menus->parent_menu;
          $row[] = $menus->url;
          $row[] = $menus->icon;
          $row[] = $menus->sort_by;

          //add html for action
          $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_menu('."'".$menus->menu_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_menu('."'".$menus->menu_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
          $data[] = $row;
      }
      $output = array(
                      "draw" => $this->input->post('draw'),
                      "recordsTotal" => $this->Menus_model->count_all(),
                      "recordsFiltered" => $this->Menus_model->count_filtered(),
                      "data" => $data,
              );
      //output to json format
      $this->render_json($output);
  }

  public function front_ajax_list()
  {
      $this->session->set_userdata('keep_post_data', $this->input->post());
        $this->db->like("t1.liniage", "/".FRONT_MENU);
        $this->db->where('t1.menu_id !=', FRONT_MENU);
      $list = $this->Menus_model->get_datatables();
      $data = array();
      $no = $this->input->post('start');
      foreach ($list as $menus) {
          $no++;
          $row = array();
          $row[] = '<input type="checkbox" class="data-check" value="'.$menus->menu_id.'" onclick="showBottomDelete()"/>';
          $row[] = $menus->name;
          $row[] = $menus->parent_menu;
          $row[] = $menus->url;
          $row[] = $menus->icon;
          $row[] = $menus->sort_by;

          //add html for action
          $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_menu('."'".$menus->menu_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_menu('."'".$menus->menu_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
          $data[] = $row;
      }
      $this->db->like("liniage", "/".FRONT_MENU);
      $this->db->where('menu_id !=', FRONT_MENU);
      $recordsTotal = $this->Menus_model->count_all();
      $this->db->like("t1.liniage", "/".FRONT_MENU);
      $this->db->where('t1.menu_id !=', FRONT_MENU);
      $count_filtered = $this->Menus_model->count_filtered();
      $output = array(
                      "draw" => $this->input->post('draw'),
                      "recordsTotal" => $recordsTotal,
                      "recordsFiltered" => $count_filtered,
                      "data" => $data,
              );
      //output to json format
      $this->render_json($output);
  }
  public function product_ajax_list()
  {
      $this->session->set_userdata('keep_post_data', $this->input->post());
        $this->db->like("t1.liniage", PRODUCT_MENU."/");
		$this->db->where("t1.user_id", 1);

      $list = $this->Menus_model->get_datatables();
      $data = array();
      $no = $this->input->post('start');
      foreach ($list as $menus) {
          $no++;
          $row = array();
          $row[] = '<input type="checkbox" class="data-check" value="'.$menus->menu_id.'" onclick="showBottomDelete()"/>';
          $row[] = $menus->name;
          $row[] = $menus->parent_menu;
          $row[] = $menus->url;
          $row[] = $menus->icon;
          $row[] = $menus->sort_by;

          //add html for action
          $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_menu('."'".$menus->menu_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_menu('."'".$menus->menu_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
          $data[] = $row;
      }
      $this->db->like("liniage", "/".PRODUCT_MENU);
      $this->db->where('menu_id !=', PRODUCT_MENU);
      $this->db->where("user_id", 1);
      $recordsTotal = $this->Menus_model->count_all();
      $this->db->like("t1.liniage", "/".PRODUCT_MENU);
      $this->db->where('t1.menu_id !=', PRODUCT_MENU);
      $this->db->where("t1.user_id", 1);
      $count_filtered = $this->Menus_model->count_filtered();
      $output = array(
                      "draw" => $this->input->post('draw'),
                      "recordsTotal" => $recordsTotal,
                      "recordsFiltered" => $count_filtered,
                      "data" => $data,
              );
      //output to json format
      $this->render_json($output);
  }

  public function ajax_edit($id)
  {
      $data = $this->Menus_model->get_by_id($id);
      $data->group_ids = $this->Menus_model->menus_groups_get_by_id($id);

      $statement['p.menu_id'] = $id;
      $list = $this->Menus_model->get_product_cities_admin($statement);
      $data->tags_values = $list;
      $this->render_json($data);
  }

  public function ajax_add()
  {

	  $user_detail = $this->Users_model->get_users_by_user_ids($this->mUser->id);

      $this->_validate();
      $data = array(
              'name' => $this->input->post('name'),
              'icon' => $this->input->post('icon'),
              'url' => $this->input->post('url'),
              'sort_by' => $this->input->post('sort_by'),
              'parent_id' => $this->input->post('parent_id'),
              'user_id' => ($user_detail[0]['group_id']==1 || $user_detail[0]['group_id']==2 )? 1 : $this->mUser->id,
          );

          if(isset($_FILES['userfile']) && $_FILES['userfile']['error'] == 0){
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
            }

      if($this->input->post('content')){
        $data['content'] =  $this->input->post('content');
      }

      $insert = $this->Menus_model->save($data);

      if($this->input->post('parent_id') > 0){

        $parent = $this->Menus_model->get_by_id($this->input->post('parent_id'));
        $data = array(
            'liniage' => $parent->liniage."/".$insert,
        );

      }else{
        $data = array(
            'liniage' => "/".$insert,
        );
      }
      $this->Menus_model->update(array('menu_id' => $insert), $data);

      $this->Menus_model->insert_menus_groups($this->input->post('group_ids'),$insert);

      if($this->input->post('tagsinput_values')){

        $method = 'POST';
        $url= 'api/site/add_product_cities';
        $data2['product_id'] = (int) $insert;
        $data2['tagsinput_values'] = $this->input->post('tagsinput_values');

        // insert product cities
        CallAPI($method, $url, $data2);
      }

      $this->render_json(array("status" => TRUE));
  }

  public function ajax_update()
  {
      $this->_validate();
      $data = array(
          'name' => $this->input->post('name'),
          'icon' => $this->input->post('icon'),
          'sort_by' => $this->input->post('sort_by'),
          'url' => $this->input->post('url'),
          'parent_id' => $this->input->post('parent_id'),

          );
          if($this->input->post('content')){
            $data['content'] =  $this->input->post('content');
          }
      if($this->input->post('tagsinput_values')){

        $method = 'POST';
        $url= 'api/site/add_product_cities';
        $data2['product_id'] = (int) $this->input->post('menu_id');
        $data2['tagsinput_values'] = $this->input->post('tagsinput_values');

        // insert product cities
        CallAPI($method, $url, $data2);
      }
          if(isset($_FILES['userfile']) && $_FILES['userfile']['error'] == 0){
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
            }

      $this->Menus_model->update(array('menu_id' => $this->input->post('menu_id')), $data);
      $this->Menus_model->insert_menus_groups($this->input->post('group_ids'),$this->input->post('menu_id'));
      $this->render_json(array("status" => TRUE));
  }

  public function ajax_delete($id)
  {
      $this->Menus_model->delete_by_id($id);
      $this->render_json(array("status" => TRUE));
  }

  public function ajax_list_delete()
   {
       $list_id = $this->input->post('id');
       foreach ($list_id as $id) {
           $this->Menus_model->delete_by_id($id);
       }
       $this->render_json(array("status" => TRUE));
   }

  private function _validate()
  {
      $data = array();
      $data['error_string'] = array();
      $data['inputerror'] = array();
      $data['status'] = TRUE;

      if($this->input->post('name') == '')
      {
          $data['inputerror'][] = 'name';
          $data['error_string'][] = 'First name is required';
          $data['status'] = FALSE;
      }

      if($this->input->post('url') == '')
      {
          $data['inputerror'][] = 'url';
          $data['error_string'][] = 'First lastname is required';
          $data['status'] = FALSE;
      }

      if($data['status'] === FALSE)
      {
          $this->render_json($data);
          exit();
      }
  }

  public function upload_file($filename = 'userfile', $org_filename = "no-name.png")
  {

      //echo "nnn";
      //mkdir_if_not_exist(FCPATH.'uploads/images/');
      $config['upload_path'] = FCPATH.'uploads/images/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_size'] = 10000;
      $config['max_width'] = (2048 * 4);
      $config['max_height'] = (768 * 4);
      $this->load->library('upload', $config);
      if (!$this->upload->do_upload()) {
          $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
          return $error = array('error' => $this->upload->display_errors());

      } else {
          return $data = array('upload_data' => $this->upload->data());
      }
  }

}
