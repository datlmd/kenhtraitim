<?php
class Session {
    private $_socket = null;
    private $_transport = null;
    private $_protocol = null;
    private $_client_read = null;
    private $_session = null;
    private $_sessionId = null;

    public function __construct($options) {
        $this->_socket = new TSocket($options['host'], $options['port']);
        $this->_transport = new TFramedTransport($this->_socket);
        $this->_protocol = new TBinaryProtocolAccelerated($this->_transport);
        $this->_client_read = new SessionServiceReadClient($this->_protocol);     
    }

    public function read($zauth) {
        $this->openTransport();
        return $this->_client_read ->GetSession($zauth);
    }

    public function openTransport()
    {
        if(!$this->_transport->isOpen())
            $this->_transport->open();
       
    }
    public function  __destruct() {
        if($this->_transport->isOpen())
            $this->_transport->close();
    }
    public function GetSessionWithCheckIP($sessionId, $clientIp){
        $this->openTransport();
        return $this->_client_read ->GetSessionWithCheckIP($sessionId, $clientIp);
    }
    public function GetSessionWithCheckIPBrowser($sessionId, $clientIp, $useragent){
        $this->openTransport();
        return $this->_client_read ->GetSessionWithCheckIPBrowser($sessionId, $clientIp, $useragent);
    }
    public function GetSessionWithCheckBrowser($sessionId, $useragent){
        $this->openTransport();
        return $this->_client_read ->GetSessionWithCheckBrowser($sessionId, $useragent);
    }
}

?>
