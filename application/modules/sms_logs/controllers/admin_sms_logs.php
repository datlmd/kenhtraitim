<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_sms_logs
 * ...
 * 
 * @package PenguinFW
 * @subpackage sms_logs
 * @version 1.0.0
 * 
 * @property Sms_log         $Sms_log
 */
 
class Admin_sms_logs extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->layout->set_layout('admin');
        
        $this->model_name = 'Sms_log';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('sms_logs', lang_web());
            
        $this->load->model('Sms_log');
    }
    
    /**
     * List
     *
     * @params int $cfn_id
     */
    public function index($cfn_id = 0)
    {
    	// set javascript to view
    	$this->layout->set_javascript(array(
    	                	            'jquery.ui.core.min.js',
    	                	            'jquery.ui.datepicker.min.js'
    	));
    	
    	// set css to view
    	$this->layout->set_rel(array(
    	                	            'jquery.ui.base.css',            
    	                	            'jquery.ui.datepicker.css'
    	));
    	
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Sms_log manager'));
        
        // filter banners
        // filter banner status id
        $filter_type_id = $this->input->get('type_id');
        if ($filter_type_id != -1) {
        	$this->paginator['where']['type_id'] = $filter_type_id;
        }
        
        // filter created from date
        $filter_from_date = $this->input->get('from_date');
        if ($filter_from_date) {
        	$this->paginator['where']['DATE(created) >='] = standar_date($filter_from_date, '-', '-') . ' 00:00:00';
        }
        
        // filter created end date
        $filter_to_date = $this->input->get('to_date');
        if ($filter_to_date) {
        	$this->paginator['where']['DATE(created) <='] = standar_date($filter_to_date, '-', '-') . ' 23:59:59';
        }
        
        // filter phone
        $filter_sender = $this->input->get('sender');
        if ($filter_sender) {
        	$this->paginator['where']['sender'] = $filter_sender;
        }
        
        // filter receiver
        $filter_receiver = $this->input->get('receiver');
        if ($filter_receiver) {
        	$this->paginator['where']['receiver'] = $filter_receiver;
        }
        
        // filter musiccode
        $filter_musiccode = $this->input->get('musiccode');
        if ($filter_musiccode) {
        	$this->paginator['like']['content'] = array($filter_musiccode, 'before');
        }
        
        $this->paginator['order'] = array('id' => 'desc');
        $this->paginator['limit'] = 100;
        
        // get admin_sms_logs
        $admin_sms_logs = $this->pagination(5);
                
        // get $_GET
        $extra_params = get_extra_params_from_url();
        
        $data = array(
            'list_views' => $admin_sms_logs,
            
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => 'sms_logs/admin_sms_logs/edit/'                
            ),
            'pagination_link' => $this->getPaginationLink('/sms_logs/admin_sms_logs/index/' . $cfn_id, 5, $extra_params)
        );
        
        $this->parser->parse($this->router->class . '/index', $data);
    }
                
    /**
     * View data
     *
     * @params int $id
     */
    public function view($id)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('View Sms_log'));
                
        $admin_sms_logs = $this->Sms_log->get(array('id' => $id));
                
        // set data to view
        $data = array(
            'data_view' => $admin_sms_logs
        );
        
        // parser
        $this->parser->parse($this->router->class . '/view', $data);
    }
                
    /**
     * Add data    
     */
    public function add()
    {   
        // check permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Add Sms_log'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
                
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Sms_log->create($this->input->post(), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('sms_logs/admin_sms_logs');
        }
                
        $data = array();
                
        // parser
        $this->parser->parse($this->router->class . '/add', $data);
    }
                
    /**
     * Edit data
     *
     * @params int $id
     */
    public function edit($id = 0)
    {
        // check permission
        $this->PG_ACL('e');
        
        // set title
        $this->layout->set_title(lang('Edit Sms_log'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
                
        // get admin_sms_logs
        $admin_sms_logs = $this->Sms_log->get(array('id' => $id));
            
        if (!$admin_sms_logs)
        {
            show_error(lang('Error params'));
        }
        
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Sms_log->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('sms_logs/admin_sms_logs');
        }
                
        // data to view
        $data = array(
            'data_edit' => $admin_sms_logs
        );
                
        // parser
        $this->parser->parse($this->router->class . '/edit', $data);
    }
                
    /**
     * Delete
     */
    public function delete()
    {
        // check permission
        $this->PG_ACL('d');
        
        $this->deleteRecordOnListView();
    }

    /**
     * @author hungtd
     * Export data
     */
    public function export()
    {
        // check permission
        $this->PG_ACL('r');
        
        // set layout
        $this->layout->set_layout('empty');
        
        // condition to get data export        
        $where = array();
        $like = array();
        
        // check type id
        $type_id = $this->input->get('type_id');        
        if ($type_id != -1)
        {
            if ($type_id)
            {
                 $where['type_id'] = $type_id;
            } else 
            {
                $where['type_id'] = ConstConDuongAmNhac::SmsMo;
            }
        }
        
        // filter created from date
        $filter_from_date = $this->input->get('from_date');
        if ($filter_from_date) {
        	$where['DATE(created) >='] = standar_date($filter_from_date, '-', '-') . ' 00:00:00';
        }
        
        // filter created end date
        $filter_to_date = $this->input->get('to_date');
        if ($filter_to_date) {
        	$where['DATE(created) <='] = standar_date($filter_to_date, '-', '-') . ' 23:59:59';
        }
        
        // filter phone
        $filter_sender = $this->input->get('sender');
        if ($filter_sender) {
        	$where['sender'] = $filter_sender;
        }
        
        // filter receiver
        $filter_receiver = $this->input->get('receiver');
        if ($filter_receiver) {
        	$where['receiver'] = $filter_receiver;
        }
        
        $filter_musiccode = $this->input->get('musiccode');
        if ($filter_musiccode) {
        	$like['content'] = array($filter_musiccode, 'before');
        }
        
        // check data id
        // get only phone number
        $is_only_phone = $this->input->get('phone');
        if ($is_only_phone == 1)
        {
            $datasmses = $this->Sms_log->query(
                    sprintf("
                    		SELECT 
                    			sender AS number 
                    		FROM sms_logs 
                    		WHERE 
                    			type_id = 0 
                    			AND LENGTH(sender) = 11  
                    		GROUP BY sender 
                    		ORDER BY created"
					)
            );
            
            // load xml lib
            $this->load->library('xml');
            // load helper file
            $this->load->helper('file');
            
            $config_options = array(
                    'rootName' => "data",
                    'defaultTagName' => "number",
            );
            
            foreach ($datasmses as $datasms)
            {
                $data_export[] = $datasms['number'];
            }
            
            $string = $this->xml->convert_array_to_xml($data_export, $config_options);
                        
            header('Content-type: "text/xml"; charset="utf8"');
            header('Content-disposition: attachment; filename="UserMobileNumber.xml"');
            echo $string;            
            exit();
            
        } else 
        {
        	
        	$datasmses = $this->Sms_log->find('all', array(
        		'select' => 'created as NgayGui,
                    type_id as TypeSMS,
                    sender as SoDienThoaiGui,
                    receiver as SoDienThoaiNhan,
                    content as NoiDung,
                    status_id as MaTrangThai,
                    error_code as MaLoi',
				'where' => $where,
				'like' => $like,
				'order' => array('created' => 'DESC'),
        	));
        	
            // get data sms
            /*$datasmses = $this->Sms_log->get_select('
                    created as NgayGui,
                    type_id as TypeSMS,
                    sender as SoDienThoaiGui,
                    receiver as SoDienThoaiNhan,
                    content as NoiDung,
                    status_id as MaTrangThai,
                    error_code as MaLoi
                    ', $where, 'created DESC', FALSE, 0);*/
            
            // export
            $this->load->library('Write_exel');
            $this->write_exel->write($datasmses, 'data_sms_' . '_' . date('Y_m_d_H'));
            exit();
        }                        
    }
    
}
                
?>
