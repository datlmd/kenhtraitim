<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Frontend
 * ...
 * 
 * @package PenguinFW
 * @subpackage Frontend
 * @version 1.0.0
 * 
 * @property Article_category       $Article_category
 */
class Frontend extends MY_Controller {

    function __construct() {

        parent::__construct();
        $this->lang->load('generate', lang_web());
    }

    /**
     * home page
     */
    public function index() {
        $this->load->model('films/Film');

        $this->load->model('musics/Music_category');
        $cate_le = $this->Music_category->getCategoryParent_id(1);
        $cate_bo = $this->Music_category->getCategoryParent_id(2);

        $film_hot = $this->Film->find('all', array(
            'select' => '*',
            'where' => array(
                'status' => 1,
                'is_hot' => 1
            ),
            'order' => array(
                'modified' => 'desc',
            ),
            'limit' => 14
        ));

        $film_focus = $this->Film->find('all', array(
            'select' => '*',
            'where' => array(
                'status' => 1,
                'is_hot' => 2
            ),
            'order' => array(
                'modified' => 'desc',
            ),
            'limit' => 6
        ));

        $film_le = $this->Film->find('all', array(
            'select' => '*',
            'where' => array(
                'status' => 1,
                'category like' => '%phim lẻ%',
                'is_hot' => 0
            ),
            'order' => array(
                'modified' => 'desc',
            ),
            'limit' => 14
        ));

        $film_bo = $this->Film->find('all', array(
            'select' => '*',
            'where' => array(
                'status' => 1,
                'category like' => '%phim bộ%',
                'is_hot' => 0
            ),
            'order' => array(
                'modified' => 'desc',
            ),
            'limit' => 14
        ));

        $data = array(
            'film_hot' => $film_hot,
            'film_focus' => $film_focus,
            'film_le' => $film_le,
            'film_bo' => $film_bo,
            'cate_le' => $cate_le,
            'cate_bo' => $cate_bo
        );
        $this->parser->parse('index', $data);
    }

    /**
     * home page
     */
    public function categories($slug = NULL) {
        $this->load->model('films/Film');
        $this->model_name = "Film";
        $this->load->model('musics/Music_category');
        $cate_le = $this->Music_category->getCategoryParent_id(1);
        $cate_bo = $this->Music_category->getCategoryParent_id(2);

        $name_cate = $this->Music_category->find('first', array(
            'select' => 'id,name',
            'where' => array(
                'slug like' => '%' . $slug . '%'
            ),
        ));


        $this->paginator['select'] = array('*');

        //where
        $this->paginator['where']['status'] = 1;
        $this->paginator['where']['category like'] = '%' . $name_cate->name . '%';

        if ($name_cate->id == 1)
            $this->paginator['where']['category like'] = '%phim lẻ%';
        if ($name_cate->id == 2)
            $this->paginator['where']['category like'] = '%phim bộ%';
        if ($name_cate->id == 3)
            $this->paginator['where']['category like'] = '%phim 3d%';

        //order
        $this->paginator['order'] = array('modified' => 'desc');

        $this->paginator['limit'] = 28;

        $uri_segment = 8;
        // get Article Category
        $films = $this->pagination($uri_segment);

        $pagination_link = $this->getPaginationCustom('', $slug . '.html', '', '', $uri_segment);

        $data = array(
            'films' => $films,
            'pagination_link' => $pagination_link,
            'cate_name' => $name_cate->name,
            'cate_le' => $cate_le,
            'cate_bo' => $cate_bo
        );
        $this->parser->parse('categories', $data);
    }

    /**
     * home page
     */
    public function detail($id = 0, $slug = NULL) {
        $this->load->model('films/Film');
        $this->load->model('musics/Music_category');
        $cate_le = $this->Music_category->getCategoryParent_id(1);
        $cate_bo = $this->Music_category->getCategoryParent_id(2);

        // check params
        if ($id == 0) {
            show_404();
        }

        $film = $this->Film->find('first', array(
            'select' => '*',
            'where' => array(
                'id' => $id,
                'status' => 1
            ),
        ));

        // article NOT exist
        if (!$film) {
            show_404();
        }

        $this->layout->set_title($film->name . ' ' . $film->name_en . ' ' . $film->year . ' | Phim HD'); //' | kenhtraitim.com - Kênh chia sẻ thông tin giải trí nhanh nhất'
        $this->layout->set_description($film->meta_description);
        $this->layout->set_keyword($film->meta_keyword);

        $this->layout->set_image($film->image);

        $category_ids = explode(',', $film->category);
        //var_dump($film->category);
        $string_category = '';
        $category_url = '';
        for ($i = 0; $i < count($category_ids); $i++) {
            $slug = $this->Music_category->find('first', array(
                'select' => 'id,slug',
                'where' => array(
                    'name like' => '%' . $category_ids[$i] . '%'
                )
            ));
            if ($slug->id > 3) {
                if ($string_category == '') {
                    $string_category = '<a href="' . base_url() . $slug->slug . '.html">' . $category_ids[$i] . '</a>';
                    $category_url = '<a href="' . base_url() . $slug->slug . '.html">' . $category_ids[$i] . '</a>';
                } else
                    $string_category .= ', <a href="' . base_url() . $slug->slug . '.html">' . $category_ids[$i] . '</a>';
            }
        }
        $url_cur = current_url();

        $film_cate = '';
        if (count($category_ids) > 1) {
            $film_cate = $this->Film->find('all', array(
                'select' => '*',
                'where' => array(
                    'status' => 1,
                    'id <>' => $id,
                    'category like' => '%' . $category_ids[1] . '%',
                //'category like' => '%' . $category_ids[0] . '%'
                ),
                'order' => array(
                    'modified' => 'desc',
                ),
                'limit' => 14
            ));
        }
        $film_view = $this->Film->find('all', array(
            'select' => '*',
            'where' => array(
                'status' => 1,
                'id <>' => $id,
            ),
            'order' => array(
                'counter_view' => 'desc'
            ),
            'limit' => 14
        ));

        $tags = explode(',', $film->data1);
        $film_tag = '';
        if (count($tags) > 0) {
            $film_tag = $this->Film->find('all', array(
                'select' => '*',
                'where' => array(
                    'status' => 1,
                    'id <>' => $id,
                    'data1 like' => '%' . $tags[0] . '%'
                ),
                'order' => array(
                    'modified' => 'desc',
                ),
                'limit' => 7
            ));
        }

        $this->Film->update_counter($id, $film->counter_view);

        $data = array(
            'film' => $film,
            'string_category' => $string_category,
            'film_cate' => $film_cate,
            'film_view' => $film_view,
            'film_tag' => $film_tag,
            'url_cur' => $url_cur,
            'category_url' => $category_url,
            'cate_le' => $cate_le,
            'cate_bo' => $cate_bo
        );
        $this->parser->parse('detail', $data);
    }

    public function tintuc() {

        $this->load->model('musics/Music_category');
        $cate_le = $this->Music_category->getCategoryParent_id(1);
        $cate_bo = $this->Music_category->getCategoryParent_id(2);

        require_once("function.php");
        include_once ("crawl.php");

        $this->load->helper('cookie');
        
        $type = '';
        if($this->input->cookie('type_url', TRUE)){
            $type = $this->input->cookie('type_url' , TRUE);
        } 
        else {
            $type = 'http://vnexpress.vn';
        }
        
        $H_Crawl = new H_Crawl ( );
        
        switch ($type) {
            case 1:
                $list_url = MyFunctions::kenh14_categorise();
                $list = array();
                for ($i = 0; $i < count($list_url); $i++) {

                    $content = $this->runBrowser($list_url[$i]['url']);
                    //$content = $H_Crawl->getTitle( $list_url[$i], 'ul.nav1');	

                    $list_temp = MyFunctions::list_all_link_kenh14($content, 'http://kenh14.vn', $list_url[$i]['name'], $list_url[$i]['url'], 7);

                    $list = array_merge($list, $list_temp);
                    //var_dump($list);
                }
                break;
            case 4:
                $list_url = MyFunctions::_2sao_categorise();
                $list = array();
                for ($i = 0; $i < count($list_url); $i++) {

                    $content = $this->runBrowser($list_url[$i]['url']);
                    //$content = $H_Crawl->getTitle( $list_url[$i], 'ul.nav1');	

                    $list_temp = MyFunctions::list_all_link_2sao($content, 'http://2sao.vn', $list_url[$i]['name'], $list_url[$i]['url'], 7);

                    $list = array_merge($list, $list_temp);
                    //var_dump($list);
                }
                break;
            case 2:
                $url = 'http://2sao.vn';
                break;
        }
        

        $data = array(
            'list_all' => $list,
            'list_url' => $list_url,
            'cate_le' => $cate_le,
            'cate_bo' => $cate_bo
        );
        $this->parser->parse('tintuc', $data);
    }

    public function runBrowser($url) {

        if (function_exists('curl_init')) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            $response = curl_exec($ch);
            curl_close($ch);
        } else {
            $response = @file_get_contents($url);
        }

        return $response;
    }

    public function chuyenmuc() {
        $this->load->model('musics/Music_category');
        $cate_le = $this->Music_category->getCategoryParent_id(1);
        $cate_bo = $this->Music_category->getCategoryParent_id(2);
        
        $this->load->helper('cookie');

        require_once("function.php");
        include_once ("crawl.php");

        
        //var_dump($this->input->cookie('type_url' , TRUE));
        $url = $_GET['url'];
        $cate = '';

        if (!$url) {
            show_404();
        }

        $type = '';
        if($this->input->cookie('type_url', TRUE)){
            $type = $this->input->cookie('type_url' , TRUE);
        } 
        else {
            $type = 'http://vnexpress.vn';
        }
        
        $H_Crawl = new H_Crawl ( );
        $content = $this->runBrowser($url);
        
        switch ($type) {
            case 1:
                $list_url = MyFunctions::kenh14_categorise();
                for ($i = 0; $i < count($list_url); $i++) {
                    if (substr($list_url[$i]['url'], 0, strlen($list_url[$i]['url']) - 5) == substr($url, 0, strlen($list_url[$i]['url']) - 5)) {
                        $cate = $list_url[$i]['name'];
                        break;
                    }
                }
                $list = MyFunctions::list_all_link_kenh14($content, 'http://kenh14.vn', $cate, $url);
                break;
            case 4:
                $list_url = MyFunctions::_2sao_categorise();
                for ($i = 0; $i < count($list_url); $i++) {
                    if (substr($list_url[$i]['url'], 0, strlen($list_url[$i]['url']) - 5) == substr($url, 0, strlen($list_url[$i]['url']) - 5)) {
                        $cate = $list_url[$i]['name'];
                        break;
                    }
                }
                $list = MyFunctions::list_all_link_2sao($content, 'http://2sao.vn', $cate, $url);
                break;
            case 2:
                $url = 'http://2sao.vn';
                break;
        }
 
        //$content = $H_Crawl->getTitle( $list_url[$i], 'ul.nav1');	

        //$list = MyFunctions::list_all_link_2sao($content, 'http://2sao.vn', $cate, $url);
        
        

        $page = $H_Crawl->getTitle($url, 'div#MainContent_SaoList1_Pager1_pager');
        $page = str_ireplace("href =", "href=", $page);
        $page = str_ireplace("href= ", "href=", $page);
        $page = str_ireplace("href='", "href='" . base_url() . "chuyenmuc?url=http://2sao.vn", $page);

        preg_match('/meta id=\"keywords\" name=\"keywords\" content=\"(.*?)\"/', $content, $matches);
        $key = $matches[1];
        preg_match('/meta id=\"description\" name=\"description\" content=\"(.*?)\"/', $content, $matches);
        $des = $matches[1];

        $title = $H_Crawl->getTitle($url, 'title');
        $title = str_ireplace('2Sao.vn', '', $title);
        $title = str_ireplace(' - ', '', $title);
        $this->layout->set_title($title . 'Kênh Trái Tim | kenhtraitim.com'); //' | kenhtraitim.com - Kênh chia sẻ thông tin giải trí nhanh nhất'
        $this->layout->set_description('kenhtraitim.com | Kênh Trái Tim  - ' . $des);
        $this->layout->set_keyword($key);
        //$this->layout->set_image($img);

        $data = array(
            'list_all' => $list,
            'list_url' => $list_url,
            'page' => $page,
            'cate_le' => $cate_le,
            'cate_bo' => $cate_bo
        );
        $this->parser->parse('chuyenmuc', $data);
    }
    
    public function type() {
        $url = $_GET['type'];
        
        if (!$url) {
            show_404();
        }
        $this->load->helper('cookie');
        
        $cookie_config = array(
                    'name' => 'type_url',
                    'value' => $url,
                    'expire' => '86400',
                    'domain' => '',
                    'path' => '/',
                    'prefix' => '',
                    'secure' => FALSE
                );
                set_cookie($cookie_config);
                
       
        //$this->input->set_cookie($cookie);
        
        redirect('tintuc');
    }

    public function chitiet() {
        $this->load->model('musics/Music_category');
        $cate_le = $this->Music_category->getCategoryParent_id(1);
        $cate_bo = $this->Music_category->getCategoryParent_id(2);

        require_once("function.php");
        include_once ("crawl.php");

        $url = $_GET['url'];

        if (!$url) {
            show_404();
        }

        $H_Crawl = new H_Crawl ( );


        $noidung = MyFunctions::get_content_by_url($url);
        //echo $content;
        $title = $H_Crawl->getTitle($url, 'title'); //   MyFunctions::get_content_by_tag($noidung, "<h1 class=\"title\">");

        $tomtat = str_ireplace('(2Sao) - ', '', $H_Crawl->getTitle($url, 'div.row h5'));
        $tomtat = str_ireplace('(2Sao)- ', '', $tomtat);
        $tomtat = str_ireplace('(2Sao)', '', $tomtat);

        //$content = $H_Crawl->getTitle($url, 'div#divfirst') . $H_Crawl->getTitle($url, 'div#vmcbackground') . $H_Crawl->getTitle($url, 'div#divend'); // $matches [1];
        $content = $H_Crawl->getTitle($url, 'div#vmccontent'); // $matches [1];
//var_dump($content);die;
        
        if (!$title || !$content) {
            show_404();
        }

        preg_match('/meta itemprop=\"datePublished\" content=\"(.*?)\"/', $noidung, $matches);
        $date_n = $matches[1];

        preg_match('/meta id=\"keywords\" name=\"keywords\" content=\"(.*?)\"/', $noidung, $matches);
        $key = $matches[1];

        preg_match('/meta property=\"og:image\" content=\"(.*?)\"/', $noidung, $matches);
        $img = $matches[1];
        //var_dump($img);die;
        //tieu diem
        $focus = $H_Crawl->getTitle($url, 'div.fixtop ul.nav2');
        $focus = '<ul>' . str_ireplace("href=\"", "href=\"" . base_url() . "chitiet?url=http://2sao.vn", $focus) . '</ul>';

        $tags = $H_Crawl->getTitle($url, 'ul.nav ul.nav');
        $tags = '<ul>' . str_ireplace("href=\"", "href=\"" . base_url() . "chitiet?url=http://2sao.vn", $tags) . '</ul>';

//    	$list_cate = $H_Crawl->getTitle ( $url, 'h4.headh4 ul.nav' );
//    	//$list_cate = str_ireplace("href=\"", "href=\"" . base_url() . "chitiet?url=http://2sao.vn",$list_cate);
//    	var_dump($list_cate);

        $this->layout->set_title($title); //' | kenhtraitim.com - Kênh chia sẻ thông tin giải trí nhanh nhất'
        $this->layout->set_description($tomtat);
        $this->layout->set_keyword($key);

        $this->layout->set_image($img);

        $url_cur = current_url();

        $k = 0;
        $list_url = array();
        $list_url[$k]['name'] = 'Sao';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1000/sao.vnn";
        $list_url[$k]['name'] = 'Xã hội';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1048/su-kien-xa-hoi.vnn";
        $list_url[$k]['name'] = 'Thời trang';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1004/thoi-trang.vnn";
        $list_url[$k]['name'] = 'Âm nhạc';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1001/am-nhac.vnn";
        $list_url[$k]['name'] = 'Điện ảnh';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1002/phim.vnn";
        $list_url[$k]['name'] = 'Fun';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1005/hoi-dap.vnn";
        $list_url[$k]['name'] = 'Giới trẻ';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1049/doi-song-gioi-tre.vnn";
        $list_url[$k]['name'] = 'Thể thao';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1051/the-thao.vnn";
        $list_url[$k]['name'] = 'Lạ';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1052/chuyen-la.vnn";
        $list_url[$k]['name'] = 'Giới tính';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1064/suc-khoe-gioi-tinh.vnn";
        $list_url[$k]['name'] = 'Tâm sự';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1065/tam-su.vnn";
        $list_url[$k]['name'] = 'Clip';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1066/clip.vnn";
        $list_url[$k]['name'] = 'Ảnh';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1067/anh.vnn";
        $list_url[$k]['name'] = 'Truyện';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1068/truyen.vnn";
        $list_url[$k]['name'] = 'Chơi';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1070/choi.vnn";

        $data = array(
            'title' => $title,
            'tomtat' => $tomtat,
            'content' => $content,
            'focus' => $focus,
            'tags' => $tags,
            'url_cur' => $url_cur,
            'url_root' => $url,
            'list_url' => $list_url,
            'date_n' => $date_n,
            'cate_le' => $cate_le,
            'cate_bo' => $cate_bo
        );
        $this->parser->parse('chitiet', $data);
    }

}
