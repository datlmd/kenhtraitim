<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(FPENGUIN . APPPATH . 'third_party/gapi-1.3/gapi.class.php'); 

class CI_Ga
{
    public $ga;
    private $id;

    function __construct($params = array())
    {
        $this->id = isset($params[2]) ? $params[2] : '';
        
        $username = isset($params[0]) ? $params[0] : '';
        $password = isset($params[1]) ? $params[1] : '';
        
        $this->ga = new gapi( $username, $password);

    }
    
    /**
     * Get time audio 
     * 
     * ['playtime_seconds']
     * ['bitrate'] / 1000
     */
    function get_report($request_arrays, $start_date = FALSE, $end_date = FALSE)
    {
        $start_date = $start_date ? date("Y-m-d", strtotime($start_date)) : FALSE;
        $end_date = $end_date ? date("Y-m-d", strtotime($end_date)) : FALSE;
       
        $this->ga->requestReportData($this->id,array('browser','browserVersion'),$request_arrays, $sort_metric=null, $filter=null, $start_date=$start_date, $end_date=$end_date);
        
        
        return $this->ga->getMetrics();
    }
    
    function get_daily_report($start_date = FALSE, $end_date = FALSE)
    {
        $start_date = $start_date ? date("Y-m-d", strtotime($start_date)) : FALSE;
        $end_date = $end_date ? date("Y-m-d", strtotime($end_date)) : FALSE;
 
        $this->ga->requestReportData($this->id,array('date'), array('pageviews', 'visits', 'visitors', 'newVisits' ,  'uniquePageviews'), $sort_metric='date', $filter=null, $start_date=$start_date, $end_date=$end_date, 1, $max_results=1000);
               
        return array('metrics' => $this->ga->getMetrics(), 'results' => $this->ga->getResults());
    }
    
}
