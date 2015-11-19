<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Controller Admin_photos
 * ...
 * 
 * @package PenguinFW
 * @subpackage Photo
 * @version 1.0.0
 * 
 * @property Photo @Photo
 * @property Photo_album $Photo_album
 * @property Photo_category $Photo_category
 */
 
class Admin_photos extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->layout->set_layout('admin');
        
        $this->model_name = 'Photo';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('photos', lang_web());
            
        $this->load->model('Photo');
        $this->load->model('Photo_album');
        $this->load->model('Photo_category');
    }
    
    function index($cfn_id = 0) {
    	// check permission
    	$this->PG_ACL('r');
    
    	// set title
    	$this->layout->set_title(lang('Photo manager'));
    
    	// get data
    	$data = $this->_listView('index', $cfn_id);
    
        
        $data['total_records'] = $this->count_record;
        
    	$this->parser->parse($this->router->class . '/index', $data);
    }
    
	function report($cfn_id = 0) {
    	// check permission
    	$this->PG_ACL('r');
    
    	// set title
    	$this->layout->set_title(lang('Report manager'));
    	
    	// set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
            'shadowbox/shadowbox.js',
            'shadowbox/init.js',
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css',
            'js' => 'shadowbox/shadowbox.css'
        )); 
        
		$where = array(); 
    	 
    	// filter created from date
    	$filter_from_date = $this->input->get('from_date');
    	if ($filter_from_date)
    	{
    		$where['created >= '] = standar_date($filter_from_date, '-', '-') . ' 00:00:00';
    	}
    	 
    	// filter created end date
    	$filter_to_date = $this->input->get('to_date');
    	if ($filter_to_date)
    	{
    		$where['created <= '] = standar_date($filter_to_date, '-', '-') . ' 23:59:59';
    	}
    	
    	$this->load->model('musics/Music_singer');
    	$where_singer_act = $where;
    	$where_singer_act['status_id'] = 1;
		$count_singer_act = $this->Music_singer->find('count', array(
        		'select' => '*',        		
        		'where' => $where_singer_act,    			
        	));
        $where_singer_not = $where;
    	$where_singer_not['status_id'] = 0;
		$count_singer_not = $this->Music_singer->find('count', array(
        		'select' => '*',        		
        		'where' => $where_singer_not,    			
        	));
        $where_singer_hide = $where;
    	$where_singer_hide['status_id'] = -1;
		$count_singer_hide = $this->Music_singer->find('count', array(
        		'select' => '*',        		
        		'where' => $where_singer_hide,    			
        	));
    	
        $this->load->model('votes/Vote');    	
		$count_vote = $this->Vote->find('count', array(
        		'select' => '*',        		
        		'where' => $where,    			
        	));
        $count_vote_sms = $this->Vote->find('count', array(
        		'select' => '*',        		
        		'where' => $where,    			
        	));
        	
        $this->load->model('users/User');    	
		$count_user = $this->User->find('count', array(
        		'select' => '*',        		
        		'where' => $where,    			
        	));
        	
        $this->load->model('comments/Comment');
    	$where_comment_act = $where;
    	$where_comment_act['status_id'] = 1;
		$count_comment_act = $this->Comment->find('count', array(
        		'select' => '*',        		
        		'where' => $where_comment_act,    			
        	));
        $where_comment_not = $where;
    	$where_comment_not['status_id'] = 0;
		$count_comment_not = $this->Comment->find('count', array(
        		'select' => '*',        		
        		'where' => $where_comment_not,    			
        	));
        $where_comment_hide = $where;
    	$where_comment_hide['status_id'] = -1;
		$count_comment_hide = $this->Comment->find('count', array(
        		'select' => '*',        		
        		'where' => $where_comment_hide,    			
        	));
    	
    	// get data
    	$data = array(
    		'count_singer_act' => $count_singer_act,
    		'count_singer_not' => $count_singer_not,
    		'count_singer_hide' => $count_singer_hide,
    		'count_vote' => $count_vote,
    		'count_vote_sms' => $count_vote_sms,
    		'count_user' => $count_user,
    		'count_comment_act' => $count_comment_act,
    		'count_comment_not' => $count_comment_not,
    		'count_comment_hide' => $count_comment_hide,
    	);
    
    	$this->parser->parse($this->router->class . '/report', $data);
    }
    
    private function _listView($action = 'index', $cfn_id = 0) {
        // set javascript to view
        $this->layout->set_javascript(array(
            'jquery.ui.core.min.js',
            'jquery.ui.datepicker.min.js',
            'shadowbox/shadowbox.js',
            'shadowbox/init.js',
        ));

        // set css to view
        $this->layout->set_rel(array(
            'jquery.ui.base.css',
            'jquery.ui.datepicker.css',
            'js' => 'shadowbox/shadowbox.css'
        ));                
    
    	// filter photos
    	// filter photo status id
    	$filter_photo_status_id = $this->input->get('photo_status_id');
    	if (is_numeric($filter_photo_status_id)) {
    		$this->paginator['where']['photo_status_id'] = $filter_photo_status_id;
    	}
        
        // filter photo album id
    	$filter_photo_album_id = $this->input->get('photo_album_id');
    	if (is_numeric($filter_photo_album_id)) {
    		$this->paginator['where']['photo_album_id'] = $filter_photo_album_id;
    	}
    
    	// filter created from date
    	$filter_from_date = $this->input->get('from_date');
    	if ($filter_from_date) {
    		$this->paginator['where']['DATE(created) >='] = standar_date($filter_from_date, '-', '-');
    	}
    
    	// filter created end date
    	$filter_to_date = $this->input->get('to_date');
    	if ($filter_to_date) {
    		$this->paginator['where']['DATE(created) <='] = standar_date($filter_to_date, '-', '-');
    	}
    
    	// filter photo category id
    	$filter_photo_category_id = $this->input->get('photo_category_id');
    	if ($filter_photo_category_id) {
    		$this->paginator['where']['photo_category_id'] = $filter_photo_category_id;
    	}
    	
    // filter photo category id
    	$filter_user_id = $this->input->get('user_id');
    	if ($filter_user_id) {
    		$this->paginator['where']['user_id'] = $filter_user_id;
    	}
    	 
    	// filter name
    	$filter_name = $this->input->get('name');
    	if ($filter_name) {
    		$this->paginator['like']['name'] = $filter_name;
    	}

    	// only show user not in recycle bin
    	// check action is recyclebin
    	if ($action == 'recyclebin') {
    		$this->paginator['where']['is_delete'] = 1;
    	}
    	else { // action is index
    		$this->paginator['where']['is_delete'] = 0;
    	}
    
    	// get Photo
        $this->paginator['order']['photo_status_id'] = "ASC";
        
         //export data
        if($action == "export")
        {
            $this->paginator['select'] = 'id, name, description, slug, photo_album_id, image_name, counter_comment';     
            $this->paginator['limit'] = 999999999;
            return $this->pagination(5);
        }
        
    	$photos = $this->pagination(5);

        //get extra params
        $extra_params = get_extra_params_from_url();
    
    	// set data view
    	return array(
                            'list_views' => $photos,                        
                            'cfn_id' => $cfn_id,
                            'photo_status_ids' => $this->_getPhotoStatus(),
                            'photo_album_ids' => $this->getAlbums($filter_photo_category_id),
                            'categories' => $this->Photo_category->getTreeCategories(),
                            'this_resource' => $this->router->class,
                            'cf_names' => $this->getCustomFieldName(NULL, FALSE),
                            'fields' => $this->getCustomField($this->session->userdata('user_id'), $cfn_id, NULL, FALSE),
                            'link_edit' => array(
                                'View' => 'photos/admin_photos/view/',
    							'Edit' => 'photos/admin_photos/edit/'
    	),
                            'pagination_link' => $this->getPaginationLink('/photos/admin_photos/' . $action . '/' . $cfn_id, 5, $extra_params)
    	);
    }
    
    public function export()
    {
        $contents = array();

        $contents = $this->_listView("export");
  
        if(empty($contents))
        {

            $contents[0] = array('Data' => 'No record');
        }
        else
        {
            for($i = 0; $i < count($contents); $i++)
            {
                if($contents[$i]['image_name'])
                    $contents[$i]['image_name'] = base_url('media/images') . '/' .  $contents[$i]['image_name'];
            }
        }    
    
        $this->load->library('Write_exel');
        $this->write_exel->write($contents, SITE_NAME . '_' . date('Y_m_d_H'));
        exit();
    }
    
    /**
    *
    * Add Photo Album
    */
    public function add($photo_category_id = 0, $photo_album_id = 0) {
    	// check permission
    	$this->PG_ACL('w');
    
    	// set javascript to view
    	$this->layout->set_javascript(array(
    	                	            'jquery.ui.core.min.js',
    	                	            'jquery.ui.datepicker.min.js',
    									'jquery.alerts.js',
    									'ajaxupload.js',
    	    	                    	'photos/upload.js',
    		));
    	
    	// set css to view
    	$this->layout->set_rel(array(
    	            'jquery.alerts.css'
    		));
    	
    	// set title
    	$this->layout->set_title(lang('Add Photo'));
    
    	// load library form
    	$this->load->helper('form');
    	$this->load->library('form_validation');
    
    	// form validate
    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
    	$this->form_validation->set_rules('photo_category_id', 'Photo Category', 'required|greater_than[0]');
    	$this->form_validation->set_rules('photo_album_id', 'Photo Album', 'required|greater_than[0]');
    	$this->form_validation->set_rules('image_name', 'Photo Image', 'trim|required');
        $this->form_validation->set_rules('description', 'Photo Description', 'trim');
        $this->form_validation->set_rules('image_link', 'Photo Image Link', 'trim');
        $this->form_validation->set_rules('image_link', 'Photo Image Link', 'trim');
        $this->form_validation->set_rules('photo_status_id', 'Photo Status Id', 'trim|required');
  
    	// get post and check rule
    	if ($this->input->post() && $this->form_validation->run() == TRUE) {
    		if ( ! $slug = $this->input->post('slug')) {
    			$_POST['slug'] = $this->input->post('name');
    		}
    
    		$_POST['slug'] = make_slug($_POST['slug']);
    		$_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
    		$_POST['username'] = $this->session->userdata('user_username');
    		
    		// save data
    		if ($this->Photo->create($this->input->post(), TRUE)) {
    			if ($this->input->post('photo_status_id') == 1) {
    				$this->_incrementCounterPhoto($this->input->post('photo_category_id'), $this->input->post('photo_album_id'));
    			}
    			
    			$this->session->set_flashdata('success_message', lang('Success'));
    		}
    		else {
    			$this->session->set_flashdata('error_message', lang('Error'));
    		}
    
    		// redirect
    		redirect('photos/admin_photos');
    	}
    
    	// data to view
    	$data = array(
					'photo_status_ids' => $this->_getPhotoStatus(),
					'categories' => $this->Photo_category->getTreeCategories(),
					'albums' => $this->getAlbums($photo_category_id),
					'selected_category_id' => array($photo_category_id),
					'selected_album_id' => $photo_album_id,
    	);
    
    	// parser
    	$this->parser->parse($this->router->class . '/add', $data);
    }
    
    public function _createWatermark($fileName) {
		//$config['image_library'] = 'gd2';
		$config['source_image'] = $fileName;
		$config['wm_type'] = 'overlay';
        $config['wm_opacity'] = '70';
        $config['wm_overlay_path'] = './static/default/frontend/images/logo-f-idol.png';
//		$config['wm_text'] = 'f-idolhtrht';
//		$config['wm_type'] = 'text';
//		$config['wm_font_path'] = './system/fonts/texb.ttf';
//		$config['wm_font_size'] = '60';
//		$config['wm_font_color'] = 'ffffff';
		$config['wm_vrt_alignment'] = 'bottom';
		$config['wm_hor_alignment'] = 'right';
		$config['wm_padding'] = '-20';
		
		$this->image_lib->initialize($config);
		//echo $config['source_image'];
		if(!$this->image_lib->watermark())
		echo $this->image_lib->display_errors();
	} 
    
        /**
     * Get source image and crop to desired ratio
     * 
     * @access public
     * @param string    $source    : source image (must be path relative to base_url)
     * @param numeric    $width : source image width in px
     * @param numeric    $height : source image height in px
     * @param numeric    $x : long side ratio element - defaults to 4 (as in 4:3)
     * @param numeric    $y : short side ratio element - defaults to 3 (as in 4:3)
     * @param string    $dest : destination (path relative to base_url)  - if not set source will be replaced
     * @return
     */
    function crop_to_ratio($source, $width, $height, $x = 0, $y = 0, $dest = FALSE) {
//        $targ_w = $width;
//        $targ_h = $height;
//        $jpeg_quality = 90;
//
//        $src = './media/images/' . $source;
//        $img_r = imagecreatefromjpeg($src);
//        $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
//
//        imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
////	var_dump($dest);die();
////		header('Content-type: image/jpeg');
//        imagejpeg($dst_r, $dest, $jpeg_quality);

        $targ_w = $width;
        $targ_h = $height;
        $jpeg_quality = 100;

        $src = './media/images/' . $source;
        //$img_r = imagecreatefromjpeg($src);
        $img_r = null;
        $size = getimagesize($src);
        switch ($size["mime"]) {
            case "image/jpeg":
                $img_r = imagecreatefromjpeg($src); //jpeg file
                break;
            case "image/gif":
                $img_r = imagecreatefromgif($src); //gif file
                break;
            case "image/png":
                $img_r = imagecreatefrompng($src); //png file
                break;
            default:
                $img_r = false;
                break;
        }
        $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

        imagecopyresampled($dst_r, $img_r, 0, 0, $_GET['x'], $_GET['y'], $targ_w, $targ_h, $_GET['w'], $_GET['h']);

        //header('Content-type: image/jpeg');
        imagejpeg($dst_r, $dest, $jpeg_quality);
    }

    function crop_to_img($source, $width, $height, $x = 0, $y = 0, $dest = FALSE) {
        $targ_w = $width;
        $targ_h = $height;
        $jpeg_quality = 90;

        $src = './media/images/' . $source;
        $img_r = imagecreatefromjpeg($src);
        $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

        imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);

        //header('Content-type: image/jpeg');
        imagejpeg($dst_r, $dest, $jpeg_quality);
    }

    /**
     * EDIT Photo
     *
     * @param int $photo_id
     */
    public function edit($photo_id = 0) {
        // check permission
        $this->PG_ACL('e');

        // set title
        $this->layout->set_title(lang('Edit Photo'));

        // set script
        $this->layout->set_javascript(array(
            'shadowbox/shadowbox.js',
            'shadowbox/init.js',
            'jquery.alerts.js',
            'ajaxupload.js',
            'photos/upload.js',
            'crop/jquery.Jcrop.js'
        ));

        // set style
        $this->layout->set_rel(array(
            'js' => 'shadowbox/shadowbox.css',
            'jquery.alerts.css',
            'js' => 'crop/jquery.Jcrop.css'
        ));

        // load library form
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validate
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('photo_category_id', 'Photo Category', 'required|greater_than[0]');
        $this->form_validation->set_rules('photo_album_id', 'Photo Album', 'required|greater_than[0]');
        $this->form_validation->set_rules('image_name', 'Photo Image', 'trim|required');
        $this->form_validation->set_rules('description', 'Photo Description', 'trim');
        $this->form_validation->set_rules('image_link', 'Photo Image Link', 'trim');
        $this->form_validation->set_rules('image_link', 'Photo Image Link', 'trim');
        $this->form_validation->set_rules('photo_status_id', 'Photo Status Id', 'trim|required');

        // get post and check rule
        if ($this->input->post() && $this->form_validation->run() == TRUE) {
            if (!$slug = $this->input->post('slug')) {
                $_POST['slug'] = $this->input->post('name');
            }

            $_POST['slug'] = make_slug($_POST['slug']);

            $this->load->library('image_lib');
            //$this->_createWatermark($_POST['image_name']);
            $img = explode('.', $_POST['image_name']);
            $src_crop = './media/images/' . $img[0] . '_crop_crop.' . $img[1];
            $this->crop_to_img($_POST['image_name'], $_POST['w'], $_POST['h'], $_POST['x'], $_POST['y'], $src_crop);
            //$this->_createWatermark($src_crop);
            unset($_POST['w']);
            unset($_POST['h']);
            unset($_POST['x']);
            unset($_POST['y']);
            unset($_POST['x2']);
            unset($_POST['y2']);
            // get original photo
            $original_photo = $this->Photo->get_array('*', array('id' => $photo_id));

            // save data
            if ($this->Photo->update($this->input->post(), array('id' => $photo_id), TRUE)) {
                // change status of photo
                // from enable to disable
                if ($original_photo['photo_status_id'] > $this->input->post('photo_status_id')) {
                    // decrease counter
                    $this->_decrementCounterPhoto($original_photo['photo_category_id'], $original_photo['photo_album_id']);
                }
                // from disable to enable
                elseif ($original_photo['photo_status_id'] < $this->input->post('photo_status_id')) {
                    $this->_incrementCounterPhoto($this->input->post('photo_category_id'), $this->input->post('photo_album_id'));
                } else {
                    // move approved photo to new category OR new album
                    if ($original_photo['photo_category_id'] != $this->input->post('photo_category_id') || $original_photo['photo_album_id'] != $this->input->post('photo_album_id')) {
                        // increase photo counter in new category
                        $this->_incrementCounterPhoto($this->input->post('photo_category_id'), $this->input->post('photo_album_id'));
                        // decrease album counter in old category
                        $this->_decrementCounterPhoto($original_photo['photo_category_id'], $original_photo['photo_album_id']);
                    }
                }

                $this->session->set_flashdata('success_message', lang('Success'));
            } else {
                $this->session->set_flashdata('error_message', lang('Error'));
            }

            // redirect
            redirect('photos/admin_photos');
        }

        // get photo
        $photo = $this->Photo->get_array('*', array('id' => $photo_id));

        // data to view
        $data = array(
            'edit_module' => $photo,
            'photo_status_ids' => $this->_getPhotoStatus(),
            'comment_ids' => $this->_getValueIs(),
            'categories' => $this->Photo_category->getTreeCategories(),
            'albums' => $this->getAlbums($photo['photo_category_id']),
            'hot_ids' => $this->_getValueIs(),
        );
        //debug($data);
        // parser
        $this->parser->parse($this->router->class . '/edit', $data);
    }

    /**
    *
    * View Photo
    * @param int $photo_id
    */
    public function view($photo_id = 0)
    {
    	// check permission
    	$this->PG_ACL('r');
    
    	// set script
        $this->layout->set_javascript(array(
            'shadowbox/shadowbox.js',
            'shadowbox/init.js'
        ));

        // set style
        $this->layout->set_rel(array(
            'js' => 'shadowbox/shadowbox.css'
        ));
    	
    	// set title
    	$this->layout->set_title(lang('View photo'));
    
    	// get user data from database
    	$photo = $this->Photo->find('first', array(
    						'select' => 'photos.*, photo_albums.name as photo_album_name',
    						'leftjoin' => array(
    								'photo_albums' => 'photo_albums.id = photos.photo_album_id',
    							),
                            'where' => array('photos.id' => $photo_id)
    	));
    
    	// Get parent category
    	if ( ! $photo->photo_category_id) {
    		$photo->parent_name = lang('No Parent');
    	}
    	else {
    		$photo_category_parent = $this->Photo_category->find('first', array(
                				'select' => 'photo_categories.*',
                		        'from' => 'photo_categories',
                		        'where' => array('photo_categories.id' => $photo->photo_category_id)
    		));
    
    		$photo->parent_name = $photo_category_parent->name;
    	}
    	
    	// Get list status id
    	$photo_status_ids = $this->_getPhotoStatus();
    	
    	// Get delete
    	//$photo_category->delete_name = ($photo_category->is_delete == 1) ? lang('Removed') : lang('No');
    
    	// set data to view
    	$data = array(
					'view_data' => $photo,
					'photo_status_ids' => $this->_getPhotoStatus(),
					'comment_ids' => $this->_getValueIs(),
    		);
    
    	// parser
    	$this->parser->parse($this->router->class . '/view', $data);
    }
    
    public function getAlbums($photo_category_id, $is_ajax = FALSE) {
    	$photo_category_id = intval($photo_category_id);
        $albums_out_put = array();
        $albums = array();

        //Mặc định form edit truyền qua số 0 cho chọn album
        if($photo_category_id == 0)
        {

        }
        else if($photo_category_id == "all" || $photo_category_id == 0)
        {
            $tempt_all[0] = array('id' => '', 'name' => 'All');

            $albums = $this->Photo_album->find('all', array(
                'select' => 'id, name'
            ));

            $albums_out_put = array_merge($tempt_all, $albums);
        }
        else
        {
            $tempt_all[0] = array('id' => '', 'name' => 'All');
            $albums = $this->Photo_album->find('all', array(
                    'select' => 'id, name',
                    'where' => array('photo_category_id' => $photo_category_id),
            ));

            $albums_out_put = array_merge($tempt_all, $albums);
        }

    	if ($is_ajax) {
    		print_r(json_encode($albums_out_put));
    		exit();
    	}
    	return $albums_out_put;
    }

    public function getAlbumsForAddFunction($photo_category_id, $is_ajax = FALSE) {
        $photo_category_id = intval($photo_category_id);
        $albums = array();
        $albums = $this->Photo_album->find('all', array(
            'select' => 'id, name',
            'where' => array('photo_category_id' => $photo_category_id),
        ));

        if ($is_ajax) {
            print_r(json_encode($albums));
            exit();
        }
        return $albums;
    }
    
    private function _decrementCounterPhoto($category_id, $album_id) {
    	if ( ! empty($category_id)) {
    		// increase photo counter in category
    		$this->Photo_category->decrementField(array('id' => $category_id), 'counter_photo');
    	}
    	 
    	if ( ! empty($album_id)) {
    		// increase photo counter in album
    		$this->Photo_album->decrementField(array('id' => $album_id), 'counter_photo');
    	}
    }
    
    private function _incrementCounterPhoto($category_id, $album_id) {
    	if ( ! empty($category_id)) {
    		// increase photo counter in category
    		$this->Photo_category->incrementField(array('id' => $category_id), 'counter_photo');
    	}
    	
    	if ( ! empty($album_id)) {
    		// increase photo counter in album
    		$this->Photo_album->incrementField(array('id' => $album_id), 'counter_photo');
    	}
    }
    
    /**
    * Delete on list view
    */
    public function delete() {
    	if ($this->input->post()) {
    
    		$list_ids = $this->input->post('listViewId');
    		$publish_type = $this->input->post('publish_type');
    
    		if ( ! empty($list_ids)) {
    			if ($publish_type == 1) {
    				// is_publish
    				// check permission
    				$this->PG_ACL('p');
    					
    				foreach ($list_ids as $id) {
    					$this->_publish($id);
    				}
    			}
    			elseif ($publish_type == -1) {
    				// un publish
    				// check permission
    				$this->PG_ACL('p');
    					
    				foreach ($list_ids as $id) {
    					$this->_publish($id, FALSE);
    				}
    			}
    			else {
    				// is delete
    				// check permission
    				$this->PG_ACL('d');
    					
    				foreach ($list_ids as $id) {
    					$this->_delete($id);
    				}
    			} // end
    		}
    	}
    
    	if ($this->input->post('p_redirect')) {
    		redirect($this->input->post('p_redirect'));
    	}
    	else {
    		redirect('photos/admin_photos');
    	}
    }
    
    /**
     *
     * delete photo
     * @param integer $id
     */
    private function _delete($id) {
    	$record = $this->Photo->get_array('*', array('id' => $id));
    
    	if (!$record) {
    		return FALSE;
    	}
    	
    	// decrease album counter
    	if ($record['photo_status_id']) {
    		$this->_decrementCounterPhoto($record['photo_category_id'], $record['photo_album_id']);
    	}
    
    	$this->Photo->deleteRecord(array('id' => $id));
    }
    
    /**
     * chang status
     *
     * @param int $id
     * @param boolean $is_publish
     * @return boolean
     */
    private function _publish($id, $is_publish = TRUE) {
    	$record = $this->Photo->get_array('*', array('id' => $id));
    
    	if (!$record) {
    		return FALSE;
    	}
    
    	$status = '';
    	if ($is_publish) {
    		// increase album counter
    		if ( ! $record['photo_status_id']) {
    			$this->_incrementCounterPhoto($record['photo_category_id'], $record['photo_album_id']);
    		}
    		
    		$status = ConstPhotosStatus::Approved;
    	}
    	else {
    		// decrease album counter
    		if ($record['photo_status_id']) {
    			$this->_decrementCounterPhoto($record['photo_category_id'], $record['photo_album_id']);
    		}
    		
    		$status = ConstPhotosStatus::Rejected;
    	}
    
    	$this->Photo->update(array('photo_status_id' => $status), array('id' => $id));
    }
    
    /**
    *
    * List value of IS
    * array 0 => No
    * 		1 => Yes
    */
    private function _getValueIs() {
    	return array(0 => lang('No'), 1 => lang('Yes'));
    }
    
    /**
    *
    * Get photo status
    * @return array
    */
    private function _getPhotoStatus() {
    	return array(
	    	array('id' => 0, 'name' => 'Pending'),
	    	array('id' => 1, 'name' => 'Approved'),
	    	array('id' => 2, 'name' => 'Rejected'),
    	);
    }
}
                
?>