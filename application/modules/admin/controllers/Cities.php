<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cities extends Admin_Controller{
    var $table = 'cities';
    var $primary_key_field = 'id';
    var $model_name = 'Cities_model';
    public function __construct()
  {
      parent::__construct();
      $this->load->model($this->model_name);
      $this->add_stylesheet(BASE_URL.'assets/bootstrap/css/bootstrap.min.css',true,'screen');
      $this->add_stylesheet(BASE_URL.'assets/datatables/css/dataTables.bootstrap.css',true,'screen');
      //$this->add_script(BASE_URL.'assets/jquery/jquery.js',true,'foot');
      //$this->add_script(BASE_URL.'assets/bootstrap/js/bootstrap.min.js',true,'foot');
      $this->add_script(BASE_URL.'assets/datatables/js/jquery.dataTables.min.js',true,'foot');
      $this->add_script(BASE_URL.'assets/datatables/js/dataTables.bootstrap.js',true,'foot');
      $this->mViewData['primary_key_field'] = $this->primary_key_field;
      $this->mViewData['columns'] = array('','name','city_state');
      $this->{$this->model_name}->set_column($this->mViewData['columns']);
      //$this->{$this->model_name}->set_group_ids(array(PARENT));
  }
  public function index()
  {
      $this->load->helper('url');
      $this->mViewData['list'] = $this->{$this->model_name}->get_rows();
      $this->mViewData['groups'] = $this->db->get('groups')->result();
      $this->render($this->mCtrler.'/list');
  }
    public function ajax_list()
    {
        $list = $this->{$this->model_name}->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$item->{$this->primary_key_field}.'" onclick="showBottomDelete()"/>';
            foreach($this->mViewData['columns'] as $val){
                if(!empty($val)){
                    $row[] = $item->$val;
                }
            }
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_row('."'".$item->{$this->primary_key_field}."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_row('."'".$item->{$this->primary_key_field}."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->{$this->model_name}->count_all(),
            "recordsFiltered" => $this->{$this->model_name}->count_filtered(),
            "data" => $data,
            "last_query" => $this->db->last_query(),
        );
        //output to json format
        $this->render_json($output);
    }
  public function ajax_edit($id)
  {
      $data = $this->{$this->model_name}->get_by_id($id);
      $data->group_ids = $this->db->where('user_id',$id)->get('users_groups')->result();
      $this->render_json($data);
  }
  public function ajax_add()
  {
      $this->_validate();
      $data = map_column_with_array_key($this->table,$this->input->post('detail'));
      $insert = $this->{$this->model_name}->save($data);

      if($insert){
          $this->render_json(array("status" => TRUE));
      }else{
          $this->render_json(array("status" => FALSE));
      }
  }
  public function ajax_update()
  {
      $this->_validate();
      $data = map_column_with_array_key($this->table,$this->input->post('detail'));

      $this->{$this->model_name}->update(array("{$this->primary_key_field}" => $this->input->post($this->primary_key_field)), $data);

      $this->render_json(array("status" => TRUE));
  }
  public function ajax_delete($id)
  {
      $this->{$this->model_name}->delete_by_id($id);
      $this->render_json(array("status" => TRUE));
  }
  public function ajax_list_delete()
   {
       $list_id = $this->input->post('id');
       foreach ($list_id as $id) {
           $this->{$this->model_name}->delete_by_id($id);
       }
       $this->render_json(array("status" => TRUE));
   }
  private function _validate()
  {
      $this->load->library('form_validation');
      $this->form_validation->set_error_delimiters("<p>", "</p>");
      $this->form_validation->set_rules('detail[name]', 'name', 'required');
      $data = array();
      $data['error_string'] = array();
      $data['status'] = TRUE;
      if ($this->form_validation->run() == FALSE){
          $data['error_string'] =  validation_errors();
          $data['status'] = FALSE;
      }else{
          $data['status'] = TRUE;
      }
      if($data['status'] === FALSE){
          $this->render_json($data);
          exit();
      }
  }
}
?>