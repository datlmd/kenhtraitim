<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_settings
 * ...
 * 
 * @package PenguinFW
 * @subpackage Setting
 * @version 1.0.0
 * 
 * @property Setting            $Setting
 */
 
class Admin_settings extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Setting';
        
        // set layout
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('settings', lang_web());
            
        $this->load->model('Setting');
    }
    
    /**
     * list
     * 
     * @param int $cfn_id 
     */
    public function index($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Setting manager'));                
        
        // get setting
        $this->paginator['limit'] = 20;
        $this->paginator['order'] = array('key' => 'asc');
        $settings = $this->pagination(5);
        
        // get $_GET
        $extra_params = get_extra_params_from_url();
        
        $data = array(
            'list_views' => $settings,
            
            'this_resource' => $this->router->class,            
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => 'settings/admin_settings/edit/',
            'pagination_link' => $this->getPaginationLink('/settings/admin_settings/index/' . $cfn_id, 5, $extra_params)
        );
        
        $this->parser->parse($this->router->class . '/index', $data);
    }
    
    /**
     * add setting
     */
    public function add()
    {
        // check permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Add setting'));
        
        // post
        if ($this->input->post())
        {
            $this->Setting->create($this->input->post(), TRUE);
            
            $this->session->set_flashdata('success_message', lang('Add setting success'));
            redirect_previous_url('settings/admin_settings');
        }
        
        $data = array(
            
        );
        
        $this->parser->parse($this->router->class . '/add', $data);
    }
    
    /**
     * edit setting
     * 
     * @param int $id 
     */
    public function edit($id = 0)
    {
        // check permission
        $this->PG_ACL('e');
        
        // set title
        $this->layout->set_title(lang('Edit setting'));
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
        
        // get setting
        $setting = $this->Setting->get(array('id' => $id));
        
        if (!$setting)
        {
            show_error(lang('Error params'));
        }
        
        // post
        if ($this->input->post())
        {
            $this->Setting->update($this->input->post(), array('id' => $id), TRUE);
            
            $this->session->set_flashdata('success_message', lang('Edit setting success'));
            // redirect
            redirect_previous_url('settings/admin_settings');
        }
        
        $data = array(
            'data_edit' => $setting
        );
        
        $this->parser->parse($this->router->class . '/edit', $data);
    }
    
    /**
     * Write data to config file
     */
    public function write()
    {
        // check permission
        $this->PG_ACL('p');
        
        // get setting
        $settings = $this->Setting->get(array(), NULL, FALSE, 0);
        
        if (!$settings)
        {
            $this->session->set_flashdata('error_message', lang('Not found setting on system'));
            redirect_previous_url('settings/admin_settings');
        }
        
        // lib 
        $this->load->helper('file');
        
        // get file content
        $file_content = "<?php \n\n/**\n* PENGUIN FrameWork\n* @author hungtd <tdhungit@gmail.com> 0972014011\n* @copyright Tran Dinh Hung 2011\n* \n* File config\n* \n* @package PenguinFW\n* @subpackage System\n* @version 1.0.0\n*/\n\n";
        
        foreach ($settings as $setting)
        {
            $file_content .= "// " . $setting['description'] . "\n";
            $file_content .= "\$config['" . $setting['key'] . "'] = <<<END\n" . html_entity_decode($setting['value']) . "\nEND;\n\n";
        }
        
        write_file(FPENGUIN . APPPATH . 'config/penguinfw.php', $file_content);
        
        $this->session->set_flashdata('success_message', lang('Write setting success'));
        redirect_previous_url('settings/admin_settings');
    }
    
    /**
     * delete setting
     */
    public function delete()
    {
        // check permission
        $this->PG_ACL('d');
        
        // delete
        $this->deleteRecordOnListView();
    }
}
                
?>