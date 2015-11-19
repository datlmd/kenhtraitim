<?php
/**
 * Autogenerated by Thrift
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 */
include_once $GLOBALS['THRIFT_ROOT'].'/Thrift.php';

include_once $GLOBALS['THRIFT_ROOT'].'/packages/sms/sms_types.php';
include_once $GLOBALS['THRIFT_ROOT'].'/packages/sms/SessionServiceRead.php';

interface SessionServiceWriteIf extends SessionServiceReadIf {
  public function Create($uin, $zing, $account, $localIp, $useragent, $longSession);
  public function Remove($sessionId);
}

class SessionServiceWriteClient extends SessionServiceReadClient implements SessionServiceWriteIf {
  public function __construct($input, $output=null) {
    parent::__construct($input, $output);
  }

  public function Create($uin, $zing, $account, $localIp, $useragent, $longSession)
  {
    $this->send_Create($uin, $zing, $account, $localIp, $useragent, $longSession);
    return $this->recv_Create();
  }

  public function send_Create($uin, $zing, $account, $localIp, $useragent, $longSession)
  {
    $args = new FwSession_SessionServiceWrite_Create_args();
    $args->uin = $uin;
    $args->zing = $zing;
    $args->account = $account;
    $args->localIp = $localIp;
    $args->useragent = $useragent;
    $args->longSession = $longSession;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'Create', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('Create', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_Create()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, 'FwSession_SessionServiceWrite_Create_result', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new FwSession_SessionServiceWrite_Create_result();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("Create failed: unknown result");
  }

  public function Remove($sessionId)
  {
    $this->send_Remove($sessionId);
    return $this->recv_Remove();
  }

  public function send_Remove($sessionId)
  {
    $args = new FwSession_SessionServiceWrite_Remove_args();
    $args->sessionId = $sessionId;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'Remove', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('Remove', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_Remove()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, 'FwSession_SessionServiceWrite_Remove_result', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new FwSession_SessionServiceWrite_Remove_result();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("Remove failed: unknown result");
  }

}

// HELPER FUNCTIONS AND STRUCTURES

class FwSession_SessionServiceWrite_Create_args {
  static $_TSPEC;

  public $uin = null;
  public $zing = null;
  public $account = null;
  public $localIp = null;
  public $useragent = null;
  public $longSession = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'uin',
          'type' => TType::I32,
          ),
        2 => array(
          'var' => 'zing',
          'type' => TType::I32,
          ),
        3 => array(
          'var' => 'account',
          'type' => TType::STRING,
          ),
        4 => array(
          'var' => 'localIp',
          'type' => TType::STRING,
          ),
        5 => array(
          'var' => 'useragent',
          'type' => TType::STRING,
          ),
        6 => array(
          'var' => 'longSession',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['uin'])) {
        $this->uin = $vals['uin'];
      }
      if (isset($vals['zing'])) {
        $this->zing = $vals['zing'];
      }
      if (isset($vals['account'])) {
        $this->account = $vals['account'];
      }
      if (isset($vals['localIp'])) {
        $this->localIp = $vals['localIp'];
      }
      if (isset($vals['useragent'])) {
        $this->useragent = $vals['useragent'];
      }
      if (isset($vals['longSession'])) {
        $this->longSession = $vals['longSession'];
      }
    }
  }

  public function getName() {
    return 'SessionServiceWrite_Create_args';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->uin);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->zing);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->account);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 4:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->localIp);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 5:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->useragent);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 6:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->longSession);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('SessionServiceWrite_Create_args');
    if ($this->uin !== null) {
      $xfer += $output->writeFieldBegin('uin', TType::I32, 1);
      $xfer += $output->writeI32($this->uin);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->zing !== null) {
      $xfer += $output->writeFieldBegin('zing', TType::I32, 2);
      $xfer += $output->writeI32($this->zing);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->account !== null) {
      $xfer += $output->writeFieldBegin('account', TType::STRING, 3);
      $xfer += $output->writeString($this->account);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->localIp !== null) {
      $xfer += $output->writeFieldBegin('localIp', TType::STRING, 4);
      $xfer += $output->writeString($this->localIp);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->useragent !== null) {
      $xfer += $output->writeFieldBegin('useragent', TType::STRING, 5);
      $xfer += $output->writeString($this->useragent);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->longSession !== null) {
      $xfer += $output->writeFieldBegin('longSession', TType::I32, 6);
      $xfer += $output->writeI32($this->longSession);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class FwSession_SessionServiceWrite_Create_result {
  static $_TSPEC;

  public $success = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['success'])) {
        $this->success = $vals['success'];
      }
    }
  }

  public function getName() {
    return 'SessionServiceWrite_Create_result';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 0:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->success);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('SessionServiceWrite_Create_result');
    if ($this->success !== null) {
      $xfer += $output->writeFieldBegin('success', TType::STRING, 0);
      $xfer += $output->writeString($this->success);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class FwSession_SessionServiceWrite_Remove_args {
  static $_TSPEC;

  public $sessionId = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'sessionId',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['sessionId'])) {
        $this->sessionId = $vals['sessionId'];
      }
    }
  }

  public function getName() {
    return 'SessionServiceWrite_Remove_args';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->sessionId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('SessionServiceWrite_Remove_args');
    if ($this->sessionId !== null) {
      $xfer += $output->writeFieldBegin('sessionId', TType::STRING, 1);
      $xfer += $output->writeString($this->sessionId);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class FwSession_SessionServiceWrite_Remove_result {
  static $_TSPEC;

  public $success = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['success'])) {
        $this->success = $vals['success'];
      }
    }
  }

  public function getName() {
    return 'SessionServiceWrite_Remove_result';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 0:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->success);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('SessionServiceWrite_Remove_result');
    if ($this->success !== null) {
      $xfer += $output->writeFieldBegin('success', TType::STRING, 0);
      $xfer += $output->writeString($this->success);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

?>
