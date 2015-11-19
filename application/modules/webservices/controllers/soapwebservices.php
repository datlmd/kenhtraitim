<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <tungcn2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Controller Soapwebservices
 * ...
 * 
 * @package PenguinFW
 * @subpackage Soap webservices
 * @version 1.0.0
 */
class Soapwebservices extends MY_Controller {

    private $status_code;
    private $service_method;
    private $service_module = '';
    private $service_action = '';
    private $service_params = array();

    function __construct() {
        parent::__construct();

        $this->model_name = 'Webservice';

        $this->layout->disable_layout();

        $this->lang->load('generate', lang_web());
        $this->lang->load('webservices', lang_web());

        $this->load->model('Webservice');
    }

    /**
     * check authenticate
     *
     * @return int
     */
    private function _checkAuth() {
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

        // check authenticate params
        if (!$public_key || !$username || !$secret_key || !$service) {
            return 203;
        }

        // check user
        $webservice = $this->Webservice->get(array(
            'username' => $username,
            'public_key' => $public_key,
            'secret_key' => $secret_key,
            'service' => $service
        ));

        if (!$webservice) {
            return 401;
        }

        // check ip
        if (strpos($webservice->allow_ip, $ip) === FALSE) {
            return 1001;
        }

        // check service
        if ($webservice->service != $service) {
            return 403;
        }

        // get  module/action
        if (strpos($service, '__') !== FALSE) {
            $service_tmp = explode('__', $service);

            $this->service_module = $service_tmp[0];
            $this->service_action = $service_tmp[1];
        } else {
            return 405;
        }

        // get method code
        $this->service_method = $webservice->type;

        // get params
        if ($params) {
            $this->service_params = @json_decode(base64_decode($params), TRUE);
        }

        return 100;
    }

    function execute($service_module) {
        // data default
        $data = array('status' => $this->status_code);

        $service_class = "Soap_$service_module";

        //$path = APPPATH . "modules/$service_module/models/$service_class.php";
        $path = APPPATH . "modules/$service_module/controllers/" . strtolower($service_class) . ".php";
        require_once $path;

        if (!file_exists($path)) {
            show_404();
        }

        /*
         * this assume your webservice class is located in the soap directory of your app
         * and named myclass.php
         */
        ini_set("soap.wsdl_cache_enabled", 0);
        if ($service_class) {
            if (isset($_GET['wsdl'])) {
                $this->load->library('zend', 'Zend/Soap/AutoDiscover');

                $wsdl = new Zend_Soap_AutoDiscover();
                $wsdl->setClass($service_class);
                $wsdl->handle();
            } else {
                $this->load->library('zend', 'Zend/Soap/Server');

                $szWSDLUrl = get_link('webservices', 'soapwebservices', 'execute', $service_module . '?wsdl');
                //$szWSDLUrl = 'http://test.f-idol.vn/RecieverMOZingModel.asmx';
                $options = array('soap_version' => SOAP_1_2);
                $server = new Zend_Soap_Server($szWSDLUrl);
                $server->setClass($service_class);
                $server->handle();
            }
        } else {
            show_404();
        }
    }

    /**
     * This action register the soap service by nusoap 
     * This will call by request http://localhost/penguin_lite_g3/webservices/soapwebservices/nusoap_service?wsdl
     * @author dungdv3@vng.com.vn
     */
    public function nusoap_service() {
        $this->layout->disable_layout();
        $this->load->library("Nusoap_library"); // load nusoap toolkit library in controller
        $server = new soap_server(); // create soap server object
        $addressService = 'http://tempuri.org/';
        $server->configureWSDL('MonoWebService', $addressService);
        $server->register('ReceiveMO', //method name
                array(
            'moid' => 'xsd:string',
            'src' => 'xsd:string',
            'dest' => 'xsd:string',
            'moseq' => 'xsd:string',
            'cmdcode' => 'xsd:string',
            'msgbody' => 'xsd:string',
            'username' => 'xsd:string',
            'password' => 'xsd:string'), array('ReceiveMOResult' => 'xsd:int'), false, false, "rpc", "encoded");

        function ReceiveMO($moid, $moseq, $src, $dest, $cmdcode, $msgbody, $username, $password) {
            if ($username != 'gapit' || $password != 'gapit') {
                return 403;
            }
            if (0 > 1) { //CHECK MO exist
                return 401;
            }

            $temp_mtseq = date('Ymdhis');
            send_mt($temp_mtseq, '11111', '1234', '01632752182', 'Coca-cola', 'Test', 'text', 'Coca-Cola', '1', '1', '10385', date("d/m/Y h:i:s"), '1', '1');
            return 200;
        }

        $server->service(file_get_contents("php://input"));
    }

    /**
     * This action call to test the soap service is declared above
     * @author dungdv3@vng.com.vn
     */
    public function call_nusoap_service() {
        $this->layout->disable_layout();
        $this->load->library("Nusoap_library");
        $client = new nusoap_client("http://localhost/penguin_lite_g3/frontend/soap_service?wsdl");
        $var = array(
            'moid' => 'string',
            'src' => 'string',
            'dest' => 'string',
            'moseq' => 'string',
            'cmdcode' => 'string',
            'msgbody' => 'string',
            'username' => 'gapit',
            'password' => 'gapit');

        debug($client->call("ReceiveMO", $var));
    }

}

?>