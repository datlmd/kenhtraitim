<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Pages
 * ...
 * 
 * @package PenguinFW
 * @subpackage Page
 * @version 1.0.0
 * 
 * @property Page           $Page
 */
 
class Pages extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->lang->load('generate', lang_web());
        $this->lang->load('pages', lang_web());

    }
    
    /**
     * View data in page
     * 
     * @param int       $id
     * @param string    $lang_code
     * @param string    $slug 
     */
    public function view($id = 0, $lang_code = '', $slug = '')
    {
        $this->load->model('Page');
        // check permission 
        $this->PG_ACL('r');
        
        if (!$lang_code) $lang_code = lang_web ();

        // page
        $page = $this->Page->find('first',array('where' => array('id' => $id)));
        
        //if (!$page) show_404();
        
        //if ($page->is_active != 1) show_404();
        
        if ($page->lang_code != $lang_code) 
        {
            $page_map = $this->Page->get(array('mapto_id' => $page->mapto_id, 'lang_code' => $lang_code));
            
            if ($page_map)
                redirect_to('pages', '', 'view', "{$page_map->id}/$lang_code/{$page->slug}");
        }
        
        if ($page->slug != $slug) redirect_to('pages', '', 'view', "$id/$lang_code/{$page->slug}");
        
        if ($page->layout)        
            $this->layout->set_layout($page->layout);
        else         
            $this->layout->set_layout('default');        
        
        // set title
        $this->layout->set_title($page->title);

        $this->load->helper('html');
        //Xử lý include view
        $html_content = $page->content;
        $pattern = '%<pw_framework>(.*?)</pw_framework>%';
        preg_match_all($pattern, $html_content, $matches);
        if(count($matches)>0)
        {
            $this->load->model('pages/Page_view_manage');
            $count_key = count($matches[1]);
            for($i=0;$i<$count_key;$i++)
            {
                $get_module_view = $this->Page_view_manage->find('all', array(
                    'where' => array(
                        'key =' => $matches[1][$i]
                    )
                ));

                $get_module_view_data = '';
                if($get_module_view)
                {
                    $get_module_view_data = file_get_contents(base_url().$get_module_view[0]['controller'].'/'.$get_module_view[0]['action']);
                    $html_content =  str_replace('<pw_framework>'.$get_module_view[0]['key'].'</pw_framework>', $get_module_view_data, $html_content);
                }
            }
        }

        $data = array(
            'datapage' => $html_content
        );
        
        // template
        $this->parser->parse('view', $data);
    }

    
    
}
                
?>