<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Controller Webservices
 * ...
 * 
 * @package PenguinFW
 * @subpackage webservices
 * @version 1.0.0
 * 
 * @property Webservice         $Webservice
 */
class Webservices extends MY_Controller {

    private $status_code;
    private $service_method;
    private $service_module = '';
    private $service_action = '';
    private $service_params = array();

    function __construct()
    {
        parent::__construct();

        $this->model_name = 'Webservice';

        $this->layout->disable_layout();

        $this->lang->load('generate', lang_web());
        $this->lang->load('webservices', lang_web());

        $this->load->model('Webservice');

        $this->status_code = $this->_checkAuth();
    }

    //tempotery
    public function total_submit($event_id = FALSE)
    {
        $this->layout->set_layout("empty");
        $this->load->model('Photos/Photo');
       
        //set params output
        $errors = 0;
        $logs = array();
        $data = NULL;

        if($event_id == FALSE)
        {
            $errors++;
            $logs[] = 'Missing event type';
            $data = NULL;

            echo json_encode(array(
                        'errors' => $errors,
                        'logs' => $logs,
                        'data' => $data)); die;
        }

        $options = array();
        $options['where']['photo_category_id'] = PHOTO_CATEGORY;

        switch($event_id)
        {
            case 'power':
                $options['where']['photo_album_id'] = PHOTO_ALBUM_ID_POWER;
                break;
            case 'entertainment':
                $options['where']['photo_album_id'] = PHOTO_ALBUM_ID_ENTERTAINMENT;
                break;
            case 'style':
                $options['where']['photo_album_id'] = PHOTO_ALBUM_ID_STYLE;
                break;
            case 'all':             
                break;
            default :
                $errors++;
                $logs[] = 'Event type is incorrect';
                $logs[] = 'Guilde types: power, entertainment, style, all';
        }

        if($errors)
        {
            echo json_encode(array(
                        'errors' => $errors,
                        'logs' => $logs,
                        'data' => $data)); die;
        }

        $data = $this->Photo->find('count', $options);
 
        $logs[] = 'Success';
        echo json_encode(array(
                    'errors' => $errors,
                    'logs' => $logs,
                    'data' => $data)); die;
        
    }

    /**
     * Status code and message
     * 
     * @param int $status
     * @return string message code
     */
    public static function getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            1001 => 'Not allow IP'
        );

        return (isset($codes[$status])) ? $codes[$status] : $status;
    }

    /**
     * check authenticate
     * 
     * @return int
     */
    private function _checkAuth()
    {
        $username = $this->input->server('PHP_AUTH_USER');
        $secret_key = $this->input->server('PHP_AUTH_PW');

        // get public key
        $public_key = $this->input->get('api_key');
        // get service
        $service = $this->input->get('service');
        // get params, params in base_64encode from json_encode        
        $params = $this->input->get('params');
        // get ip
        $ip = $this->input->ip_address();

        // check service is public
        if($service && $secret_key && !$username && !$public_key)
        {
            $webservice = $this->get(array(
                'secret_key' => $secret_key,
                'service' => $service
                    ));

            if($webservice && $webservice->is_public == 1)
            {
                // get method code
                $this->service_method = $webservice->type;

                // get params
                if($params)
                {
                    $this->service_params = @json_decode(base64_decode($params), TRUE);
                }

                return 100;
            }
        } // end check service is public
        // check authenticate params
        if(!$public_key || !$username || !$secret_key || !$service)
        {
            return 203;
        }

        // check user
        $webservice = $this->Webservice->get(array(
            'username' => $username,
            'public_key' => $public_key,
            'secret_key' => $secret_key,
            'service' => $service
                ));

        if(!$webservice)
        {
            return 401;
        }

        // check ip
        if($webservice->allow_ip != '*' && strpos($webservice->allow_ip, $ip) === FALSE)
        {
            return 1001;
        }

        // check service
        if($webservice->service != $service)
        {
            return 403;
        }

        // get  module/action
        if(strpos($service, '__') !== FALSE)
        {
            $service_tmp = explode('__', $service);

            $this->service_module = $service_tmp[0];
            $this->service_action = $service_tmp[1];
        }
        else
        {
            return 405;
        }

        // get method code
        $this->service_method = $webservice->type;

        // get params
        if($params)
        {
            $this->service_params = @json_decode(base64_decode($params), TRUE);
        }

        return 100;
    }

    /**
     * process service
     * 
     * @param string $response_type
     */
    public function execute($response_type = 'xml')
    {
        if($this->status_code == 100)
        {
            // load model rest service
            $this->load->model($this->service_module . '/Api_rest');

            // get class service object
            $service_class = $this->Api_rest;

            // data default
            $data = array('status' => $this->status_code);

            // call function 
            $result = call_user_func(array($service_class, $this->service_action), $this->service_params);

            // set status data
            if(!$result || isset($result['error']))
            {
                if($result['error'])
                {
                    $data['status'] = $result['error'];
                }
                else
                {
                    $data['status'] = 204;
                }
            }
            else
            {
                $data = array(
                    'status' => 200,
                    'data' => $result
                );
            }
        }
        else
        {
            $data = array('status' => $this->status_code);
        }

        if($response_type == 'xml')
        {
            // load xml lib
            $this->load->library('xml');
            echo $this->xml->convert_array_to_xml($data);
            exit();
        }
        else if($response_type == 'json')
        {
            echo json_encode($data);
            exit();
        }

        echo 'Error response type';
        exit();
    }

}

?>