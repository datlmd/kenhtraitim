<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_html_templates
 * ...
 * 
 * @package PenguinFW
 * @subpackage Html_template
 * @version 1.0.0
 * 
 * @property Html_template      $Html_template
 */
class Admin_html_templates extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->model_name = 'Html_template';

        // set layout
        $this->layout->set_layout('admin');

        $this->lang->load('generate', lang_web());
        $this->lang->load('html_templates', lang_web());

        $this->load->model('Html_template');
    }

    /**
     * LIST ACTION
     * 
     * @param int $resource_id
     */
    public function index($resource_id = 0)
    {
   
        // check permission
        $this->PG_ACL('r');

        // set layout
        // set title
        $this->layout->set_title(lang('Html template manager'));

        if($resource_id === 0)
        { // if statis file
            $css = ConstFileStaticEdit::$css;
            $js = ConstFileStaticEdit::$js;
            $files = FALSE;
        }
        else if(is_numeric($resource_id))
        { // if tpl file
            $css = FALSE;
            $js = FALSE;

            // get folder tpl
            $folder_template = FPENGUIN . APPPATH . 'views/' . theme_web() . '/' . $this->getModuleName($resource_id) . '/';

            // get file in folder
            $file_temps = scandir($folder_template);

            // get file
            $files = array();
            foreach($file_temps as $file_temp)
            {
                if(is_file($folder_template . $file_temp) && strpos($file_temp, '.' . ConstEXTHtmlTemplate::tpl) !== FALSE)
                {
                    $files[] = str_replace('.' . ConstEXTHtmlTemplate::tpl, '', $file_temp);
                }
            }
        }
        else if($resource_id === 'themes')
        {
            //config
            $folder_themes = 'layouts';
            
            $css = FALSE;
            $js = FALSE;

            // get folder tpl
            $folder_template = FPENGUIN . APPPATH . 'views/' . theme_web() . '/' . $folder_themes . '/';

            // get file in folder
            $file_temps = scandir($folder_template);

            // get file
            $files = array();
            foreach($file_temps as $file_temp)
            {
                if(is_file($folder_template . $file_temp) && strpos($file_temp, '.' . ConstEXTHtmlTemplate::tpl) !== FALSE)
                {
                    $files[] = str_replace('.' . ConstEXTHtmlTemplate::tpl, '', $file_temp);
                }
            }
        }
        else
        {
            show_error(lang('Error params'));
        }

        // set data
        $data = array(
            'css' => $css,
            'js' => $js,
            'tpls' => $files,
            'resource_id' => $resource_id,
            'resource_name' => $this->getResourceName($resource_id)
        );

        // set template
        $this->parser->parse($this->router->class . '/index', $data);
    }

    /**
     * VIEW TEMPLATE
     * 
     * @param int $id 
     */
    public function view($id = 0)
    {
        // check permission
        $this->PG_ACL('r');

        // title
        $this->layout->set_title(lang('View template'));

        // set css
        $this->layout->set_rel(array(
            'js__1' => 'CodeMirror/lib/codemirror.css',
            'js__2' => 'CodeMirror/theme/default.css'
        ));

        // check id
        if($id == 0 || !is_numeric($id))
        {
            show_error(lang('Error params'));
        }

        // get template
        $template = $this->Html_template->get(array('id' => $id));

        // check valid template
        if(!$template)
        {
            show_error(lang('Error params'));
        }

        // get type
        $type = $template->ext;

        // set javascript
        if($type == ConstEXTHtmlTemplate::css)
        {
            $this->layout->set_javascript(array(
                'CodeMirror/lib/codemirror.js',
                'CodeMirror/mode/css/css.js'
            ));
        }
        else if($type == ConstEXTHtmlTemplate::js)
        {
            $this->layout->set_javascript(array(
                'CodeMirror/lib/codemirror.js',
                'CodeMirror/mode/javascript/javascript.js'
            ));
        }
        else
        {
            $this->layout->set_javascript(array(
                'CodeMirror/lib/codemirror.js',
                'CodeMirror/mode/xml/xml.js'
            ));
        }

        // get old version
        $old_templates = $this->Html_template->getOldTemplate($template->name, $template->resource_id, $template->ext);

        // set data
        $data = array(
            'template' => $template,
            'old_templates' => $old_templates,
            'template_id' => $id
        );

        // set template
        $this->parser->parse($this->router->class . '/view', $data);
    }

    /**
     * EDIT FILE
     * 
     * @param int $resource_id
     * @param string $file_name
     * @param string $type css,js,tpl    
     */
    public function edit($resource_id = 0, $file_name = '', $type = 'tpl')
    {
        // check permission
        $this->PG_ACL('e');

        if($resource_id === 'themes')
        {
            echo $this->edit_layout($file_name .'.'. $type);
            return;
        }
        // set layout
        // set title
        $this->layout->set_title(lang('Edit html template'));

        // set css
        $this->layout->set_rel(array(
            'js__1' => 'CodeMirror/lib/codemirror.css',
            'js__2' => 'CodeMirror/theme/default.css'
        ));

        // set javascript
        if($type == ConstEXTHtmlTemplate::css)
        {
            $this->layout->set_javascript(array(
                'CodeMirror/lib/codemirror.js',
                'CodeMirror/mode/css/css.js'
            ));
        }
        else if($type == ConstEXTHtmlTemplate::js)
        {
            $this->layout->set_javascript(array(
                'CodeMirror/lib/codemirror.js',
                'CodeMirror/mode/javascript/javascript.js'
            ));
        }
        else
        {
            $this->layout->set_javascript(array(
                'CodeMirror/lib/codemirror.js',
                'CodeMirror/mode/xml/xml.js'
            ));
        }

        // get data from form
        $resource_id = ($this->input->post('resource_id')) ? $this->input->post('resource_id') : $resource_id;
        $file_name = ($this->input->post('name')) ? $this->input->post('name') : $file_name;
        $type = ($this->input->post('ext')) ? $this->input->post('ext') : $type;

        // load file
        if($type == ConstEXTHtmlTemplate::css)
        { // tyle == css
            $ext = ConstEXTHtmlTemplate::css;
        }
        else if($type == ConstEXTHtmlTemplate::js)
        { // tyle == js
            $ext = ConstEXTHtmlTemplate::js;
        }
        else if($type == ConstEXTHtmlTemplate::tpl)
        { // type == tpl
            $ext = ConstEXTHtmlTemplate::tpl;
        }
        else
        { // not type
            show_error(lang('Error params'));
        }

        // process post form
        if($this->input->post())
        {
            // get data form
            $data_create = $this->input->post();

            // set default
            $data_create['is_default'] = 1;

            // remove default
            $this->Html_template->removeDefault($file_name, $resource_id, $ext);

            // create new template
            $this->Html_template->create($data_create, TRUE);

            // redirect
            redirect('html_templates/admin_html_templates/edit/' . $resource_id . '/' . $file_name . '/' . $type);
        }

        // get old version
        $old_templates = $this->Html_template->getOldTemplate($file_name, $resource_id, $ext);

        // get content edit
        $content_edit = $this->_getTempalteContent($file_name, $resource_id, $ext);

        // check content exit
        if($content_edit == '')
        {
            show_error(lang('Error file name'));
        }

        // set data
        $data = array(
            'ext' => $ext,
            'file_name' => $file_name,
            'resource_id' => $resource_id,
            'content_edit' => htmlspecialchars($content_edit),
            'old_templates' => $old_templates
        );

        // set template
        $this->parser->parse($this->router->class . '/edit', $data);
    }

    /**
     * Push lish template on site
     * 
     * @param int $resource_id
     * @param string $file_name
     * @param string $type 
     */
    public function publish($resource_id = 0, $file_name = '', $type = 'tpl')
    {
        // check permission
        $this->PG_ACL('p');

        // load helper
        $this->load->helper('file');

        // get ext
        $ext = $type;

        // get path file
        $file_load = $this->_getPathFile($file_name, $resource_id, $ext);

        // check valid
        if(!$file_load)
        {
            show_error(lang('Error file name'));
        }

        // get template from db
        $template = $this->Html_template->get(array(
            'name' => $file_name,
            'ext' => $ext,
            'is_default' => 1,
            'resource_id' => $resource_id
                ));

        // check valid
        if($template)
        {
            write_file($file_load, $template->content);
            $this->session->set_flashdata('success_message', lang('Publish success'));
        }
        else
        {
            $this->session->set_flashdata('error_message', lang('Publish error'));
        }

        // redirect
        redirect('html_templates/admin_html_templates/edit/' . $resource_id . '/' . $file_name . '/' . $type);
    }

    /**
     * publish old template
     * 
     * @param int $id 
     */
    public function publish_id($id)
    {
        // check permission
        $this->PG_ACL('p');

        // check id
        if($id == 0 || !is_numeric($id))
        {
            show_error(lang('Error params'));
        }

        // get template
        $template = $this->Html_template->get(array('id' => $id));

        // check valid template
        if(!$template)
        {
            show_error(lang('Error params'));
        }

        // load helper
        $this->load->helper('file');

        // get path file template
        $file_load = $this->_getPathFile($template->name, $template->resource_id, $template->ext);

        // check file
        if(!$file_load)
        {
            show_error(lang('Error params'));
        }

        // remove default
        $this->Html_template->removeDefault($template->name, $template->resource_id, $template->ext);

        // update default template
        $this->Html_template->update(array('is_default' => 1), array('id' => $id));

        // write file to view
        write_file($file_load, $template->content);
        $this->session->set_flashdata('success_message', lang('Publish success'));

        // redirect
        redirect('html_templates/admin_html_templates/edit/' . $template->resource_id . '/' . $template->name . '/' . $template->ext);
    }

    /**
     * List all history file 
     * 
     * @param int $resource_id
     * @param string $file_name
     * @param string $type
     */
    public function history($resource_id = 0, $file_name = '', $type = 'tpl')
    {
        // set permission
        $this->PG_ACL('r');

        // set layout global 
        // set title 
        $this->layout->set_title(lang('Template manager'));
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

        // get template 
        // set conditions
        $this->paginator['where'] = array(
            'resource_id' => $resource_id,
            'name' => $file_name,
            'ext' => $type
        );

        // check filter 
        // filter from date 
        $filter_from_date = $this->input->get('from_date');
        if($filter_from_date)
        {
            $this->paginator['where']['DATE(created) >='] = standar_date($filter_from_date, '-', '-');
        }

        // filter to date 
        $filter_to_date = $this->input->get('to_date');
        if($filter_to_date)
        {
            $this->paginator['where']['DATE(created) <='] = standar_date($filter_to_date, '-', '-');
        }

        // get template
        $templates = $this->pagination(7);

        // check valid 
        if(!$filter_from_date && $filter_to_date && !$templates)
        {
            show_error(lang('Error params'));
        }

        // set data 
        $data = array(
            'list_views' => $templates,
            'resource_name' => $this->getResourceName($resource_id),
            'file_name' => $file_name,
            'this_resource' => $this->router->class,
            'link_edit' => array(
                'View' => '/html_templates/admin_html_templates/view/'
            ),
            'pagination_link' => $this->getPaginationLink('/html_templates/admin_html_templates/history/' . $resource_id . '/' . $file_name . '/' . $type, 7)
        );

        // set template
        $this->parser->parse($this->router->class . '/history', $data);
    }

    /**
     * get content template
     * 
     * @param string $name
     * @param int $resource_id
     * @param string $ext
     * @return string 
     */
    private function _getTempalteContent($name, $resource_id, $ext)
    {
        // load helper
        $this->load->helper('file');

        // get template from db
        $template = $this->Html_template->get(array(
            'name' => $name,
            'ext' => $ext,
            'is_default' => 1,
            'resource_id' => $resource_id
                ));

        // if not exit
        // load content from file
        if(!$template)
        {
            // get path file template
            $file_load = $this->_getPathFile($name, $resource_id, $ext);

            // get content file
            if($file_load)
            {
                // read file 
                $content_edit = read_file($file_load);

                // insert template to db
                $this->Html_template->create(array(
                    'name' => $name,
                    'content' => $content_edit,
                    'ext' => $ext,
                    'is_default' => 1,
                    'resource_id' => $resource_id
                ));

                return $content_edit;
            }
            else //// get content file
            {
                return '';
            }
        }
        else
        { // if exit template -> return content
            return $template->content;
        }
    }

    /**
     * get path file template
     * 
     * @param string $file_name
     * @param int $resource_id
     * @param string $type
     * @return boolean|string 
     */
    private function _getPathFile($file_name, $resource_id, $type)
    {
        $file_name = str_replace('__', '/', $file_name);

        // get link static
        $static_link = FPENGUIN . 'static/' . theme_web() . '/';

        // load file
        if($type == ConstEXTHtmlTemplate::css)
        { // tyle == css
            $ext = ConstEXTHtmlTemplate::css;
            $file_load = $static_link . $file_name . '.' . $ext;
        }
        else if($type == ConstEXTHtmlTemplate::js)
        { // tyle == js
            $ext = ConstEXTHtmlTemplate::js;
            $file_load = $static_link . $file_name . '.' . $ext;
        }
        else if($type == ConstEXTHtmlTemplate::tpl)
        { // type == tpl
            $ext = ConstEXTHtmlTemplate::tpl;
            $file_load = FPENGUIN . APPPATH . 'views/' . theme_web() . '/' . $this->getModuleName($resource_id) . '/' . $file_name . '.' . $ext;
        }
        else
        { // not type
            return FALSE;
        }

        // not file
        if(!is_file($file_load))
        {
            return FALSE;
        }

        // return file path
        return $file_load;
    }

    /**
     * Edit layout
     * 
     * @param string $layout_name
     */
    public function edit_layout($layout_name = '')
    {
        // set permission
        $this->PG_ACL('w');

        // title
        $this->layout->set_title(lang('View template'));

        // set css
        $this->layout->set_rel(array(
            'js__1' => 'CodeMirror/lib/codemirror.css',
            'js__2' => 'CodeMirror/theme/default.css'
        ));

        $this->layout->set_javascript(array(
            'CodeMirror/lib/codemirror.js',
            'CodeMirror/mode/xml/xml.js',
            'CodeMirror/mode/javascript/javascript.js',
            'CodeMirror/mode/css/css.js',
            'CodeMirror/mode/clike/clike.js',
            'CodeMirror/mode/php/php.js'
        ));

        // load helper
        $this->load->helper('file');

        $folder_template = FPENGUIN . APPPATH . 'views/' . theme_web() . '/layouts/';

        if($this->input->post())
        {
            if($this->input->post('layout'))
            {
                $layout_path = $folder_template . $this->input->post('layout');
                write_file($layout_path, $this->input->post('content'));
                $this->session->set_flashdata('success_message', lang('Success'));
                redirect('html_templates/admin_html_templates/edit_layout');
            }
        }

        if($layout_name == '')
        {
            // get file in folder
            $file_temps = scandir($folder_template);

            // get file
            $files = array();
            foreach($file_temps as $file_temp)
            {
                if(is_file($folder_template . $file_temp))
                {
                    $files[] = $file_temp;
                }
            }

            $data['files'] = $files;
        }
        else
        {
            $layout_file = $folder_template . $layout_name;
   
            if(is_file($layout_file))
            {
                $content = read_file($layout_file);
            }
            else
            {
                $content = '';
            }
            $data['content'] = htmlspecialchars($content);
        }

        $data['layout'] = $layout_name;

        // template
        $this->parser->parse($this->router->class . '/edit', $data);
    }

}

?>