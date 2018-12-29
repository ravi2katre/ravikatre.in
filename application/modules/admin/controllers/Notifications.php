<?php
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Strings\EchoedStringsSniff;
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Notifications extends Admin_Controller
{
    public $table = 'notifications';
    public $primary_key_field = 'id';
    public $model_name = 'Notifications_model';
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array($this->model_name, 'Groups_model'));
        $this->add_stylesheet(BASE_URL . 'assets/bootstrap/css/bootstrap.min.css', true, 'screen');
        $this->add_stylesheet(BASE_URL . 'assets/datatables/css/dataTables.bootstrap.css', true, 'screen');
        //$this->add_script(BASE_URL.'assets/jquery/jquery.js',true,'foot');
        //$this->add_script(BASE_URL.'assets/bootstrap/js/bootstrap.min.js',true,'foot');
        $this->add_script(BASE_URL . 'assets/datatables/js/jquery.dataTables.min.js', true, 'foot');
        $this->add_script(BASE_URL . 'assets/datatables/js/dataTables.bootstrap.js', true, 'foot');
        $this->mViewData['primary_key_field'] = $this->primary_key_field;
        $this->mViewData['columns'] = array('', 'id', 'group_name', 'user_ids', 'subject', 'msg', 'msg_type', 'date');
        $this->{$this->model_name}->set_column($this->mViewData['columns']);
        //$this->{$this->model_name}->set_group_ids(array(PARENT));
    }
    public function index()
    {
        $this->load->helper('url');
        $this->mViewData['list'] = $this->{$this->model_name}->get_rows();
        $this->mViewData['groups'] = $this->db->get('groups')->result();
        $this->render($this->mCtrler . '/list');
    }
    public function ajax_list()
    {
        $list = $this->{$this->model_name}->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $item->{$this->primary_key_field} . '" onclick="showBottomDelete()"/>';
            foreach ($this->mViewData['columns'] as $val) {
                if (!empty($val)) {
                    $row[] = $item->$val;
                }
            }
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_row(' . "'" . $item->{$this->primary_key_field} . "'" . ')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_row(' . "'" . $item->{$this->primary_key_field} . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
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
        $data->group_ids = $this->db->where('user_id', $id)->get('users_groups')->result();
        $this->render_json($data);
    }
    public function ajax_add()
    {
        $post = $this->input->post();
        //call API()
        $data = array();
        $data['group_name'] = $post['detail']['group_name'];
        //$data['user_ids'] = '';
        //$data['phone'] = '';
        $data['msg_type'] = $post['detail']['msg_type'];
        $data['subject'] = $post['detail']['subject'];
        $data['msg'] = $post['detail']['msg'];

        $method = 'POST';
        $url= 'api/users/notifications_send';
        $log  = " \n ";
        $log .= '--------------start----------------';
        $log .= 'url:'.  $url;
        $log .= 'Data: '.print_r($data, true);
        logit($log, 'notification_ajax_add');
        $response = CallAPI($method, $url, $data);
        $log  = '';
        $log .= 'Response: '.print_r($response, true);
        $log .= '--------------End----------------';
        logit($log, 'notification_ajax_add');

        $this->_validate();
        $data = map_column_with_array_key($this->table, $this->input->post('detail'));
        $insert = $this->{$this->model_name}->save($data);
        if ($insert) {
            $this->render_json(array("status" => true));
        } else {
            $this->render_json(array("status" => false));
        }
    }
    public function ajax_update()
    {
        $this->_validate();
        $data = map_column_with_array_key($this->table, $this->input->post('detail'));
        //$data['username'] = $data['email'];
        $this->{$this->model_name}->update(array("{$this->primary_key_field}" => $this->input->post($this->primary_key_field)), $data);
        $this->render_json(array("status" => true));
    }
    public function ajax_delete($id)
    {
        $this->{$this->model_name}->delete_by_id($id);
        $this->render_json(array("status" => true));
    }
    public function ajax_list_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->{$this->model_name}->delete_by_id($id);
        }
        $this->render_json(array("status" => true));
    }
    private function _validate()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters("<p>", "</p>");
        $this->form_validation->set_rules('detail[msg]', 'msg', 'required');
        $this->form_validation->set_rules('detail[subject]', 'subject', 'required');
        $data = array();
        $data['error_string'] = array();
        $data['status'] = true;
        if ($this->form_validation->run() == false) {
            $data['error_string'] = validation_errors();
            $data['status'] = false;
        } else {
            $data['status'] = true;
        }
        if ($data['status'] === false) {
            $this->render_json($data);
            exit();
        }
    }
}
