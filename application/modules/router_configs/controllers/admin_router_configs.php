<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_router_configs
 * ...
 * 
 * @package PenguinFW
 * @subpackage Router_config
 * @version 1.0.0
 * 
 * @property Router_config      $Router_config
 */
 
class Admin_router_configs extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Router_config';
        
        // set layout
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('router_configs', lang_web());
            
        $this->load->model('Router_config');
    }
    
    /**
     * index
     * 
     * @param int $module_id
     */
    public function index($module_name = '', $resource_name = '')
    {
        // ser permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Router manager'));
        
        $module_name = ($this->input->post('module_name')) ? $this->input->post('module_name') : $module_name;
        $resource_name = ($this->input->post('resource_name')) ? $this->input->post('resource_name') : $resource_name;
        
        // process form data
        if ($this->input->post())
        {
            $p_routers = $this->input->post('router');
            
            if (!empty ($p_routers))
            {
                foreach ($p_routers as $p_router_id => $p_router)
                {
                    if ($p_router)
                    {
                        $this->Router_config->update(array('router' => $p_router), array('id' => $p_router_id));
                    }
                }
                
                if ($resource_name)
                {
                    redirect("router_configs/admin_router_configs/index/$module_name/$resource_name");
                }
                
                if ($module_name)
                {
                    redirect("router_configs/admin_router_configs/index/$module_name");
                }
                
                redirect("router_configs/admin_router_configs/index");
            }
        }        
        
        if ($module_name)
        { // process resource
            if ($resource_name)
            {
                // get router of resource
                $routers = $this->Router_config->get(array('module' => $module_name, 'resource' => $resource_name, 'action <>' => ''), 'action asc', FALSE, 0);
                
                $url_publish = base_url('router_configs/admin_router_configs/write/' . $module_name . '/' . $resource_name);
            } else 
            {
                // get router of module
                $routers = $this->Router_config->get(array('module' => $module_name, 'resource <>' => '', 'action' => ''), 'resource asc', FALSE, 0);
                
                if (!$routers)
                {
                    $this->_createRouterDefault($module_name);
                    
                    // get router of module
                    $routers = $this->Router_config->get(array('module' => $module_name, 'resource <>' => '', 'action' => ''), NULL, FALSE, 0);
                }
                
                $url_publish = base_url('router_configs/admin_router_configs/write/' . $module_name);
            }
        } else 
        { // process module
            // get module from router
            $routers = $this->Router_config->get(array('resource' => ''), 'module asc', FALSE, 0);

            if (!$routers)
            {
                // create router default
                $this->_createRouterDefault();
                
                // get module from router
                $routers = $this->Router_config->get(array('resource' => ''), NULL, FALSE, 0);
            }
            
            $url_publish = base_url('router_configs/admin_router_configs/write');
        }
        
        // data template
        $data = array(            
            'routers' => $routers,
            'module_name' => $module_name,
            'resource_name' => $resource_name,
            'url_publish' => $url_publish
        );
        
        // set template
        $this->parser->parse($this->router->class . '/index', $data);
    }
    
    /**
     * write router
     * 
     * @param string $module
     * @param string $resource
     */
    public function write($module_name = '', $resource_name = '')
    {
        // ser permission
        $this->PG_ACL('p');
        
        // lib
        $this->load->helper('file');
         
        if ($module_name)
        {
            $folder_config = FPENGUIN . APPPATH . "modules/$module_name/config/";
            if (!is_dir($folder_config))
            {
                mkdir($folder_config, 0775);
            }                        
            
            if ($resource_name)
            {
                // get router
                $routers = $this->Router_config->get(array('module' => $module_name, 'resource' => $resource_name, 'action <>' => ''), NULL, FALSE, 0);
                
                // file content
                $file_content = "<?php \n";
                
                foreach ($routers as $router)
                {
                    $file_content .= "\$route['" . $router['module'] . "/" . $router['router'] . "'] = '" . $router['resource'] . "/" . $router['action'] . "';\n";
                }
                
                write_file($folder_config . 'actions.php', $file_content);
                $this->_writeFileInclude();
                
                // redirect link
                $r_link = "router_configs/admin_router_configs/index/$module_name/$resource_name";
                
            } else 
            {
                // get router
                $routers = $this->Router_config->get(array('module' => $module_name, 'resource <>' => '', 'action' => ''), NULL, FALSE, 0);
                
                // file content
                $file_content = "<?php \n";                

                foreach ($routers as $router)
                {
                    $file_content .= "\$route['" . $router['module'] . "/" . $router['router'] . "'] = '" . $router['resource'] . "';\n";
                }
                
                $file_content .= "\n@include_once 'actions.php';";
                
                write_file($folder_config . 'routes.php', $file_content);
                $this->_writeFileInclude();
                
                // redirect link
                $r_link = "router_configs/admin_router_configs/index/$module_name";
            }                        
            
        } else         
        {
            // get module from router
            $routers = $this->Router_config->get(array('resource' => ''), NULL, FALSE, 0);
            
            // file content
            $file_content       = "<?php \n";
            $file_content       .= "\$route['default_controller'] = 'frontend';\n\$route['404_override'] = '';\n";
            $file_content       .= "\$route['root'] = 'users/admin_users/login';\n";
            
            if (config_item('router_configs_admin_url') == 1)
            {
                $file_content   .= "\$route['root/([a-zA-Z]+)/(:any)'] = \"\$1/admin_\$2\";\n";
            }
            
            foreach ($routers as $router)
            {
                $file_content   .= "\$route['" . $router['router'] . "'] = '" . $router['module'] . "';\n";
            }
            
            write_file(FPENGUIN . APPPATH . 'config/routes.php', $file_content);
            $this->_writeFileInclude();
            
            // redirect link
            $r_link = "router_configs/admin_router_configs/index";
            
        }
        
        redirect($r_link);
    }
    
    /**
     * Add
     * 
     * @param string $module_name
     * @param string $resource_name 
     */
    public function add($module_name = '', $resource_name = '')
    {
        // ser permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Add router'));
        
        // params
        $module_name = ($this->input->post('module_name')) ? $this->input->post('module_name') : $module_name;
        $resource_name = ($this->input->post('resource_name')) ? $this->input->post('resource_name') : $resource_name;                
        
        if ($this->input->post())
        {
            $this->Router_config->create($this->input->post(), TRUE);
            
            redirect("router_configs/admin_router_configs/index/$module_name/$resource_name");
        }
        
        $data = array(
            'module_name' => $module_name,
            'resource_name' => $resource_name,
        );
        
        $this->parser->parse($this->router->class . '/add', $data);
    }
    
    /**
     * Edit router action
     * 
     * @param int $id 
     */
    public function edit($id = 0)
    {
        // ser permission
        $this->PG_ACL('e');
        
        // set title
        $this->layout->set_title(lang('Edit router'));
        
        // get id
        $id = ($this->input->post('id')) ? $this->input->post('id') : $id;
        
        // get router
        $router = $this->Router_config->get(array('id' => $id));
        
        if (!$router)
        {
            show_error(lang('Error params'));
        }
        
        // process edit data
        if ($this->input->post())
        {
            $this->Router_config->update($this->input->post(), array('id' => $id), TRUE);
            
            redirect('router_configs/admin_router_configs/index/' . $router->module . '/' . $router->resource);
        }
        
        $data = array(
            'router' => $router
        );
        
        $this->parser->parse($this->router->class . '/edit', $data);
    }
    
    /**
     * write cache incluce file
     */
    private function _writeFileInclude()
    {
        // get router
        $routers = $this->Router_config->get(array(), NULL, FALSE, 0);
        
        // file content
        $file_content = "<?php \n\$PG_Router = array(); \n";
        
        foreach ($routers as $router)
        {
            if ($router['module'] && $router['resource'] && $router['action'])
            {
                // check action
                $tmp_action = $router['action'];

                if (strpos($tmp_action, '/') !== FALSE)
                {
                    $r_action = substr($tmp_action, 0, strpos($tmp_action, '/'));
                } else 
                {
                    $r_action = $tmp_action;
                }
                
                // check router
                $tmp_router = $router['router'];

                if (strpos($tmp_router, '/') !== FALSE)
                {
                    $r_router = substr($tmp_router, 0, strpos($tmp_router, '/'));
                } else 
                {
                    $r_router = $tmp_router;
                }
                
                // get write file
                $file_content .= "\$PG_Router['".$router['module']."']['action']['".$r_action."'] = '".$r_router."'; \n";
            }
            
            if ($router['module'] && $router['resource'] && !$router['action'])
            {
                $file_content .= "\$PG_Router['".$router['module']."']['resource']['".$router['resource']."'] = '".$router['router']."'; \n";
            }
            
            if ($router['module'] && !$router['resource'] && !$router['action'])
            {
                $file_content .= "\$PG_Router['".$router['module']."']['module'] = '".$router['router']."'; \n";
            }
        }
        
        // lib
        $this->load->helper('file');
        write_file(FPENGUIN . 'media/global_cache/include/routers.php', $file_content);
    }

    /**
     * create resource router default
     * 
     * @param type $module_name 
     */
    private function _createRouterDefault($module_name = '')
    {
        if ($module_name)
        {            
            // get resource from module
            $resources = $this->Router_config->find('all', array(
                'select' => 'r.name as resource_name, m.name as module_name',
                'from' => 'module_resources as r',
                'join' => array(                    
                    'modules m' => 'm.id = r.module_id'
                ),
                'where' => array(
                    'm.name' => $module_name                        
                )
            ));
        
            // save router resource module
            foreach ($resources as $resource)
            {
                $router_save = array(
                    'module' => $resource['module_name'],
                    'resource' => $resource['resource_name'],
                    'action' => '',
                    'router' => $resource['resource_name']
                );
                if (!$this->Router_config->is_duplicate('router', $resource['resource_name']))
                {
                $this->Router_config->create($router_save);
            }
            }
        } else 
        {
            // get module
            $modules = $this->Router_config->find('all', array(
                'from' => 'modules',
                'limit' => 0
            ));

            // add router
            foreach ($modules as $module)
            {
                $router_save = array(
                    'module' => $module['name'],
                    'resource' => '',
                    'action' => '',
                    'router' => $module['name']
                );

                $this->Router_config->create($router_save);
            }
        }
    }
}
                
?>