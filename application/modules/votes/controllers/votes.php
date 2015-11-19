<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Votes
 * ...
 * 
 * @package PenguinFW
 * @subpackage Vote
 * @version 1.0.0
 * 
 * @property Vote       $Vote
 * @property Vote_type  $Vote_type
 */
class Votes extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        $this->model_name = 'Vote';

        $this->lang->load('generate', lang_web());
        $this->lang->load('votes', lang_web());

        $this->load->model('Vote');

    }

    /**
     * Add vote
     */
    public function add()
    {
        // check permission
        if (!$this->isACL('w'))
        {
            $result = array(
                'status' => 'error',
                'message' => lang('You can not vote for this record. Please contact to administator')
            );
            echo json_encode($result);
            exit();
        }

        // set layout
        $this->layout->set_layout('empty');

        // lib
        $this->load->helper('strhash');
        $this->load->model('Vote_type');

        // vote
        if ($this->input->post())
        {
            // check captcha
            if (!$this->_checkCaptcha())
            {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => lang('Captcha is not match')
                ));
                exit();
            }

            // check infomation
            if (!$this->_checkInfomation())
            {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => lang('You must complete your infomation')
                ));
                exit();
            }

            // get hash params
            $params_hash = $this->input->post('vparams');
            $params_string = string_hash($params_hash, FALSE);

            if ($params_string)
            {
                // record_id|resource_name|type_id|token|field_update_count
                $params = @explode('|', $params_string);

                if (is_array($params))
                {
                    $record_id = (isset($params[0]) && $params[0]) ? $params[0] : 0;

                    $resource_name = (isset($params[1]) && $params[1]) ? $params[1] : NULL;
                    // get resource_id
                    if ($resource_name)
                    {
                        $resource_id = $this->getResourceID($resource_name);
                    }

                    $type_id = (isset($params[2]) && $params[2]) ? $params[2] : 0;

                    $token = (isset($params[3]) && $params[3]) ? $params[3] : NULL;

                    $field_update_count = (isset($params[4]) && $params[4]) ? $params[4] : NULL;

                    if ($record_id && $resource_id && $type_id && $token)
                    {
                        $user_id = $this->session->userdata('user_id');
                        $ip = $this->input->ip_address();
                        $point = $this->Vote_type->getPoint($type_id);


                        if ($this->Vote->addVote($user_id, $record_id, $point, $type_id, $resource_id, $ip, $field_update_count))
                        {
                            $result = array(
                                'status' => 'success',
                                'message' => lang('You voted success')
                            );
                            echo json_encode($result);
                            exit();
                        } else
                        {
                            $result = array(
                                'status' => 'error',
                                'message' => lang('You can not vote now. Please wait')
                            );
                            echo json_encode($result);
                            exit();
                        }
                    }
                } //// check params
            } //// get params
        } // // vote post data

        $result = array(
            'status' => 'error',
            'message' => lang('Vote is error. Please try again')
        );
        echo json_encode($result);
        exit();

    }

    /**
     * Add vote
     */
    public function add_vote_music()
    {
        if (!$this->session->userdata('user_username'))
        {
            $user_info = FALSE;
        } else
        {
            $user_info = array(
                'username' => $this->session->userdata('user_username'),
                'user_id' => $this->session->userdata('user_id')
            );
        }


        // check permission
        if (!$user_info)
        {
            $result = array(
                'status' => 'error',
                'message' => lang('Hãy đăng nhập để vote!')
            );
            echo json_encode($result);
            exit();
        }

        // set layout
        $this->layout->set_layout('empty');

        // lib
        $this->load->helper('strhash');
        $this->load->model('Vote_type');

        // vote
        if ($this->input->post())
        {

            // get hash params
            $params_hash = $this->input->post('vparams');
            $params_string = string_hash($params_hash, FALSE);

            if ($params_string)
            {
                // record_id|resource_name|type_id|token|field_update_count
                $params = @explode('|', $params_string);
               
                if (is_array($params))
                {
                    
                    $record_id = (isset($params[0]) && $params[0]) ? $params[0] : 0;
                    
                    if($record_id == 0)
                    {
                        //check id in post
                        if($this->input->post('id'))
                        {
                            $record_id = (int)$this->input->post('id');
                        }
                    }
                
                    $resource_name = (isset($params[1]) && $params[1]) ? $params[1] : NULL;
                    // get resource_id
                    if ($resource_name)
                    {
                        $resource_id = $this->getResourceID($resource_name);
                    }

                    $type_id = (isset($params[2]) && $params[2]) ? $params[2] : 0;

                    $token = (isset($params[3]) && $params[3]) ? $params[3] : NULL;

                    $field_update_count = (isset($params[4]) && $params[4]) ? $params[4] : NULL;

                    if ($record_id && $resource_id && $type_id && $token)
                    {
                        //$user_id = $this->session->userdata('user_id');
                        $user_id = $user_info['user_id'];
                      
                        $ip = $this->input->ip_address();
                        $point = $this->Vote_type->getPoint($type_id);
                      
                        if ($this->Vote->addVote($user_id, $record_id, $point, $type_id, $resource_id, $ip, $field_update_count))
                        {
                            
                            $result = array(
                                'status' => 'success',
                                'message' => lang('Cảm ơn bạn đã bình chọn!'),
                                'point' => $point
                            );
                            echo json_encode($result);
                            exit();
                            
                        } else
                        {
                            $result = array(
                                'status' => 'error',
                                'message' => lang('Bạn không được bình chọn nhiều lần trong thời gian ngắn. <br/> Hãy đợi ít phút và bình chọn lại nhé!')
                            );
                            echo json_encode($result);
                            exit();
                        }
                    }
                } //// check params
            } //// get params
        } // // vote post data

        $result = array(
            'status' => 'error',
            'message' => lang('Không vote được. Vui lòng thử lại sau!')
        );
        echo json_encode($result);
        exit();

    }
    
    /**
     * @thangtpp
     * Add vote for model
     */
    public function add_vote_model()
    {
        if (!$this->session->userdata('user_username'))
        {
            $user_info = FALSE;
        } else
        {
            $user_info = array(
                'username' => $this->session->userdata('user_username'),
                'user_id' => $this->session->userdata('user_id')
            );
        }


        // check permission
        if (!$user_info)
        {
            $result = array(
                'status' => 'error',
                'message' => lang('Hãy đăng nhập để vote!')
            );
            echo json_encode($result);
            exit();
        }

        // set layout
        $this->layout->set_layout('empty');

        // lib
        $this->load->helper('strhash');
        $this->load->model('Vote_type');

        // vote
        if ($this->input->post())
        {

            // get hash params
            $params_hash = $this->input->post('vparams');
            $params_string = string_hash($params_hash, FALSE);

            if ($params_string)
            {
                // record_id|resource_name|type_id|token|field_update_count
                $params = @explode('|', $params_string);
               
                if (is_array($params))
                {
                    
                    $record_id = (isset($params[0]) && $params[0]) ? $params[0] : 0;
                    
                    if($record_id == 0)
                    {
                        //check id in post
                        if($this->input->post('id'))
                        {
                            $record_id = (int)$this->input->post('id');
                        }
                    }
                
                    $resource_name = (isset($params[1]) && $params[1]) ? $params[1] : NULL;
                    // get resource_id
                    if ($resource_name)
                    {
                        $resource_id = $this->getResourceID($resource_name);
                    }

                    $type_id = (isset($params[2]) && $params[2]) ? $params[2] : 0;

                    $token = (isset($params[3]) && $params[3]) ? $params[3] : NULL;

                    $field_update_count = (isset($params[4]) && $params[4]) ? $params[4] : NULL;
                    
                    $event_id = (isset($params[5]) && $params[5]) ? $params[5] : 0;

                    if ($record_id && $resource_id && $type_id && $token && $event_id)
                    {
                        //$user_id = $this->session->userdata('user_id');
                        $user_id = $user_info['user_id'];
                      
                        $ip = getRealIp();
                        $point = $this->Vote_type->getPoint($type_id);
                      
                        $add_vote = $this->Vote->addVote($user_id, $record_id, $point, $type_id, $resource_id, $ip, $field_update_count, $event_id);
                        
                        if ($add_vote['success'] == '1')
                        {
                            
                            $result = array(
                                'status' => 'success',
                                'message' => lang($add_vote['msg']),
                                'point' => $point
                            );
                            echo json_encode($result);
                            exit();
                            
                        } else
                        {
                            $result = array(
                                'status' => 'error',
                                'message' => lang($add_vote['msg']),
                            );
                            echo json_encode($result);
                            exit();
                        }
                    }
                } //// check params
            } //// get params
        } // // vote post data

        $result = array(
            'status' => 'error',
            'message' => lang('Không vote được. Vui lòng thử lại sau!')
        );
        echo json_encode($result);
        exit();

    }

    /**
     * @author TungCN
     *
     * Add vote
     */
	public function add_voting() {
		//$_SESSION['user']['username'] = 'datlm13';
    	// load helper
    	$this->load->helper('strhash');
    	$redirect_link = (isset($_POST["return_vote"]) && !empty($_POST["return_vote"])) ? $_POST["return_vote"] : get_link('frontend', '', 'index');
    	$user_info = ( !isset($_SESSION['user']) && empty($_SESSION['user'])) ? NULL : $_SESSION['user'];
    	    	
    	// check permission
    	if ( !$user_info) {
    		$result = array(
                    'status' => 'error',
                    'message' => lang('Vui lòng đăng nhập trước khi Bình chọn!')
    		);
    		$this->session->set_flashdata('error_message', lang('Vui lòng đăng nhập trước khi Bình luận!'));
    		redirect($redirect_link);
    		//echo json_encode($result);
    		exit();
    	}
    
    	// set layout
    	$this->layout->set_layout('empty');
    
    	// lib
    	$this->load->model('Vote_type');
    
    	// vote
    	if ($this->input->post()) {
    		// check captcha
    		/*if (!$this->_checkCaptcha()) {
    			echo json_encode(array(
                        'status' => 'error',
                        'message' => lang('Captcha is not match')
    			));
    			exit();
    		}*/
    		
    		// get hash params
    		$params_hash = $this->input->post('vparams');
    		$voteNumber = $this->input->post('voteNumber');
    		
	    	if(!isset($voteNumber) || empty($voteNumber))
	    	{
	    		$this->session->set_flashdata('error_message', lang('Vui lòng nhập số người tham gia Vote giống bạn!!'));
	    		redirect($redirect_link);
	    		//echo json_encode($result);
	    		exit();
	    	}
    		
    		$params_string = string_hash($params_hash, FALSE);
    
    		if ($params_string) {
    			
    			// record_id|resource_name|type_id|token|field_update_count
    			$params = json_decode($params_string, TRUE);
    
    			if (is_array($params)) {
    				$data_add['record_id'] = $params['record_id'];
    				$data_add['resource_name'] = $params['resource_name'];
    				// get resource_id
    				if ($data_add['resource_name']) {
    					$data_add['resource_id'] = $this->getResourceID($data_add['resource_name']);
    				}
    				
    				$token = $params['voting_token'];
    				
    				$data_add['type_id'] = $params['type_id'];
    				$data_add['field_update_count'] = $params['field_update_count'];
    				$data_add['point'] = $params['point'];
    				
    				if ($data_add['record_id'] && $data_add['resource_id'] && $token) {
    					
    					//$data_add['user_id'] = $user_info['passportID'];
    					$data_add['username'] = $user_info['username'];
    					$data_add['total_same'] = $voteNumber;
    					$data_add['user_ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'];//$_SERVER['REMOTE_ADDR'];//$_SERVER['HTTP_X_FORWARDED_FOR'];
    					
    					// load model
    					$vote_user = $this->Vote->get_array('*', array('username' => $user_info['username'], 'record_id' => $data_add['record_id'], 'resource_id' => $data_add['resource_id']));
    					
    					if ($vote_user) {
//    						echo json_encode(array(
//    							'status' => 'error',
//    							'message' => lang('Bạn đã Bình chọn cho bài viết này rồi!')
//    						));
    						$this->session->set_flashdata('warning_message', lang('Bạn đã Bình chọn cho bài viết này rồi!'));
    						redirect($redirect_link);
    						exit();
    					}
    					
    					if ($this->Vote->create($data_add, TRUE)) {    		
    						if ($data_add['field_update_count']) {
    							// explode field_update_count to array
    							//$data_add['field_update_count'] = explode('|', $data_add['field_update_count']);
    							
    							//if($data_add['resource_id']==42 || $data_add['resource_id']==48)
    								$this->Vote->addVoteCount($data_add['resource_id'], $data_add['record_id'], $data_add['type_id'], $data_add['field_update_count']);
    							
    							$result = array(
    								'status' => 'success',
    								'message' => lang('Đã Bình chọn thành công!')
    							);
    							
    							$this->session->set_userdata('captcha', '');
    							
    							$this->session->set_flashdata('success_message', lang('Đã Bình chọn thành công!'));
    							redirect($redirect_link);
    							//echo json_encode($result);
    							exit();
    						}
    					}
    				}
    			} //// check params
    		} //// get params
    	} // // vote post data
    
    	$result = array(
                'status' => 'error',
                'message' => lang('Bình chọn thất bại. Vui lòng thử lại!')
    	);
    	$this->session->set_flashdata('error_message', lang('Bình chọn thất bại. Vui lòng thử lại!'));
    	redirect($redirect_link);
    	//echo json_encode($result);
    	exit();
	}

    /**
     * Add vote
     */
    public function subtract()
    {
        // check permission
        if (!$this->isACL('w'))
        {
            $result = array(
                'status' => 'error',
                'message' => lang('You can not vote for this record. Please contact to administator')
            );
            echo json_encode($result);
            exit();
        }

        // set layout
        $this->layout->set_layout('empty');

        // lib
        $this->load->helper('strhash');
        $this->load->model('Vote_type');

        // vote
        if ($this->input->post())
        {
            $params_hash = $this->input->post('vparams');
            $params_string = string_hash($params_hash, FALSE);

            if ($params_string)
            {
                $params = @explode('|', $params_string);

                if (is_array($params))
                {
                    $record_id = (isset($params[0]) && $params[0]) ? $params[0] : 0;
                    $resource_id = (isset($params[1]) && $params[1]) ? $params[1] : 0;
                    $type_id = (isset($params[2]) && $params[2]) ? $params[2] : 0;
                    $field_update_count = (isset($params[3]) && $params[3]) ? $params[3] : NULL;

                    if ($record_id && $resource_id && $type_id)
                    {
                        $user_id = $this->session->userdata('user_id');
                        $ip = $this->input->ip_address();
                        $point = 0;

                        $vote_id = $this->Vote->isVoted($type_id, $user_id, $resource_id, $record_id);

                        if ($this->Vote_type->isDislike($type_id))
                        {
                            if ($vote_id)
                            {
                                if ($this->Vote->changToDislike($vote_id, $resource_id, $record_id, $type_id, $field_update_count))
                                {
                                    $result = array(
                                        'status' => 'success',
                                        'message' => lang('You disliked success')
                                    );
                                    echo json_encode($result);
                                    exit();
                                } else
                                {
                                    $result = array(
                                        'status' => 'error',
                                        'message' => lang('You can dislike now. Please wait')
                                    );
                                    echo json_encode($result);
                                    exit();
                                }
                            } else
                            {
                                if ($this->Vote->addVote($user_id, $record_id, $point, $type_id, $resource_id, $ip, $field_update_count))
                                {
                                    $result = array(
                                        'status' => 'success',
                                        'message' => lang('You disliked success')
                                    );
                                    echo json_encode($result);
                                    exit();
                                } else
                                {
                                    $result = array(
                                        'status' => 'error',
                                        'message' => lang('You can dislike now. Please wait')
                                    );
                                    echo json_encode($result);
                                    exit();
                                }
                            }
                        } else
                        {
                            if ($this->Vote->deleteVote($vote_id, $resource_id, $record_id, $type_id))
                            {
                                $result = array(
                                    'status' => 'success',
                                    'message' => lang('You disliked success')
                                );
                                echo json_encode($result);
                                exit();
                            } else
                            {
                                $result = array(
                                    'status' => 'error',
                                    'message' => lang('You can dislike now. Please wait')
                                );
                                echo json_encode($result);
                                exit();
                            }
                        }
                    } // check params
                } //// check params
            } //// get params
        } // // vote post data

        $result = array(
            'status' => 'error',
            'message' => lang('Dislike is error. Please try again')
        );
        echo json_encode($result);
        exit();

    }

    /**
     * check captcha before vote
     */
    private function _checkCaptcha()
    {
        // check administrator config
        if (config_item('vote_check_captcha') == 1)
        {
            // get captcha
            $captcha = $this->input->post('vote_captcha');

            // check captcha and session
            if ($captcha && $captcha == $this->session->userdata('vote_captcha'))
            {
                return TRUE;
            }

            return FALSE;
        }

        return TRUE;

    }

    /**
     * check infomation before vote
     */
    private function _checkInfomation()
    {
        // check administrator config
        if (config_item('vote_check_infomation') == 1)
        {
            // get user id
            $user_id = $this->session->userdata('user_id');

            // check user in infomation            
            return TRUE;
        }

        return TRUE;

    }

}

?>