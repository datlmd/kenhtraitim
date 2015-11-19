<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Admin_translations
 * ...
 * 
 * @package PenguinFW
 * @subpackage Language
 * @version 1.0.0
 * 
 * @property Translation        $Translation
 */
 
class Admin_translations extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Translation';
        
        // set layout
        $this->layout->set_layout('admin');
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('languages', lang_web());
            
        $this->load->model('Translation');                
    }
    
    /**
     * List and Edit
     * 
     * @param int $lang_id
     */
    public function index($lang_id = 0)
    {
        // check permission
        $this->PG_ACL('r');
        
        // set title
        $this->layout->set_title(lang('Language manager'));
        
        // check lang id
        if ($lang_id == 0)
        {
            redirect('languages/admin_languages');
        }
        
        // get all module
        $modules = $this->Translation->getModule();
        
        // set data        
        $data = array(
            'modules' => $modules,
            'lang_id' => $lang_id
        );
        
        // set template
        $this->parser->parse($this->router->class . '/index', $data);
    }
    
    /**
     * TRANSLATE
     * 
     * @param int $module_id
     */
    public function translate($module_id = 0, $lang_id = 0)
    {
        // check permission
        $this->PG_ACL('e');                
       
        // set title
        $this->layout->set_title(lang('Translate'));
        
        // get params
        $module_id = ($this->input->post('module_id')) ? $this->input->post('module_id') : $module_id;
        $lang_id = ($this->input->post('lang_id')) ? $this->input->post('lang_id') : $lang_id;
        
        // check valid
        if (!$module_id || !$lang_id)
        {
            show_error(lang('Error params'));
        }
        
        if ($module_id != -1)
        {
        // get module name
        $module_name = $this->getModuleName('', $module_id);
        
        // check valid module
        if (!$module_name)
        {
            show_error(lang('Error params'));
        }
        }
        
        // check valid language
        $language = $this->Translation->getLanguage($lang_id);
        if (!$language)
        {
            show_error(lang('Error params'));
        }
        
        // process post form
        if ($this->input->post())
        {
            $translates = $this->input->post('translate');
            
            if (!empty ($translates))
            {
                foreach ($translates as $translation_id => $value)
                {
                    $this->Translation->update(array('value' => $value), array('id' => $translation_id));
                }
            }
            
            // redirect
            redirect('languages/admin_translations/translate/' . $module_id . '/' . $lang_id);
        }
        
        // set conditions
        // set where
        $this->paginator['where'] = array('module_id' => $module_id, 'lang_id' => $lang_id);
        
        // search 
        $keyword = $this->input->get('q');
        if ($keyword)
        {
            $this->paginator['where']['key LIKE '] = '%' . $keyword . '%';
            $this->paginator['or']['value LIKE '] = '%' . $keyword . '%';
        }
        
        // set order
        $this->paginator['order'] = array('key' => 'asc');
        
        // set limit
        $this->paginator['limit'] = 200;
        
        // get translation
        $translations = $this->pagination(6);                
        
        // set data        
        $data = array(
            'translations' => $translations,
            'language' => $language,
            'module_id' => $module_id,
            'lang_id' => $lang_id,
            'pagination_link' => $this->getPaginationLink('/languages/admin_languages/translate/' . $module_id . '/' . $lang_id, 6)
        );
        
        // set template
        $this->parser->parse($this->router->class . '/translate', $data);
    }
    
    /**
     * ADD KEY
     * 
     * @param int $module_id
     */
    public function add($module_id = 0, $lang_id = 0)
    {
        // check permission
        $this->PG_ACL('w');
        
        // set title
        $this->layout->set_title(lang('Add key translation'));
        
        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // form validate
        $this->form_validation->set_rules('module_id', 'Module', 'required');
        $this->form_validation->set_rules('lang_id', 'Language', 'required');
        $this->form_validation->set_rules('key', 'Key', 'required');
        $this->form_validation->set_rules('value', 'Value', 'required');
        
        // get params
        $module_id = ($this->input->post('module_id')) ? $this->input->post('module_id') : $module_id;
        $lang_id = ($this->input->post('lang_id')) ? $this->input->post('lang_id') : $lang_id;
        
        if ($module_id != -1)
        {
        // get module name
        $module_name = $this->getModuleName('', $module_id);
        
        // check valid module
        if (!$module_name)
        {
            show_error(lang('Error params'));
        }
        }
        
        // check valid language
        $language = $this->Translation->getLanguage($lang_id);
        if (!$language)
        {
            show_error(lang('Error params'));
        }
        
        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE)
        {
            // insert 
            $this->Translation->create($this->input->post(), TRUE);
            
            // redirect
            redirect('languages/admin_translations/translate/' . $module_id . '/' . $lang_id);
        }
        
        // set data        
        $data = array(
            'module_id' => $module_id,
            'lang_id' => $lang_id
        );
        
        // set template
        $this->parser->parse($this->router->class . '/add', $data);
    }
    
    /**
     * Clear cache language
     * 
     * @param int $module_id
     * @param int $lang_id 
     */
    public function refresh($lang_id = 0)
    {
        // check permission
        $this->PG_ACL('p');
        
        // get module
        $modules = $this->Translation->find('all', array(
            'from' => 'modules',
            'limit' => 0
        ));
        
        foreach ($modules as $module)
        {
            $this->_writeCacheLanguage($module['id'], $lang_id);
            $this->_writeCacheLanguage($module['id'], $lang_id, APPPATH . 'language/');
        }
        
        $this->_writeCacheLanguage(-1, $lang_id);
        $this->_writeCacheLanguage(-1, $lang_id, APPPATH . 'language/');
        
        // redirect
        redirect("languages/admin_languages");
    }
    
    /**
     * Copy
     * 
     * @param int $module_id
     * @param int $lang_id 
     */
    public function copy($module_id = 0, $lang_id = 0)
    {
        // permission
        $this->PG_ACL('w');
        
        // check valid
        $language = $this->Translation->getLanguage($lang_id);
        if (!$language)
        {
            show_error(lang('Error params'));
        }
        
        // get key default
        $translation_defaults = $this->Translation->get(array('lang_id' => 1), NULL, FALSE, 0);
        
        // add key to lang_id 
        foreach ($translation_defaults as $translation_default)
        {
            $data_add = array(
                'key' => $translation_default['key'],
                'value' => $translation_default['value'],
                'lang_id' => $lang_id,
                'module_id' => $translation_default['module_id']
            );
            
            $this->Translation->create($data_add);
        }
        
        // redirect
        redirect('languages/admin_translations/translate/' . $module_id . '/' . $lang_id);
    }
    
    /**
     * search translation
     */
    public function search()
    {
        // check permission
        $this->PG_ACL('r');
        
        // setlayout
        $this->layout->set_layout('popup');
        
        // set title
        $this->layout->set_title(lang('Keyword search'));
        
        // result default
        $results = array();
        
        // set keyword
        $keyword = $this->input->get('q');
        
        // filter
        if ($keyword)
        {
            $this->paginator = array(
                'select' => 't.*, l.name as language, m.name as module',
                'from' => 'translations t',
                'leftjoin' => array(
                    'languages l' => 'l.id = t.lang_id',
                    'modules m' => 'm.id = t.module_id'
                ),
                'where' => array(
                    "MATCH(t.key, t.value) AGAINST ('$keyword' IN BOOLEAN MODE) > " => 0
                )
            );
            
            $results = $this->pagination(4);
        }
        
        // set template
        $this->parser->parse($this->router->class . '/search', array(
            'translations' => $results
        ));
    }

    /**
     * delete translation
     * 
     * @param int $id 
     */
    public function delete($id = 0)
    {
        // check permission
        $this->PG_ACL('d');
        
        // get translation
        $translation = $this->Translation->get(array('id' => $id));
        
        if (!$translation) show_404();
                
        $this->Translation->deleteRecord(array('id' => $id));        
        
        redirect("languages/admin_translations/translate/{$translation->module_id}/{$translation->lang_id}");
        
        $this->layout->disable_layout();
    }
    
    /**
     * Write to cache
     * 
     * @param int $module_id
     * @param int $lang_id
     * @param string $folder_lang_path
     * @return boolean 
     */
    private function _writeCacheLanguage($module_id, $lang_id, $folder_lang_path = '')
    {
        if ($module_id != -1)
        {
            // get module name
            $module_name = $this->getModuleName('', $module_id);

            // check valid module
            if (!$module_name)
            {
                return FALSE;
            }
        } else 
        {
            $module_name = 'generate';
        }
        
        // check valid language
        $language = $this->Translation->getLanguage($lang_id);
        if (!$language)
        {
            return FALSE;
        }
        
        // get folder file lang
        if (!$folder_lang_path)
            $folder_lang    = 'static/language/';
        else 
            $folder_lang    = $folder_lang_path;
        
        $folder_lang        = FPENGUIN . $folder_lang;
        
        // create folder code
        if (!is_dir($folder_lang . $language->code))
        {
            mkdir($folder_lang . $language->code, 0775);
        }
        
        // get translations
        $translations = $this->Translation->get_select('key,value', array('module_id' => $module_id, 'lang_id' => $lang_id), 'key asc', FALSE, 0);
        
        // file
        $this->load->helper('file');
        
        // open file content
        $file_content = "<?php\n\n\$lang = array(\n";
                
        // write file
        if ($translations)
        {                                    
            foreach ($translations as $translation)
            {
                $key = make_slug($translation['key'], TRUE);
                $file_content .= "\t'" . strtolower($key) . "' => '" . addslashes($translation['value']) . "',\n";
            }
        }
        
        // close file content
        $file_content .= ");\n\n?>";
        
        // write file
        $file_lang = $folder_lang . $language->code . '/' . $module_name . '_lang.php';
        write_file($file_lang , $file_content);
    }
}
                
?>