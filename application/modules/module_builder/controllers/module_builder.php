<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * Tự động add module resource cho FW
 * Add file / database
 * 
 * @author      hungtd <tdhungit@gmail.com> 0972014011
 * @copyright   Tran Dinh Hung 2011
 * @package     PenguinFW
 * @subpackage  ModuelBuilder
 * @version     1.0.0
 * 
 * @property M_builder      $M_builder
 */

class Module_builder extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('date');
        $this->layout->set_layout('admin');
    }
    
    public function index()
    {
        if (!is_admin())
        {
            redirect('users/admin_users/permission');
        }
        
        $this->load->helper('file');
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('module', 'Module', 'required');
		$this->form_validation->set_rules('module_resource', 'Module resource', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        
        $error_message = '';                
                
        if ($this->form_validation->run() == TRUE) 
        {
            // field name add cfn default
            $default_cf = array(
                'name',
                'link',
                'weight',
                'created',
                'description',
                'full_name',
                'dob',
                'phone',
                'email',
                'point',
                'username'
            );
            
            // get data from form
            $module                     = strtolower($this->input->post('module'));
            $model                      = strtolower($this->input->post('model'));
            $module_resource            = strtolower($this->input->post('module_resource'));
            $module_resource_main       = strtolower($this->input->post('module_resource_main'));
            $username                   = strtolower($this->input->post('username'));
            
            //$new_module                 = $this->input->post('new_module');
            //$new_resource               = $this->input->post('new_resource');
            //$new_model                  = $this->input->post('new_model');
            $new_module                 = (is_dir(FPENGUIN . APPPATH . "modules/$module")) ? 0 : 1;
            if ($new_module == 1)
            {
                $new_resource           = 1;
                $new_model              = 1;
            } else 
            {
                $new_resource           = (is_file(FPENGUIN . APPPATH . "modules/$module/controllers/$module_resource.php")) ? 0 : 1;
                $new_model              = (is_file(FPENGUIN . APPPATH . "modules/$module/models/$model.php")) ? 0 : 1;
            }
            
            $insert_field               = $this->input->post('insert_field');
            $db_table                   = strtolower($this->input->post('db_table'));
            
            $is_c_admin                 = (strpos($module_resource, 'admin') !== FALSE) ? 1 : 0;
            
            // check data require
            if (!$module || !$model || !$module_resource || !$username) 
            {                
                show_error(lang('Please input field require (module, model, module resource, username)'));
            }
            
            // get class name
            $model_class    = ucfirst($model);
            $resource_class = ucfirst($module_resource);
            $db_table       = ($db_table) ? $db_table : $module;
            
            //////////////////////////////////////////
            
            //////////////////////////////////////////

            // check username 
            $dbqueryuser = $this->db->get_where('users', array('username' => $username));
            if ($dbqueryuser->num_rows() == 0) 
            {
                show_error (lang('Username is not exit.'));
            }
            $dbuser = $dbqueryuser->row();
            
            // query module
            $this->db->select('id');                
            $dbmodule = $this->db->get_where('modules', array('name' => $module));
            
            // check condition and module
            if ($new_module != 1 && $dbmodule->num_rows() == 0) 
            {
                show_error (lang('Module is not exit. You can not create it.'));
            }
            
            // check module
            if ($new_module == 1 && $dbmodule->num_rows() > 0)
            {
                show_error (lang('Module is exit.'));
            }
            
            // check resource            
            $this->db->select('id');
            $dbresource = $this->db->get_where('module_resources', array('name' => $module_resource));
            
            // check resource and conditions
            if ($new_resource != 1 && $dbresource->num_rows() == 0) 
            {
                show_error (lang('Resource is not exit. Please choose the resource is exit'));
            }
            
            if ($new_resource == 1 && $dbresource->num_rows() > 0)
            {
                show_error (lang('Resource is exit. You can create it'));
            }
            
            // check main resource
            $this->db->select('id');
            $dbmainresource = $this->db->get_where('module_resources', array('name' => $module_resource_main));
            $resource_main_id = ($dbmainresource->num_rows() == 0) ? 0 : $dbmainresource->row()->id;
            
            // check insert field
            if ($insert_field == 1 && $resource_main_id > 0)
            {
                show_error(lang('Can not insert field. If resource is not main, you can not insert fields.'));
            }
            
            // module not exit -> insert module to database
            if ($dbmodule->num_rows() == 0) 
            {
                $dbmodule_data = array(
                    'created' => mdate('%Y-%m-%d %H:%i:%s', now()),
                    'modified' => mdate('%Y-%m-%d %H:%i:%s', now()),
                    'name' => $module,
                    'user_id' => $dbuser->id
                );
                $this->db->insert('modules', $dbmodule_data);
                // get id module
                $dbmodule_id = $this->db->insert_id();
            } else 
            {
                $dbmodule_id = $dbmodule->row()->id;
            }
            
            // check insert module
            if (!$dbmodule_id)
            {
                show_error (lang('Insert module error.'));
            }                                                
            
            // resource not exit -> insert database
            if ($dbresource->num_rows() == 0) 
            {
                $dbresource_data = array(
                    'created' => mdate('%Y-%m-%d %H:%i:%s', now()),
                    'modified' => mdate('%Y-%m-%d %H:%i:%s', now()),
                    'name' => $module_resource,
                    'main_id' => $resource_main_id,
                    'module_id' => $dbmodule_id,
                    'user_id' => $dbuser->id
                );
                $this->db->insert('module_resources', $dbresource_data);
                
                // get resource id
                $dbresource_id = $this->db->insert_id();
            } else 
            {
                $dbresource_id = $dbresource->row()->id;
            }
            
            // check insert module resource
            if (!$dbresource_id) 
            {
                show_error (lang('Insert module resource error.'));
            }                        
            
            // check insert field and custom field
            if ($insert_field == 1 && $resource_main_id == 0 && $db_table) 
            {
                // insert custom field name
                $dbcf_name = $this->db->get_where('custom_field_names', array('resource_id' => $dbresource_id));

                if ($dbcf_name->num_rows() == 0)
                {
                    $this->db->insert('custom_field_names', array(
                        'created' => mdate('%Y-%m-%d %H:%i:%s', now()),
                        'modified' => mdate('%Y-%m-%d %H:%i:%s', now()),
                        'name' => ConstCustomField::defaultName,
                        'share' => ConstCustomField::all,
                        'resource_id' => $dbresource_id,
                        'user_id' => $dbuser->id
                    ));
                    
                    $cfn_id = $this->db->insert_id();
                } else 
                {
                    $cfn_id = 0;
                }
                
                // get data field
                $fields = $this->db->field_data($db_table);
                
                $i = 0;
                foreach ($fields as $field)
                {      
                    // get field
                    $dbfield = $this->db->get_where('module_fields', array('resource_id' => $dbresource_id, 'name' => $field->name));
                    
                    // insert if have not field in module_fields
                    if ($dbfield->num_rows() == 0)
                    {
                        $i++;
                        $mfields = array(
                            'created' => mdate('%Y-%m-%d %H:%i:%s', now()),
                            'modified' => mdate('%Y-%m-%d %H:%i:%s', now()),
                            'name' => $field->name,
                            'resource_id' => $dbresource_id,
                            'weight' => $i,
                            'user_id' => $dbuser->id
                        );
                        
                        // get file_tyoe
                        switch ($field->type)
                        {                            
                            case 'int':
                                $mfields['field_type'] = ConstFieldType::num;
                                break;
                            
                            case 'datetime':
                                $mfields['field_type'] = ConstFieldType::datetime;
                                break;
                            
                            case 'date':
                                $mfields['field_type'] = ConstFieldType::date;
                                break;
                                
                            case 'blob':
                                $mfields['field_type'] = ConstFieldType::area;
                                break;
                                
                            default:
                                $mfields['field_type'] = ConstFieldType::text;
                                break;
                        } //// switch field type
                        
                        switch ($field->name)
                        {
                            case 'meta_keyword':
                            case 'meta_description':
                                $mfields['field_type'] = ConstFieldType::area;
                                break;
                            default:
                                break;
                        } //// switch field name
                        
                        if ($this->db->insert('module_fields', $mfields))
                        {
                            $field_id = $this->db->insert_id();
                        } else 
                        {
                            $field_id = 0;
                        }
                        
                        // insert custom field
                        if ($cfn_id && $field_id)
                        {
                            if (in_array($field->name, $default_cf))
                            {
                                $this->db->insert('custom_fields', array(
                                    'name_id' => $cfn_id,
                                    'field_id' => $field_id,
                                    'created' => mdate('%Y-%m-%d %H:%i:%s', now()),
                                    'modified' => mdate('%Y-%m-%d %H:%i:%s', now())
                                ));
                            }
                        }
                        
                    } else 
                    {
                        $i = $dbfield->row()->weight;
                    }
                }
            } //// // check insert field and custom field

            // add folder and class file
            if ($new_module == 1)
            {
                @mkdir(FPENGUIN . 'application/modules/'.$module.'/controllers', 0775, true);
                @mkdir(FPENGUIN . 'application/modules/'.$module.'/models', 0775, true);
                @mkdir(FPENGUIN . 'application/views/'.theme_web().'/'.$module, 0775, true);
                
                // create file lang
                $lang_content = '<?php $lang = array(); ?>';
                write_file(FPENGUIN . 'application/language/' . lang_web() . '/' . $module . '_lang.php', $lang_content);
            }
            
            // controller content user page
            $controller_user_page = "<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN_LITE FrameWork
 * @author hoanhk
 * @copyright Huynh Kim Hoan 2013
 * 
 * Controller $resource_class
 * ...
 * 
 * @package Penguin_liteFW
 * @subpackage $module
 * @version 2.0.0
 */
 
class $resource_class extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        \$this->model_name = '$model_class';
                
        \$this->lang->load('generate', lang_web());
        \$this->lang->load('".$module."', lang_web());
            
        \$this->load->model('$model_class');
    }



}
                
?>";
            
            // resource class content
            $resource_class_content = "<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN_LITE FrameWork
 * @author hoanhk
 * @copyright Huynh Kim Hoan 2013
 * 
 * Controller $resource_class
 * ...
 * 
 * @package Penguin_liteFW
 * @subpackage $module
 * @version 2.0.0
 */
 
class $resource_class extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        \$this->layout->set_layout('admin');
            
        \$this->model_name = '$model_class';
                
        \$this->lang->load('generate', lang_web());
        \$this->lang->load('".$module."', lang_web());
            
        \$this->load->model('$model_class');
    }
    
    /**
     * List
     *
     * @params int \$cfn_id
     */
    public function index(\$cfn_id = 0)
    {
        // check permission
        \$this->PG_ACL('r');
        
        // set title
        \$this->layout->set_title(lang('$model_class manager'));
        
        // get admin_game_daily_reports
        \$data = \$this->_listView('index', \$cfn_id);
        
        \$data['total_records'] = \$this->count_record;
        
        \$this->parser->parse(\$this->router->class . '/index', \$data);
                    
    }
    
    public function _listView(\$action = 'index', \$cfn_id = 0)
    {
        // set javascript to view
        \$this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
        ));

        // set css to view
        \$this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css',
        ));      
        
        // filter created from date
    	\$filter_from_date = \$this->input->get('from_date');
    	if (\$filter_from_date) {
    		\$this->paginator['where']['DATE(created) >='] = standar_date(\$filter_from_date, '-', '-');
    	}
    
    	// filter created end date
    	\$filter_to_date = \$this->input->get('to_date');
    	if (\$filter_to_date) {
    		\$this->paginator['where']['DATE(created) <='] = standar_date(\$filter_to_date, '-', '-');
    	}
        
        \$filter_order = \$this->input->get('custom_order');
    	if (\$filter_order) {
            \$order = array(\$filter_order => 'desc');
    		\$this->paginator['order'] = \$order;
    	}
        
        if(\$action == \"export\")
        {
            \$this->paginator['select'] = '*';     
            \$this->paginator['limit'] = 999999999;
            return \$this->pagination(5);
        }
        \$list_views = \$this->pagination(5);

        //get extra params
        \$extra_params = get_extra_params_from_url();

        return array(
            'list_views' => \$list_views,
            'extra_params' => \$extra_params,
            'cfn_id' => \$cfn_id,
            'total_records' => \$this->count_record,
            'this_resource' => \$this->router->class,
            'cf_names' => \$this->getCustomFieldName(NULL, FALSE),
            'fields' => \$this->getCustomField(\$this->session->userdata('user_id'), \$cfn_id, NULL, FALSE),
            'link_edit' => array(
                'Edit' => '$module/$module_resource/edit/'                
            ),
            'pagination_link' => \$this->getPaginationLink('/$module/$module_resource/index/' . \$cfn_id, 5, \$extra_params)
        );
    }
    
    public function export()
    {
        \$contents = \$this->_listView(\"export\");
        
        if(empty(\$contents))
        {
            \$contents[0] = array('Data' => 'No record');
        } 
    
        \$this->load->library('Write_exel');
        \$this->write_exel->write(\$contents, SITE_NAME . '_'. '$module' .'_' . date('Y_m_d_H_i'));
        exit();
    }
                
    /**
     * View data
     *
     * @params int \$id
     */
    public function view(\$id)
    {
        // check permission
        \$this->PG_ACL('r');
        
        // set title
        \$this->layout->set_title(lang('View $model_class'));
                
        \$$module_resource = \$this->".$model_class."->get(array('id' => \$id));
                
        // set data to view
        \$data = array(
            'data_view' => $$module_resource
        );
        
        // parser
        \$this->parser->parse(\$this->router->class . '/view', \$data);
    }
                
    /**
     * Add data    
     */
    public function add()
    {   
        // check permission
        \$this->PG_ACL('w');
        
        // set title
        \$this->layout->set_title(lang('Add $model_class'));
                
        // load library form
        \$this->load->helper('form');
        \$this->load->library('form_validation');
        
        // form validate
        \$this->form_validation->set_rules('name', 'Name', 'required');
                
        // get post and check rule
        if (\$this->input->post() && \$this->form_validation->run() == TRUE)
        {
            // save data
            if (\$this->".$model_class."->create(\$this->input->post(), TRUE))
            {
                \$this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                \$this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect('$module/$module_resource');
        }
                
        \$data = array();
                
        // parser
        \$this->parser->parse(\$this->router->class . '/add', \$data);
    }
                
    /**
     * Edit data
     *
     * @params int \$id
     */
    public function edit(\$id = 0)
    {
        // check permission
        \$this->PG_ACL('e');
        
        // set title
        \$this->layout->set_title(lang('Edit $model_class'));
                
        // load library form
        \$this->load->helper('form');
        \$this->load->library('form_validation');
        
        // form validate
        \$this->form_validation->set_rules('name', 'Name', 'required');
        
        // get id
        \$id = (\$this->input->post('id')) ? \$this->input->post('id') : \$id;
                
        // get $module_resource
        \$$module_resource = \$this->".$model_class."->get(array('id' => \$id));
            
        if (!$$module_resource)
        {
            show_error(lang('Error params'));
        }
        
        // get post and check rule
        if (\$this->input->post() && \$this->form_validation->run() == TRUE)
        {
            // save data
            if (\$this->".$model_class."->update(\$this->input->post(), array('id' => \$id), TRUE))
            {
                \$this->session->set_flashdata('success_message', lang('Success'));
            } else 
            {
                \$this->session->set_flashdata('error_message', lang('Error'));
            }
            
            // redirect
            redirect_previous_url('$module/$module_resource');
        }
                
        // data to view
        \$data = array(
            'data_edit' => \$$module_resource
        );
                
        // parser
        \$this->parser->parse(\$this->router->class . '/edit', \$data);
    }
                
    /**
     * Delete
     */
    public function delete()
    {
        // check permission
        \$this->PG_ACL('d');
        
        \$this->deleteRecordOnListView();
    }
}
                
?>";
            if ($new_resource == 1) 
            {
                if ($is_c_admin)
                {
                    write_file(FPENGUIN . 'application/modules/'.$module.'/controllers/'.$module_resource.'.php', $resource_class_content);
                    @mkdir(FPENGUIN . "application/views/".theme_web()."/$module/$module_resource", 0775, true);
                    
                    $this->load->model('M_builder');
                    $this->M_builder->writeViewTPL(
                            $module_resource, 
                            $module_resource_main, 
                            "$module_resource/index", 
                            "$module/$module_resource/delete", 
                            FALSE, 
                            FALSE, 
                            'index'
                    );
                    $this->M_builder->writeViewTPL(
                            $module_resource, 
                            $module_resource_main, 
                            "$module_resource/view", 
                            "$module/$module_resource/delete", 
                            FALSE, 
                            FALSE, 
                            'view'
                    );
                    $this->M_builder->writeViewTPL(
                            $module_resource, 
                            $module_resource_main, 
                            "$module_resource/add", 
                            "$module/$module_resource/delete", 
                            FALSE, 
                            FALSE, 
                            'add'
                    );
                    $this->M_builder->writeViewTPL(
                            $module_resource, 
                            $module_resource_main, 
                            "$module_resource/edit", 
                            "$module/$module_resource/delete", 
                            FALSE, 
                            FALSE, 
                            'edit'
                    );
                    
                } else 
                    write_file(FPENGUIN . 'application/modules/'.$module.'/controllers/'.$module_resource.'.php', $controller_user_page);                    
            }
            
            // model class content
            $model_class_content = "<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN_LITE FrameWork
 * @author hoanhk
 * @copyright Huynh Kim Hoan 2013
 * 
 * Model
 * Function on $model_class
 * 
 * @package Penguin_liteFW
 * @subpackage $module
 * @version 2.0.0
 */

class $model_class extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        \$this->db_table = '$db_table';
    }
}

?>";
            if ($new_model == 1)
            {
                write_file(FPENGUIN . 'application/modules/'.$module.'/models/'.$model.'.php', $model_class_content);                                
            }
        }                
        
        $data = array();
        
        $this->load->view('module_builder.php', $data);
    }
}

?>
