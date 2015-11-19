<?php
class Admin_article_filemanager extends MY_Controller {
	private $error = array();
	
	function __construct()
	{
		parent::__construct();
	
		$this->layout->set_layout('empty');
	
		$this->model_name = 'Article';
	
		$this->lang->load('generate', lang_web());
		$this->lang->load('articles', lang_web());
	
		$this->load->model('Article_category');
		$this->load->model('Article');
		$this->load->model('Article_dictionary');
		$this->load->model('Article_category_relationship');
		$this->load->model('Language');
		
		// helper
		$this->load->helper('utf8');
	}
	
	public function index() {
		
		$this->layout->set_title(lang('File Manager'));
		
// 		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
// 			$this->data['base'] = HTTPS_SERVER;
// 		} else {
// 			$this->data['base'] = HTTP_SERVER;
// 		}
		
// 		$this->data['token'] = $this->session->data['token'];
		
		$get_field = $this->input->get('field');
		if (isset($get_field)) {
			$field = $get_field;
		} else {
			$field = '';
		}
		
		$get_CKEditorFuncNum = $this->input->get('CKEditorFuncNum');
		if (isset($get_CKEditorFuncNum)) {
			$fckeditor = $get_CKEditorFuncNum;
		} else {
			$fckeditor = false;
		}
				
		$data = array(
			'field' => $field,
			'fckeditor' => $fckeditor,
			'directory' => img_url() . 'media/filemanager/',
		);
	
		$this->parser->parse('admin_articles/filemanager', $data);
	}	
	
	public function image() {
		$this->load->model('tool/image');
		
		if (isset($this->request->get['image'])) {
			$this->response->setOutput($this->model_tool_image->resize(html_entity_decode($this->request->get['image'], ENT_QUOTES, 'UTF-8'), 100, 100));
		}
	}
	
	public function directory() {	
		$json = array();
		
		$post_directory = $this->input->post('directory');
		$post_directory = ($post_directory === '0') ? '' : $post_directory;
		
		if (1 || isset($post_directory)) {
			$directories = glob(rtrim(DIR_MEDIA_ARTICLE_PHOTOS . str_replace('../', '', $post_directory), '/') . '/*', GLOB_ONLYDIR); 
			
			if ($directories) {
				$i = 0;
			
				foreach ($directories as $directory) {
					$json[$i]['data'] = basename($directory);
					$json[$i]['attributes']['directory'] = $json[$i]['attributes']['id'] = utf8_substr($directory, strlen(DIR_MEDIA_ARTICLE_PHOTOS));
					
					$children = glob(rtrim($directory, '/') . '/*', GLOB_ONLYDIR);
					
					if ($children)  {
						$json[$i]['children'] = ' ';
					}
					
					$i++;
				}
			}		
		}
		
		echo json_encode($json);
		die();		
	}
	
	public function files() {
		$json = array();
		
		$post_directory = $this->input->post('directory');
		if (!empty($post_directory)) {
			$directory = DIR_MEDIA_ARTICLE_PHOTOS. str_replace('../', '', $post_directory);
		} else {
			$directory = DIR_MEDIA_ARTICLE_PHOTOS;
		}
		
		$allowed = array(
			'.jpg',
			'.jpeg',
			'.png',
			'.gif'
		);
		
		$files = glob(rtrim($directory, '/') . '/*');
		
		// Sort files by modified time, latest to earliest
		array_multisort(
				array_map('filemtime', $files),
	    		SORT_NUMERIC,
	    		SORT_DESC,
	    		$files
			);
		
		if ($files) {
			foreach ($files as $file) {
				if (is_file($file)) {
					$ext = strrchr($file, '.');
				} else {
					$ext = '';
				}	
				
				if (in_array(strtolower($ext), $allowed)) {
					$size = filesize($file);
		
					$i = 0;
		
					$suffix = array(
						'B',
						'KB',
						'MB',
						'GB',
						'TB',
						'PB',
						'EB',
						'ZB',
						'YB'
					);
		
					while (($size / 1024) > 1) {
						$size = $size / 1024;
						$i++;
					}
						
					$json[] = array(
						'file'     => utf8_substr($file, strlen(DIR_MEDIA_ARTICLE_PHOTOS)),
						'filename' => basename($file),
						'size'     => round(utf8_substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i],
						//'thumb'    => $this->model_tool_image->resize(utf8_substr($file, strlen(DIR_MEDIA_ARTICLE_PHOTOS)), 100, 100)
						'thumb'	   => img_url() . 'media/filemanager/' . utf8_substr($file, strlen(DIR_MEDIA_ARTICLE_PHOTOS)),
					);
				}
			}
		}
		
		echo json_encode($json);
		die();	
	}	
	
	public function create() {
		$json = array();
		
		$post_directory = $this->input->post('directory');
		
		if (isset($post_directory)) {
			
			$post_name = $this->input->post('name');
			
			if (isset($post_name) || $post_name) {
				$directory = rtrim(DIR_MEDIA_ARTICLE_PHOTOS . str_replace('../', '', $post_directory), '/');							   
				
				if (!is_dir($directory)) {
					$json['error'] = lang('error directory');
				}
				
				if (file_exists($directory . '/' . str_replace('../', '', $post_name))) {
					$json['error'] = lang('error directory exists');
				}
			} else {
				$json['error'] = lang('error directory name');
			}
		} else {
			$json['error'] = lang('error directory');
		}
		
		if (!isset($json['error'])) {	
			mkdir($directory . '/' . str_replace('../', '', $post_name), 0777);
			
			$json['success'] = lang('directory create successfully.');
		}	
		
		echo json_encode($json);
		die();
	}
	
	public function delete() {
		$json = array();
		
		$post_path = $this->input->post('path');
		if (isset($post_path)) {
			$path = rtrim(DIR_MEDIA_ARTICLE_PHOTOS . str_replace('../', '', html_entity_decode($post_path, ENT_QUOTES, 'UTF-8')), '/');
			 
			if (!file_exists($path)) {
				$json['error'] = lang('error_select');
			}
			
			if (is_dir($path)) {
				$files = glob(rtrim($path, '/') . '/*');
				
				if ($files) {
					$json['error'] = lang('directory contains files. Cannot delete.');
				}
			}
			
			if ($path == rtrim(DIR_MEDIA_ARTICLE_PHOTOS, '/')) {
				$json['error'] = lang('error_delete');
			}
		} else {
			$json['error'] = lang('error_select');
		}
		
// 		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
//       		$json['error'] = $this->language->get('error_permission');  
//     	}
		
		if ( ! isset($json['error'])) {
			if (is_file($path)) {
				unlink($path);
			} elseif (is_dir($path)) {
				$this->recursiveDelete($path);
			}
			
			$json['success'] = lang('text_delete');
		}				
		
		echo json_encode($json);
		die();
	}

	protected function recursiveDelete($directory) {
		if (is_dir($directory)) {
			$handle = opendir($directory);
		}
		
		if (!$handle) {
			return false;
		}
		
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				if (!is_dir($directory . '/' . $file)) {
					unlink($directory . '/' . $file);
				} else {
					$this->recursiveDelete($directory . '/' . $file);
				}
			}
		}
		
		closedir($handle);
		
		rmdir($directory);
		
		return true;
	}

	public function move() {
		$this->load->language('common/filemanager');
		
		$json = array();
		
		if (isset($this->request->post['from']) && isset($this->request->post['to'])) {
			$from = rtrim(DIR_MEDIA_ARTICLE_PHOTOS . 'data/' . str_replace('../', '', html_entity_decode($this->request->post['from'], ENT_QUOTES, 'UTF-8')), '/');
			
			if (!file_exists($from)) {
				$json['error'] = $this->language->get('error_missing');
			}
			
			if ($from == DIR_MEDIA_ARTICLE_PHOTOS . 'data') {
				$json['error'] = $this->language->get('error_default');
			}
			
			$to = rtrim(DIR_MEDIA_ARTICLE_PHOTOS . 'data/' . str_replace('../', '', html_entity_decode($this->request->post['to'], ENT_QUOTES, 'UTF-8')), '/');

			if (!file_exists($to)) {
				$json['error'] = $this->language->get('error_move');
			}	
			
			if (file_exists($to . '/' . basename($from))) {
				$json['error'] = $this->language->get('error_exists');
			}
		} else {
			$json['error'] = $this->language->get('error_directory');
		}
		
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
      		$json['error'] = $this->language->get('error_permission');  
    	}
		
		if (!isset($json['error'])) {
			rename($from, $to . '/' . basename($from));
			
			$json['success'] = $this->language->get('text_move');
		}
		
		$this->response->setOutput(json_encode($json));
	}	
	
	public function copy() {
		$this->load->language('common/filemanager');
		
		$json = array();
		
		if (isset($this->request->post['path']) && isset($this->request->post['name'])) {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 255)) {
				$json['error'] = $this->language->get('error_filename');
			}
				
			$old_name = rtrim(DIR_MEDIA_ARTICLE_PHOTOS . 'data/' . str_replace('../', '', html_entity_decode($this->request->post['path'], ENT_QUOTES, 'UTF-8')), '/');
			
			if (!file_exists($old_name) || $old_name == DIR_MEDIA_ARTICLE_PHOTOS . 'data') {
				$json['error'] = $this->language->get('error_copy');
			}
			
			if (is_file($old_name)) {
				$ext = strrchr($old_name, '.');
			} else {
				$ext = '';
			}		
			
			$new_name = dirname($old_name) . '/' . str_replace('../', '', html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8') . $ext);
																			   
			if (file_exists($new_name)) {
				$json['error'] = $this->language->get('error_exists');
			}			
		} else {
			$json['error'] = $this->language->get('error_select');
		}
		
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
      		$json['error'] = $this->language->get('error_permission');  
    	}	
		
		if (!isset($json['error'])) {
			if (is_file($old_name)) {
				copy($old_name, $new_name);
			} else {
				$this->recursiveCopy($old_name, $new_name);
			}
			
			$json['success'] = $this->language->get('text_copy');
		}
		
		$this->response->setOutput(json_encode($json));	
	}

	function recursiveCopy($source, $destination) { 
		$directory = opendir($source); 
		
		@mkdir($destination); 
		
		while (false !== ($file = readdir($directory))) {
			if (($file != '.') && ($file != '..')) { 
				if (is_dir($source . '/' . $file)) { 
					$this->recursiveCopy($source . '/' . $file, $destination . '/' . $file); 
				} else { 
					copy($source . '/' . $file, $destination . '/' . $file); 
				} 
			} 
		} 
		
		closedir($directory); 
	} 

	public function folders() {
		$this->response->setOutput($this->recursiveFolders(DIR_MEDIA_ARTICLE_PHOTOS . 'data/'));	
	}
	
	protected function recursiveFolders($directory) {
		$output = '';
		
		$output .= '<option value="' . utf8_substr($directory, strlen(DIR_MEDIA_ARTICLE_PHOTOS . 'data/')) . '">' . utf8_substr($directory, strlen(DIR_MEDIA_ARTICLE_PHOTOS . 'data/')) . '</option>';
		
		$directories = glob(rtrim(str_replace('../', '', $directory), '/') . '/*', GLOB_ONLYDIR);
		
		foreach ($directories  as $directory) {
			$output .= $this->recursiveFolders($directory);
		}
		
		return $output;
	}
	
	public function rename() {
		$this->load->language('common/filemanager');
		
		$json = array();
		
		if (isset($this->request->post['path']) && isset($this->request->post['name'])) {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 255)) {
				$json['error'] = $this->language->get('error_filename');
			}
				
			$old_name = rtrim(DIR_MEDIA_ARTICLE_PHOTOS . 'data/' . str_replace('../', '', html_entity_decode($this->request->post['path'], ENT_QUOTES, 'UTF-8')), '/');
			
			if (!file_exists($old_name) || $old_name == DIR_MEDIA_ARTICLE_PHOTOS . 'data') {
				$json['error'] = $this->language->get('error_rename');
			}
			
			if (is_file($old_name)) {
				$ext = strrchr($old_name, '.');
			} else {
				$ext = '';
			}		
			
			$new_name = dirname($old_name) . '/' . str_replace('../', '', html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8') . $ext);
																			   
			if (file_exists($new_name)) {
				$json['error'] = $this->language->get('error_exists');
			}			
		}
		
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
      		$json['error'] = $this->language->get('error_permission');  
    	}
		
		if (!isset($json['error'])) {
			rename($old_name, $new_name);
			
			$json['success'] = $this->language->get('text_rename');
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function upload() {
		
		$directory = $this->input->post('directory');
		
		$json = array();
		
		$upload_path = rtrim('filemanager/' . $directory, '/');
		
		// upload
		$upload = upload_file('image', $upload_path, config_item('articles_image_type'), config_item('articles_image_size'), config_item('articles_image_max_width'), config_item('articles_image_max_height'),  FALSE);
		
		if ($upload['error'] == 1)
		{
			$json['error'] = $upload['message'];
		} else
		{
			$file = $upload['file'];
		
			$resize_config = array(
					'create_thumb' => FALSE,
					'width' => config_item('articles_image_resize_width'),
					'height' => config_item('articles_image_resize_height'),
				);
			
			resize_image($file['full_path'], $resize_config);
		
			$json['success'] = lang('File upload successfully.');
		}
		echo json_encode($json);
		die();
	}
} 
?>