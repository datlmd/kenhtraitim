<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Customers
 * ...
 * 
 * @package PenguinFW
 * @subpackage customers
 * @version 1.0.0
 */
 
class Customers extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            
        $this->model_name = 'Customer';
                
        $this->lang->load('generate', lang_web());
        $this->lang->load('customers', lang_web());
            
        $this->load->model('Customer');
        
        $this->layout->set_layout("clear");
    }

    public function register()
    {
       //check enough
       //$this->_check_enough();
        
        $data = NULL;
      
        
        //set title
        $this->layout->set_title("Register");
        
        //load form library
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //set rule
        $this->form_validation->set_rules("name", "Họ tên", "required");
        $this->form_validation->set_rules("gender", "Giới tính", "required");
        //$this->form_validation->set_rules("dob", "Ngày sinh", "required");
        $this->form_validation->set_rules("region", "Địa chỉ", "required");
        $this->form_validation->set_rules("phone", "Điện thoại", "required");
        $this->form_validation->set_rules("email", "Thư điện tử", "required");
        
                
                
        //get post and check rule
        if($this->input->post() && $this->form_validation->run() == TRUE)
        {
            //save data
            $data = $this->input->post();
    
            $data['dob'] = date("Y-m-d", mktime(0, 0, 0, $data['dob_month'], $data['dob_day'], $data['dob_year']));
            $data['ip_address'] = $this->input->ip_address();
            
            unset($data['dob_day']);
            unset($data['dob_month']);
            unset($data['dob_year']);
          
            if($this->Customer->create($data, TRUE))
            {
                //$this->session->set_flashdata("success_");
            }
            
            //send http to service clear
            $this->track_user_joined();
            
            redirect("customers/success");
        }
        else
        {
            //get regions
            $sql = "SELECT id, name
                    FROM regions";
            $query = $this->db->query($sql);
            $data['regions'] = $query->result_array();
            
            
             // check captcha ///////////////////////////////////////////////

                    
                    //create captcha////////////////////////////////////////////
                    $this->load->helper('captcha');

                    $vals = array(
                        'img_path' => FPENGUIN . '/static/captcha/',
                        'img_url' => base_url().'/static/captcha/',
                        'expiration' => 1000

                    );

                    $cap = create_captcha($vals);

                    $cap_data = array(
                        'captcha_time' => $cap['time'],
                        'ip_address' => $this->input->ip_address(),
                        'word' => $cap['word']
                    );

                    $query = $this->db->insert_string('captcha', $cap_data);
                    $this->db->query($query);

                    $data['captcha'] = $cap['image'] ;
               
                    ////////////////////////////////////////////////////////////
        }
 
        $this->parser->parse('add', $data);

    }
    
    private function _check_enough()
    {
        define("GIFT_AMOUNT",  5000);
   

        $sql = "SELECT count(id) as total
                FROM customers";
        
        $query = $this->db->query($sql);
        
        $total = $query->row_array();
        
        if($total['total'] >= GIFT_AMOUNT)
        {
            redirect("customers/announce");
        }
        
    }
    
    public function announce()
    {
         //set title
        $this->layout->set_title("Announce");
        
        $this->parser->parse('announce');
    }
    
    public function success()
    {
  
        //set title
        $this->layout->set_title("Success");
 
        
        $this->parser->parse('success');
    }
    
    public function check_captcha($txt)
    {
        $this->layout->set_layout("empty");
        
                // First, delete old captchas
                $expiration = time() - 7200; // Two hour limit
                $this->db->query("DELETE FROM captcha WHERE captcha_time < " . $expiration);

                // Then see if a captcha exists:
                $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
                $binds = array($txt, $this->input->ip_address(), $expiration);
                $query = $this->db->query($sql, $binds);
                $row = $query->row();

                if ($row->count == 0) {
                    echo 0;                                    
                }
                else
                {
                    echo 1;
                }
                die;
            
    }

}
                
?>