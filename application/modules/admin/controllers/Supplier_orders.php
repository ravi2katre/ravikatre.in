<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Supplier_orders extends Admin_Controller
{
    public $table = 'supplier_orders';
    public $primary_key_field = 'id';
    public $model_name = 'Supplier_orders_model';
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array($this->model_name,'Users_model','Menus_model'));
        $this->add_stylesheet(BASE_URL . 'assets/bootstrap/css/bootstrap.min.css', true, 'screen');
        $this->add_stylesheet(BASE_URL . 'assets/datatables/css/dataTables.bootstrap.css', true, 'screen');
        //$this->add_script(BASE_URL.'assets/jquery/jquery.js',true,'foot');
        //$this->add_script(BASE_URL.'assets/bootstrap/js/bootstrap.min.js',true,'foot');
        $this->add_script(BASE_URL . 'assets/datatables/js/jquery.dataTables.min.js', true, 'foot');
        $this->add_script(BASE_URL . 'assets/datatables/js/dataTables.bootstrap.js', true, 'foot');
        $this->mViewData['primary_key_field'] = $this->primary_key_field;
        $this->mViewData['display_columns'] = array('', 'id', 'owner_name', 'owner_address', 'owner_gender', 'owner_email', 'owner_phone', 'owner_aadhaar', 'owner_licence', 'name');
        $this->mViewData['columns'] = array('', 'id', 'owner_name', 'owner_address', 'owner_gender', 'owner_email', 'owner_phone', 'owner_aadhaar', 'owner_licence', 'cities.name');
        $this->{$this->model_name}->set_column($this->mViewData['columns']);
        //$this->{$this->model_name}->set_group_ids(array(PARENT));
    }
    public function index()
    {
        $this->mPageTitle = 'Supplier Products';
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
                    $temp = array();
                    $temp = explode(".", $val);
                    $row[] = (isset($temp[1])) ? $item->{$temp[1]} : $item->$val;
                }
            }
            //add html for action
            $row[] = '<!--a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_row(' . "'" . $item->{$this->primary_key_field} . "'" . ')"><i class="glyphicon glyphicon-pencil"></i> Edit</a -->
                <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_row(' . "'" . $item->{$this->primary_key_field} . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                <a class="btn btn-sm btn-warnning " href="supplier_orders/machin_details/'. $item->{$this->primary_key_field} .'" title="Hapus" ><i class="glyphicon glyphicon-resize-full"></i> Details</a>';
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
        $this->_validate();
        $data = map_column_with_array_key($this->table, $this->input->post('detail'));
        //$insert = $this->{$this->model_name}->save($data);
        $data['username'] = $data['email'];
        $output = $this->ion_auth->register($data['email'], $data['password'], $data['email'], $data, $this->input->post('group_ids'));
        if ($output) {
            $this->render_json(array("status" => true));
        } else {
            $this->render_json(array("status" => false));
        }
    }
    public function ajax_update()
    {
        $this->_validate();
        $data = map_column_with_array_key($this->table, $this->input->post('detail'));
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $data['username'] = $data['email'];
        //$this->{$this->model_name}->update(array("{$this->primary_key_field}" => $this->input->post($this->primary_key_field)), $data);
        $this->load->model('Ion_auth_model');
        $this->Ion_auth_model->remove_from_group(null, $this->input->post($this->primary_key_field));
        $this->Ion_auth_model->add_to_group($this->input->post('group_ids'), $this->input->post($this->primary_key_field));
        $this->Ion_auth_model->update($this->input->post($this->primary_key_field), $data);
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
        $this->form_validation->set_rules('detail[first_name]', 'first_name', 'required');
        $this->form_validation->set_rules('detail[last_name]', 'last_name', 'required');
        $this->form_validation->set_rules('detail[email]', 'Email', array('required', array('validate_username', function ($email) {
            //return false;
            $condition['id !='] = $this->input->post('id');
            $condition['email'] = $email;
            $condition = array_filter($condition);
            //cidb($condition );
            $result = $this->db->get_where($this->table, $condition)->row_array();
            //cidb($result);exit;
            if (is_array($result) && array_key_exists('email', $result)) {
                $this->form_validation->set_message('validate_username', 'The  field must contain a unique value.');
                return false;
            } else {
                return true;
            }
            // Check $value
        })));
        if ($this->input->post('id') > 0) {
            if (!empty($this->input->post('detail[password]'))) {
                $this->form_validation->set_rules('detail[password]', 'Password', 'required|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
            }
        } else {
            $this->form_validation->set_rules('detail[password]', 'Password', 'required|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
        }
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

    public function machin_details($id)
    {
        $this->mPageTitle = 'Machin Details';

        $this->db->where('id', $id);
        $detail = $this->{$this->model_name}->get_by_id($id);
        $this->mViewData['machine'] = (array)$detail;
        $detail = $this->Users_model->get_users_by_user_ids($this->mViewData['machine']['user_id']);
        $this->mViewData['user_detail'] = $detail[0];


        $statement['p.menu_id'] = $this->mViewData['machine']['product_id'];
        $detail  = $this->Menus_model->get_product_cities($statement);
        $this->mViewData['machine'] = (array)$detail[0];
        //cidb($this->mViewData['machine']);
        $this->render($this->mCtrler . '/machin_details');

    }
}
