<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_reports
 * ...
 * 
 * @package PenguinFW
 * @subpackage reports
 * @version 1.0.0
 * 
 * @property Module             $Module
 * @property Module_resource    $Module_resource
 */
 
class Admin_reports extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Report';
        
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('reports', lang_web());
            
        $this->load->model('Report');
    }
    
    /**
     * List
     *
     * @params int $cfn_id
     */
    public function index($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Report manager'));
        
        // get module
        $admin_reports = $this->pagination(5);
                
        $data = array(
            'list_views' => $admin_reports,
            
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => array(
                'View' => 'reports/admin_reports/view/',
                'Export' => 'reports/admin_reports/export/',
                'Edit' => 'reports/admin_reports/edit/'
            ),
            'pagination_link' => $this->getPaginationLink('/reports/admin_reports/index/' . $cfn_id, 5)
        );
        
        $this->parser->parse($this->router->class . '/index', $data);
    }
                
    /**
     * View data
     *
     * @params int $id
     */
    public function view($id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('View Report'));
                
        // get report info
        $admin_reports = $this->Report->get(array('id' => $id));
        
        if (!$admin_reports)
        {
            show_error(lang('Error params'));
        }
        
        // get report
        $result = $this->Report->query($admin_reports->query);
                
        // set data to view
        $data = array(
            'result' => $result,
            'report_id' => $id
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
        $this->layout->set_title(lang('Add Report'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
                
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            $id = $this->Report->create($this->input->post(), TRUE);
            if ($id)
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect("reports/admin_reports/create_query/$id");
        }
                
        $data = array(
            'share_types' => array(
                ConstGlobal::share => lang(ConstGlobal::share),
                ConstGlobal::onlyme => lang(ConstGlobal::onlyme)
            )
        );
                
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
        $this->layout->set_title(lang('Edit Report'));
                
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        // get user_id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
        
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // save data
            if ($this->Report->update($this->input->post(), array('id' => $id), TRUE))
            {
                $this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                $this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect("reports/admin_reports/create_query/$id");
        }                        
        
        // get user
        $admin_reports = $this->Report->get(array('id' => $id));
                
        // data to view
        $data = array(
            'data_edit' => $admin_reports,
            'share_types' => array(
                ConstGlobal::share => lang(ConstGlobal::share),
                ConstGlobal::onlyme => lang(ConstGlobal::onlyme)
            )
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
     * create query
     * 
     * @param int $id report id
     */
    public function create_query($id = 0)
    {
        // check permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Create result report'));                
        
        // get all module
        $this->load->model('modules/Module');        
        $modules = $this->Module->get(array(), 'name asc', FALSE, 0);
        
        $data = array(
            'modules' => $modules,
            'report_id' => $id
        );
        
        // parser
        $this->parser->parse($this->router->class . '/create_query', $data);
    }
    
    /**
     * user choose field for report
     */
    public function gen_query()
    {
        // check permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Choose colums report'));
        
        // set javascript
        $this->layout->set_javascript(array(
            'jquery.multi-select.js'
        ));
        
        // set css
        $this->layout->set_rel(array(            
            'multi-select.css'
        ));
        
        // create query with relation
        if ($this->input->post())
        {
            $report_id          = $this->input->post('report_id');
            $main_resource_id   = $this->input->post('main_resource_id');
            $relation_ids       = $this->input->post('relation_ids');
            
            // load model module field
            $this->load->model('module_fields/Module_field');
            
            // get main resource field
            $fields[0]['resource'] = $this->getResourceName($main_resource_id);
            $fields[0]['fields'] = $this->Module_field->get(array('resource_id' => $main_resource_id), 'weight asc', FALSE, 0);
            
            // get resource relation field
            $resources = array();
            $i = 1;
            foreach ($relation_ids as $relation_id)
            { 
                $resources[] = $relation_id;
                $fields[$i]['resource'] = $this->getResourceName($relation_id);                
                $fields[$i]['fields'] = $this->Module_field->get(array('resource_id' => $relation_id), 'weight asc', FALSE, 0);
            }                        
            
            // parser
            $this->parser->parse($this->router->class . '/gen_query', array(
                'main_resource_id' => $main_resource_id,
                'report_id' => $report_id,
                'resource_ids' => $resources,
                'fields' => $fields
            ));
        } else 
        {
            show_404();
        }
    }
    
    /**
     * create query and generate
     */
    public function generate()
    {
        // check permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Create report'));
        
        // create report
        if ($this->input->post())
        {
            // lib
            $this->load->model('modules/Module_relation');
            
            // get data
            $main_resource_id = $this->input->post('main_resource_id');
            $resource_ids   = $this->input->post('resource_ids');
            $report_id      = $this->input->post('report_id');
            $fields         = $this->input->post('choose_fields');
            
            // get main resource name
            $main_resource_name = $this->getResourceName($main_resource_id);
            
            // field show colum
            $field_colum = array();
            
            if (!empty ($fields))
            {
                $field_select = '';                
                
                // get field
                foreach ($fields as $field)
                {
                    if (strpos($field, '.') !== FALSE)
                    {
                        $field_arr = explode('.', $field);
                        $f_resource = $field_arr[0];
                        $f_field = $field_arr[1];
                        
                        if ($field_arr != $main_resource_name)
                        {
                            $field_select .= $field . ' AS ' . $f_resource . '_' . $f_field . ',';
                            $field_colum[] = $f_resource . '_' . $f_field;
                        } else 
                        {
                            $field_select .= $field;
                            $field_colum[] = $f_field;
                        }
                    }
                }
                
                $field_select = substr($field_select, 0, strlen($field_select)-1);
                
                // get query
                $query = sprintf("SELECT %s FROM %s", $field_select, $main_resource_name);
                
                // get join
                if (!empty ($resource_ids))
                {
                    foreach ($resource_ids as $resource_id)
                    {
                        // get relation
                        $relation = $this->Module_relation->get(array('module_id' => $main_resource_id, 'module_relation_id' => $resource_id));
                        
                        // get join if has relation
                        if ($relation)
                        {
                            $join = $this->getResourceName($relation->module_relation_id);
                            $on = $join . '.' . $relation->primary_key . ' = ' . $main_resource_name . '.' . $relation->foreign_key;
                            $query .= sprintf(" JOIN %s ON %s", $join, $on);
                        }
                    }
                }
                
                $query .= " LIMIT 1000";
                
                // update report
                $this->Report->update(array('query' => $query), array('id' => $report_id));
                
                // get result
                $result = $this->Report->query($query);
                
                $this->parser->parse($this->router->class . '/generate', array(
                    'result' => $result,
                    'report_id' => $report_id,
                    'field_colum' => $field_colum
                ));
            }
        } else 
        {
            show_404();
        }
    }
    
    /**
     * export exel
     * 
     * @param int $id 
     */
    public function export($id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set layout
        $this->layout->set_layout('empty');
                
        // get report info
        $admin_reports = $this->Report->get(array('id' => $id));
        
        if (!$admin_reports)
        {
            show_error(lang('Error params'));
        }
        
        // get report
        $result = $this->Report->query($admin_reports->query);
        
        if (!$result)
        {
            $result = array();
        }
        
        // export
        $this->load->library('Write_exel');
        $this->write_exel->write($result, make_slug($admin_reports->name) . '_' . date('Y_m_d_H'));
        exit();
    }
}
                
?>