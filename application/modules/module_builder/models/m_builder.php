<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * Model
 * 
 * @author      hungtd <tdhungit@gmail.com> 0972014011
 * @copyright   Tran Dinh Hung 2011
 * @package     PenguinFW
 * @subpackage  ModuleBuilder
 * @version     1.0.0
 * 
 * @property Xml $xml
 */
class M_builder extends CI_Model {

    public function writeIndex($module_name, $resource_name, $is_search_form, $field_search, $form_link, $template_name)
    {
        $this->load->library('xml');
        $this->load->helper('file');

        if($this->xml->load('modules/module_builder/template/index'))
        {
            $xmlContentAll = $this->xml->parse();
            $xmlContent = $xmlContentAll['root'][0];

            // get head
            $head = $xmlContent['head'][0];
            $search = array('##DESCRIPTION##', '##MODULE##');
            $replace = array('LIST VIEW ', ucfirst($module_name));
            $head = str_replace($search, $replace, $head);

            // get divHeading
            $divHeading = $xmlContent['divHeading'][0];
            $search = array('##TITLE##', '##LINKADD##', '##MODULEINDEX##');
            $replace = array(get_label($resource_name) . ' manager', $module_name . '/' . $resource_name . '/add', $module_name . '/' . $resource_name);
            $divHeading = str_replace($search, $replace, $divHeading);

            $formSearch = '';

            if($is_search_form == 1)
            {
                // get field search
                $field_search_array = explode(';', $field_search);
                $field_search_string = '';
               

                foreach($field_search_array as $field)
                {
                    if(strpos($field, '|') !== false)
                    {
                        $field_array = explode('|', $field);
                        // get field select search
                        $fieldSelectSearch = $xmlContent['fieldSelectSearch'][0];
                        $search = array('##LABEL##', '##FIELDNAME##', '##VALUES##', '##VALUE##');
                        $replace = array(get_label($field_array[0]), $field_array[0], $field_array[1], $field_array[2]);
                        $field_search_string .= str_replace($search, $replace, $fieldSelectSearch);
                    }
                    else
                    {
                        // get field text search
                        $fieldTextSearch = $xmlContent['fieldTextSearch'][0];
                        $search = array('##LABEL##', '##FIELDNAME##');
                        $replace = array(get_label($field), $field);
                        $field_search_string .= str_replace($search, $replace, $fieldTextSearch);
                    }
                }

                // get form search
                $formSearch = $xmlContent['formSearch'][0];
                $search = array('##FORMSEARCHID##', '##FIELDSEARCH##');
                $replace = array(ucfirst($module_name) . 'Search', $field_search_string);
                $formSearch = str_replace($search, $replace, $formSearch);
            }

            // get listView
            $listView = $xmlContent['listView'][0];
            $search = array('##LINKEXPORT##', '##ACTIONFORM##');
            $replace = array($module_name . '/' . $resource_name. '/export', $form_link);
            $listView = str_replace($search, $replace, $listView);

            // get divContent
            $divContent = $xmlContent['divContent'][0];
            $search = array('##CONTENT##');
            $replace = array($formSearch . $listView);
            $divContent = str_replace($search, $replace, $divContent);

            $file_content = $head . $divHeading . $divContent;

            write_file(FPENGUIN . 'application/views/' . theme_web() . '/' . $module_name . '/' . $template_name . '.tpl', $file_content);
        }
    }

    public function writeAdd($module_name, $resource_name, $module_fields, $template_name)
    {
        $this->load->library('xml');
        $this->load->helper('file');

        if($this->xml->load('modules/module_builder/template/add'))
        {
            $xmlContentAll = $this->xml->parse();
            $xmlContent = $xmlContentAll['root'][0];

            // get head
            $head = $xmlContent['head'][0];
            $search = array('##DESCRIPTION##', '##MODULE##');
            $replace = array('ADD ' . ucfirst($module_name), $module_name);
            $head = str_replace($search, $replace, $head);

            // get div heading
            $divHeading = $xmlContent['divHeading'][0];
            $search = array('##TITLE##', '##FORMID##');
            $replace = array('Add' . ' ' . get_label($resource_name), 'FormAdd' . ucfirst($module_name));
            $divHeading = str_replace($search, $replace, $divHeading);

            // get field add                    
            $field_add_string = '';
            foreach($module_fields as $module_field)
            {
                $field = $module_field['name'];

                if($field != 'id' && $field != 'created' && $field != 'modified' && $field != 'user_id')
                {
                    if(strpos($field, '_id') !== false)
                    {
                        // get field select
                        $fieldSelect = $xmlContent['fieldSelect'][0];
                        $search = array('##FIELDNAME##', '##VALUES##', '##VALUE##');
                        $replace = array($field, $field . 's', $field);
                        $field_add_string .= str_replace($search, $replace, $fieldSelect);
                    }
                    else if(strpos($field, 'is_') !== false)
                    {
                        // get field text
                        $fieldText = $xmlContent['fieldText'][0];
                        $search = array('##FIELDNAME##', '##FIELD_TYPE##');
                        $replace = array($field, 'checkbox');
                        $field_add_string .= str_replace($search, $replace, $fieldText);
                    }
                    else if($module_field['field_type'] == 'AREA')
                    {
                        // get field area
                        $fieldArea = $xmlContent['fieldArea'][0];
                        $search = array('##FIELDNAME##');
                        $replace = array($field);
                        $field_add_string .= str_replace($search, $replace, $fieldArea);
                    }
                    else
                    {
                        // get field text
                        $fieldText = $xmlContent['fieldText'][0];
                        $search = array('##FIELDNAME##', '##FIELD_TYPE##');
                        $replace = array($field, 'text');
                        $field_add_string .= str_replace($search, $replace, $fieldText);
                    }
                }
            }

            // get form
            $Form = $xmlContent['Form'][0];
            $search = array('##FORMID##', '##FIELDADD##');
            $replace = array('FormAdd' . ucfirst($module_name), $field_add_string);
            $Form = str_replace($search, $replace, $Form);

            // get divContent
            $divContent = $xmlContent['divContent'][0];
            $search = array('##CONTENT##');
            $replace = array($Form);
            $divContent = str_replace($search, $replace, $divContent);

            $file_content = $head . $divHeading . $divContent;

            write_file(FPENGUIN . 'application/views/' . theme_web() . '/' . $module_name . '/' . $template_name . '.tpl', $file_content);
        }
    }

    public function writeEdit($module_name, $resource_name, $module_fields, $template_name)
    {
        $this->load->library('xml');
        $this->load->helper('file');

        if($this->xml->load('modules/module_builder/template/edit'))
        {
            $xmlContentAll = $this->xml->parse();
            $xmlContent = $xmlContentAll['root'][0];

            // get head
            $head = $xmlContent['head'][0];
            $search = array('##DESCRIPTION##', '##MODULE##');
            $replace = array('Edit ' . ucfirst($module_name), $module_name);
            $head = str_replace($search, $replace, $head);

            // get div heading
            $divHeading = $xmlContent['divHeading'][0];
            $search = array('##TITLE##', '##FORMID##');
            $replace = array('Edit' . ' ' . get_label($resource_name), 'FormEdit' . ucfirst($module_name));
            $divHeading = str_replace($search, $replace, $divHeading);

            // get field add                    
            $field_add_string = '';
            foreach($module_fields as $module_field)
            {
                $field = $module_field['name'];

                if($field != 'id' && $field != 'created' && $field != 'modified' && $field != 'user_id')
                {
                    if(strpos($field, '_id') !== false)
                    {
                        // get field select 
                        $fieldSelect = $xmlContent['fieldSelect'][0];
                        $search = array('##FIELDNAME##', '##VALUES##', '##VALUE##', '##MODULE##');
                        $replace = array($field, $field . 's', $field, 'data_edit');
                        $field_add_string .= str_replace($search, $replace, $fieldSelect);
                    }
                    else if(strpos($field, 'is_') !== false)
                    {
                        // get field text 
                        $fieldText = $xmlContent['fieldText'][0];
                        $search = array('##FIELDNAME##', '##FIELD_TYPE##', '##MODULE##');
                        $replace = array($field, 'checkbox', 'data_edit');
                        $field_add_string .= str_replace($search, $replace, $fieldText);
                    }
                    else if($module_field['field_type'] == 'AREA')
                    {
                        // get field area
                        $fieldArea = $xmlContent['fieldArea'][0];
                        $search = array('##FIELDNAME##');
                        $replace = array($field);
                        $field_add_string .= str_replace($search, $replace, $fieldArea);
                    }
                    else
                    {
                        // get field text 
                        $fieldText = $xmlContent['fieldText'][0];
                        $search = array('##FIELDNAME##', '##FIELD_TYPE##', '##MODULE##');
                        $replace = array($field, 'text', 'data_edit');
                        $field_add_string .= str_replace($search, $replace, $fieldText);
                    }
                }
            }

            // get form
            $Form = $xmlContent['Form'][0];
            $search = array('##FORMID##', '##FIELDADD##');
            $replace = array('FormEdit' . ucfirst($module_name), $field_add_string);
            $Form = str_replace($search, $replace, $Form);

            // get divContent
            $divContent = $xmlContent['divContent'][0];
            $search = array('##CONTENT##');
            $replace = array($Form);
            $divContent = str_replace($search, $replace, $divContent);

            $file_content = $head . $divHeading . $divContent;

            write_file(FPENGUIN . 'application/views/' . theme_web() . '/' . $module_name . '/' . $template_name . '.tpl', $file_content);
        }
    }

    public function writeView($module_name, $resource_name, $module_fields, $template_name)
    {
        if($this->xml->load('modules/module_builder/template/view'))
        {
            $xmlContentAll = $this->xml->parse();
            $xmlContent = $xmlContentAll['root'][0];

            // get head
            $head = $xmlContent['head'][0];
            $search = array('##DESCRIPTION##', '##MODULE##');
            $replace = array('View ' . ucfirst($module_name), $module_name);
            $head = str_replace($search, $replace, $head);

            // get div heading
            $divHeading = $xmlContent['divHeading'][0];
            $search = array('##TITLE##', '##EDITMODULE##');
            $replace = array('View' . ' ' . get_label($resource_name), 'data_view');
            $divHeading = str_replace($search, $replace, $divHeading);

            // get data field
            $field_view_string = '';
            $trField = $xmlContent['trField'][0];
            foreach($module_fields as $module_field)
            {
                if($module_field['name'] != 'id' && $module_field['name'] != 'user_id')
                {
                    $search = array('##FIELD##', '##EDITMODULE##', '##FIELDTYPE##');
                    $replace = array($module_field['name'], 'data_view', $module_field['field_type']);
                    $field_view_string .= str_replace($search, $replace, $trField);
                }
            }

            // get divContent
            $divContent = $xmlContent['divContent'][0];
            $search = array('##CONTENT##');
            $replace = array($field_view_string);
            $divContent = str_replace($search, $replace, $divContent);

            $file_content = $head . $divHeading . $divContent;

            write_file(FPENGUIN . 'application/views/' . theme_web() . '/' . $module_name . '/' . $template_name . '.tpl', $file_content);
        }
    }

    public function writeViewTPL($resource_name, $main_resource_name, $template_name, $form_link, $is_search_form, $field_search, $template_view)
    {
        $this->load->library('xml');
        $this->load->helper('file');

        // get resource
        $this->db->select('module_resources.id, module_resources.module_id, modules.name as module_name');
        $this->db->from('module_resources');
        $this->db->join('modules', 'modules.id = module_resources.module_id');
        $this->db->where(array('module_resources.name' => $resource_name));
        $resource_query = $this->db->get();

        if($resource_query->num_rows() == 0)
        {
            show_error('Resource not exit.');
        }

        // get result obj
        $resource_obj = $resource_query->row();

        // get table resource id
        if($main_resource_name)
        {
            $this->db->select('id');
            $main_resource_query = $this->db->get_where('module_resources', array('name' => $main_resource_name));

            if($main_resource_query->num_rows() == 0)
            {
                show_error('Main resource not exit.');
            }

            $table_resource_id = $main_resource_query->row()->id;
        }
        else
        {
            $table_resource_id = $resource_obj->id;
        }

        // get module resource fields              
        $this->db->select('id, name, field_type');
        $this->db->from('module_fields');
        $this->db->order_by('weight asc');
        $this->db->where(array('resource_id' => $table_resource_id));
        $module_fields_query = $this->db->get();

        if($module_fields_query->num_rows() == 0)
        {
            show_error('Main resource not exit.');
        }

        $module_fields = $module_fields_query->result_array();

        if($template_view == 'index')
        {
            $this->M_builder->writeIndex($resource_obj->module_name, $resource_name, $is_search_form, $field_search, $form_link, $template_name);
        }
        else if($template_view == 'add') // // if template view == index
        { // template == add
            $this->M_builder->writeAdd($resource_obj->module_name, $resource_name, $module_fields, $template_name);
        }
        else if($template_view == 'edit') // // template_view = add
        { // template_view = edit
            $this->M_builder->writeEdit($resource_obj->module_name, $resource_name, $module_fields, $template_name);
        }
        else if($template_view == 'view') // // template_view = edit
        { // if template view is 'view'
            $this->M_builder->writeView($resource_obj->module_name, $resource_name, $module_fields, $template_name);
        }
    }

}

?>
