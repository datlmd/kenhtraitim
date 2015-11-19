<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Admin Controller
 * Quản lý menu
 * 
 * @package PenguinFW
 * @subpackage MENU
 * @version 1.0.0
 * 
 * @property Menu $Menu
 */
class Admin_menus extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->model_name = 'Menu';
        
        $this->layout->set_layout('admin');

        $this->lang->load('generate', lang_web());
        $this->lang->load('menus', lang_web());

        $this->load->model('Menu');
    }

    /**
     * Index list menu
     * 
     * @param int $cfn_id custom field name id
     */
    public function index($cfn_id = 0)
    {
        // check permission
        $this->PG_ACL('r');                

        // set title
        $this->layout->set_title(lang('Menu manager'));                

        // get menu
        $menus = $this->Menu->getTreeItems(array(), 'weight asc');     

        $data = array(
            'list_views' => $menus,                        
            'cfn_id' => $cfn_id,
            
            'this_resource' => $this->router->class,
            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
            'link_edit' => 'menus/admin_menus/edit/',
            'field_show' => 'name'
        );
        
        $this->parser->parse($this->router->class . '/index', $data);
    }

    /**
     * Add module
     */
    public function add()
    {
        // set permission
        $this->PG_ACL('w');

        $data = array();

        // get parent menu        
        $parents_menus = $this->Menu->get(array('parent_id' => 0), NULL, FALSE, 0);

        $this->load->helper('form');
        $this->load->library('form_validation');

        // check form
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('link', 'Link', 'required');

        // process post form
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $data_menus = array(
                'name' => $this->input->post('name'),
                'link' => $this->input->post('link'),
                'parent_id' => $this->input->post('parent_id'),
                'weight' => $this->input->post('weight')
            );

            $this->Menu->create($data_menus);
            
            $this->session->set_flashdata('success_message', lang('Add success'));
            redirect('menus/admin_menus');
        }
        
        // set data to view
        $data = array(
            'parent_menus' => $parents_menus
        );

        $this->parser->parse('admin_menus/add', $data);
    }
    
    /**
     * Edit menu
     * 
     * @param int $id 
     */
    public function edit($id = 0)
    {
        // check permission
        $this->PG_ACL('e');
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
        
        $this->load->helper('form');
        $this->load->library('form_validation');

        // check form
        $this->form_validation->set_rules('name', lang('Name'), 'required');
        $this->form_validation->set_rules('link', lang('Link'), 'required');
        
        // get data from form end edit data
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            $data_update = array(
                'name' => $this->input->post('name'),
                'link' => $this->input->post('link'),
                'parent_id' => $this->input->post('parent_id'),
                'weight' => $this->input->post('weight')
            );
            
            $this->Menu->update($data_update, array('id' => $id));
            
            $this->session->set_flashdata('success_message', lang('Edit success'));
            redirect('menus/admin_menus');
        }
        
        // get parent menu        
        $parents_menus = $this->Menu->get(array('parent_id' => 0), NULL, FALSE, 0);
        
        // get current menu edit 
        $current_menu = $this->Menu->get(array('id' => $id));        
        
        // check current data in system
        if (empty ($current_menu))
        {
            $this->session->set_flashdata('error_message', lang('Error params'));
            redirect('menus/admin_menus');
        }
        
        // set data to view
        $data = array(
            'parent_menus' => $parents_menus,
            'current_menu' => $current_menu
        );
        
        $this->parser->parse('admin_menus/edit', $data);
    }
    
    /**
     * Delete record menu
     */
    public function delete()
    {
        // check permission
        $this->PG_ACL('d');
        
        $this->deleteRecordOnListView();
    }

    /**
     * Cache menu
     */
	public function cache_menu()
    {
        // check permission
        $this->PG_ACL('w');
        
        $menus = $this->Menu->get(array('parent_id' => 0), 'weight asc', FALSE, 0);

        if (!$menus)
        {
            show_error('No data');
        }

        $this->load->helper('file');

        $menu_string = '<?php ?>';
        $menu_string .= '<li><a href="users/admin_users/dashboard">' . lang('Home') . '</a></li>';

        foreach ($menus as $menu)
        {
            // get sub menu
            $sub_menus = $this->Menu->get(array('parent_id' => $menu['id']), 'weight asc', FALSE, 0);
            
            // if exit
            if ($sub_menus)
            {
            	// remove / (forward slash) at first character
            	$menu['link'] = (substr($menu['link'], 0, 1) == '/') ? substr($menu['link'], 1) : $menu['link'];
                $menu_string .= '<li><a href="' . $menu['link'] . '">' . $menu['name'] . '</a>';
                $menu_string .= '<ul>';
                
                foreach ($sub_menus as $sub_menu)
                {
                	// remove / (forward slash) at first character
                	$menu['link'] = (substr($menu['link'], 0, 1) == '/') ? substr($menu['link'], 1) : $menu['link'];
                    $menu_string .= '<li><a href="' . $sub_menu['link'] . '">' . $sub_menu['name'] . '</a></li>';
                }
                
                $menu_string .= '</ul></li>';
            } else 
            {
            	// remove / (forward slash) at first character
            	$menu['link'] = (substr($menu['link'], 0, 1) == '/') ? substr($menu['link'], 1) : $menu['link'];
                $menu_string .= '<li><a href="' . $menu['link'] . '">' . $menu['name'] . '</a></li>';
            }
        }

        write_file(FPENGUIN . 'media/global_cache/html/admin_menu.tpl', $menu_string);

        redirect('menus/admin_menus');
    }

}

?>
