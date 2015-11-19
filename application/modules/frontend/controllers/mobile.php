<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mobile extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->lang->load('generate', lang_web());
        $this->layout->set_layout('mobile/default');
    }

    /**
     * @author dungdv3@vng.com.vn
     * Created date: 30/10/2013
     * This is Trang Chủ, default page if request is detected by mobile.
     */
    function index() {
        $data = array();
        $this->load->model('articles/Article');
        $this->load->model('articles/Article_dictionary');
        $this->load->model('photos/Photo');
        $current_datetime = date('Y-m-d H:i:s', time());

        $thele = $this->Article->get_newest_articles(1, config_item('id_category_thele'), 1, 0);
        $top3_artiles = $this->Article->get_hot_articles(1, config_item('id_category_article'), 3);
        $top6_photo = $this->Photo->list_avaiable_photos(config_item('id_category_photo_default'), 1, '', $current_datetime, 6, 0);

        $data['thele'] = $thele;
        $data['articles'] = $top3_artiles;
        $data['photos'] = $top6_photo;
        $data['active'] = 'trang-chu';

//        debug($data);
        $this->parser->parse("mobile/trang-chu", $data);
    }

    public function login() {
        $this->load->library(array("facebook_login", "google_login", "yahoo_login", "zing_me"));
        $this->load->model('Users/User');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        $this->form_validation->set_message('required', '* Bạn phải nhập thông tin này');

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        $session_id = $this->session->userdata('user_id');
        $data = null;
        if ($session_id) {
            redirect('mobile');
        } else {
            if ($this->form_validation->run() == TRUE) {
                if ($this->User->login($this->input->post('username'), $this->input->post('password')) == TRUE) {
                    $userData = $this->User->get_by_username($this->input->post('username'));
                    $this->session->set_userdata('user_id', $userData->id);
                    $this->session->set_userdata('user_username', $userData->username);
                    $this->session->set_userdata('user_fullname', $userData->full_name);
                    redirect('mobile');
                }else{
                    $data['check_login'] = '<p class="error">* Tên đăng nhập hoặc mật khẩu không chính xác.</p>';
                }
            }

            $fbScope = array("email");
            $fbRedirect = base_url() . "open_login/facebook";
            $fbLoginURL = $loginURL = $this->facebook_login->getFBLoginUrl($fbScope, $fbRedirect);
            $data['fbURL'] = $fbLoginURL;

            $ggLoginURL = $this->google_login->getGoogleLoginURL();
            $data['ggURL'] = $ggLoginURL;

            $return_url = full_url();
            $zm_redirect = base_url() . "open_login/zm_login";
            $zm_login_url = $this->zing_me->zm_get_login_url($zm_redirect, $return_url);
            $data['zmURL'] = $zm_login_url;

            $yhCallback = base_url() . "open_login/yahoo?in_popup";
            $yhLogin = $this->yahoo_login->getAuthenticateURL($yhCallback);
            $data['yhURL'] = $yhLogin;

            if ($this->input->post()) {
                $data['post'] = $this->input->post();
            }
            
            $data['active'] = 'dang-nhap';
            $this->parser->parse("mobile/login", $data);
        }
    }

    /**
     * @author dungdv3@vng.com.vn
     * Created date: 30/10/2013
     * This action will load page list item article
     * @param type $page: pagination.
     */
    public function danh_sach_tin_tuc($page) {

        $this->model_name = 'Article';
        $this->load->model('articles/Article');
        $this->paginator['select'] = array('articles.*, ad.subject as subject, ad.teaser as teaser, ad.tags as tags, ad.slug as slug, acr.article_id as article_id');
        //join
        $this->paginator['join'] = array(
            'article_dictionaries ad' => 'ad.article_id = articles.id',
            'article_category_relationships acr' => 'acr.article_id = articles.id',
        );
        //where
        $this->paginator['where'] = array(
            //'acr.article_category_id' => 2,
            'articles.is_publish' => 1,
            'ad.lang_id' => 1,
            'articles.is_delete' => 0,
            'articles.publish_date <=' => date('Y-m-d H:i:s', time()),
            'acr.article_category_id' => config_item('id_category_article')
        );

        //order
        $this->paginator['order'] = array('articles.publish_date' => 'desc', 'ad.subject' => 'asc');

        $this->paginator['limit'] = 6;

        $uri_segment = 5;
        // get Article Category
        $list_articles = $this->pagination($uri_segment);
        $pagination_link = $this->getPaginationCustom('mobile', 'tin-tuc', '', '', $uri_segment);

        $data = array(
            'pagination_link' => $pagination_link,
            'list_articles' => $list_articles,
            'active' => 'tin-tuc'
        );
//        debug($data);
        $this->parser->parse("mobile/danh-sach-tin-tuc", $data);
    }

    public function chi_tiet_tin_tuc($id_news) {
        $this->load->model('articles/Article_dictionary');
        $this->load->model('articles/Article');

        $this->Article->incrementField(array('id' => $id_news), 'counter_view');

        $option = array(
            'join' => array(
                'article_category_relationships acr' => 'acr.article_id = article_dictionaries.article_id'
            ),
            'where' => array(
                'article_dictionaries.article_id' => $id_news,
                'acr.article_category_id' => config_item('id_category_article')
            )
        );

        $article_content = $this->Article_dictionary->find('all', $option);
//        debug($article_content);
        if ($article_content) {
            $article_detail = $this->Article->find('all', array(
                'where' => array(
                    'id' => $id_news
                )
            ));
        } else {
            $article_detail = '';
        }

        $data['content'] = $article_content;
        $data['detail'] = $article_detail;
        $data['active'] = 'tin-tuc';
//        debug($data);
        $this->parser->parse("mobile/chi-tiet-tin-tuc", $data);
    }

    public function the_le() {
        $this->load->model('articles/Article');
        $this->load->model('articles/Article_dictionary');

        $thele = $this->Article->get_newest_articles(1, config_item('id_category_thele'), 1, 0);

        $option = array(
            'where' => array(
                'article_id' => $thele['0']['id']
            )
        );
        $article_content = $this->Article_dictionary->find('all', $option);
        $data['content'] = $article_content;
        $data['active'] = 'the-le';
//        debug($data);
        $this->parser->parse("mobile/the-le", $data);
    }

    /**
     * @author dungdv3@vng.com.vn
     * Created date: 30/10/2013
     * This action will load page list item photo
     * @param type $page: pagination.
     */
    public function danh_sach_hinh_anh($page) {
        $this->model_name = 'Photo';
        $this->load->model('photos/Photo');

        $this->paginator['select'] = array('photos.*');
        $this->paginator['join'] = array(
            'photo_categories pc' => 'photos.photo_category_id=pc.id',
            'photo_albums pa' => 'photos.photo_album_id=pa.id'
        );

        $this->paginator['where'] = array(
            'photos.photo_status_id' => 1,
            'photos.is_delete' => 0,
            'pc.category_status_id' => 1,
            'pa.album_status_id' => 1,
            'pc.id' => config_item('id_category_photo_default')
        );

        $this->paginator['order'] = array('photos.modified' => 'desc');

        $this->paginator['limit'] = 6;

        $uri_segment = 3;
        // get Article Category
        $list_photos = $this->pagination($uri_segment);

        $pagination_link = $this->getPaginationCustom('mobile', 'hinh-anh', '', '', $uri_segment);

        $data = array(
            'pagination_link' => $pagination_link,
            'list_photos' => $list_photos,
        );
        $data['active'] = 'hinh-anh';
        $this->parser->parse("mobile/danh-sach-hinh-anh", $data);
//        debug($data);
    }

    public function chi_tiet_hinh_anh($id_photo) {
        $this->load->model('photos/Photo');
        $this->load->model('votes/Vote');

        $this->Photo->incrementField(array('id' => $id_photo), 'counter_view');

        $option = array(
            'select' => '*, photos.id as id',
            'join' => array(
                'photo_categories pc' => 'photos.photo_category_id = pc.id'
            ),
            'where' => array(
                'photos.id' => $id_photo,
                'photos.photo_status_id' => 1,
                'photos.is_delete' => 0,
                'pc.id' => config_item('id_category_photo_default')
            )
        );
        $photo_detail = $this->Photo->find('all', $option);

        $data['enable_vote'] = -1;
        if ($this->session->userdata('user_id')) {
            $data['enable_vote'] = 0;
            $is_voted = $this->Vote->isVoted(1, $this->session->userdata('user_id'), 12, $id_photo);
//            debug($is_voted);
            if ($is_voted == FALSE) {
                $data['enable_vote'] = 1;
            }
        }

        $data['photo_detail'] = $photo_detail;
        $data['active'] = 'hinh-anh';

//        debug($data);
        $this->parser->parse("mobile/chi-tiet-hinh-anh", $data);
    }

    /**
     * @author dungdv3@vng.com.vn
     * Created date: 30/10/2013
     * This action will load page list item video
     * @param type $page: pagination.
     */
    public function danh_sach_video($page) {
        $this->model_name = 'Music';
        $this->load->model('musics/Music');
        $this->paginator['select'] = array('*');

        $this->paginator['where'] = array(
            'musics.status_id' => 1
        );

        $this->paginator['order'] = array('musics.modified' => 'desc');

        $this->paginator['limit'] = 2;

        $uri_segment = 3;
        // get Article Category
        $list_media = $this->pagination($uri_segment);

        $pagination_link = $this->getPaginationCustom('mobile', 'video', '', '', $uri_segment);

        $data = array(
            'pagination_link' => $pagination_link,
            'list_media' => $list_media,
        );
        $data['active'] = 'video';
//        debug($data);
        $this->parser->parse("mobile/danh-sach-video", $data);
    }

    public function chi_tiet_video($id_video) {
        $this->load->model('votes/Vote');
        $this->load->model('musics/Music');

        $this->Music->incrementField(array('id' => $id_video), 'counter_view');

        $option = array(
            'where' => array(
                'id' => $id_video,
                'status_id' => 1
            )
        );
        $video_detail = $this->Music->find('all', $option);

        $data['enable_vote'] = -1;
        if ($this->session->userdata('user_id')) {
            $data['enable_vote'] = 0;
            $is_voted = $this->Vote->isVoted(1, $this->session->userdata('user_id'), 10, $id_video);
//            debug($is_voted);
            if ($is_voted == FALSE) {
                $data['enable_vote'] = 1;
            }
        }

        $data['video_detail'] = $video_detail;
        $data['active'] = 'video';
//        debug($data);
        $this->parser->parse("mobile/chi-tiet-video", $data);
    }

    public function vote() {
        $this->load->model('votes/Vote');
        $this->layout->disable_layout();
        $data = array(
            'status' => 0, //false
            'message' => ''
        );
        if (!isset($_POST['token']) || $_POST['token'] == "") {
            $data['message'] = 'Token does not exit';
        } else {
            $param = check_voting_params($_POST['token']);
//            debug($param);
            if ($param == false) {
                $data['message'] = 'Token is wrong';
            } else {
                switch ($param['resource_name']) {
                    case 'music':
                        $data['message'] = 'Vote false';

                        $is_voted = $this->Vote->isVoted(1, $this->session->userdata('user_id'), 10, $param['record_id']);
                        if (!$is_voted) {
                            $is_created = $this->Vote->create(array(
                                'record_id' => $param['record_id'],
                                'point' => $param['point'],
                                'type_id' => 1,
                                'resource_id' => 10,
                                'username' => $this->session->userdata('user_username'),
                                'user_id' => $this->session->userdata('user_id')
                            ));
                            if ($is_created) {
                                $this->load->model('musics/Music');
                                $this->Music->incrementField(array('id' => $param['record_id']), $param['field_update_count']);
                                $data['status'] = 1;
                                $data['message'] = 'Vote success';
                            }
                        }
                        break;
                    case 'photo':
                        $data['message'] = 'Vote false';

                        $is_voted = $this->Vote->isVoted(1, $this->session->userdata('user_id'), 12, $param['record_id']);
                        if (!$is_voted) {
                            $is_created = $this->Vote->create(array(
                                'record_id' => $param['record_id'],
                                'point' => $param['point'],
                                'type_id' => 1,
                                'resource_id' => 12,
                                'username' => $this->session->userdata('user_username'),
                                'user_id' => $this->session->userdata('user_id')
                            ));
                            if ($is_created) {
                                $this->load->model('photos/Photo');
                                $this->Photo->incrementField(array('id' => $param['record_id']), $param['field_update_count']);
                                $data['status'] = 1;
                                $data['message'] = 'Vote success';
                            }
                        }
                        break;
                }
            }
        }
        echo (json_encode($data));
    }

}
