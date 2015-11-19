<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Export data to exel
 * 
 * @package PenguinFW
 * @subpackage Report
 * @version 1.0.0
 */
ini_set('include_path', FPENGUIN . 'application/third_party/PEAR/' . PATH_SEPARATOR . ini_get('include_path'));
require_once "Spreadsheet/Excel/Reader.php";

class Read_exel
{
    private $workbook;
    
    function __construct()
    {
        $this->workbook = new Spreadsheet_Excel_Reader();
        // Set output Encoding.
        $this->workbook->setOutputEncoding('UTF-8');
        // if you want you can change 'iconv' to mb_convert_encoding:
        $this->workbook->setUTFEncoder('mb');
        // By default rows & cols indeces start with 1
        // For change initial index use:
        $this->workbook->setRowColOffset(0);
        // Some function for formatting output.
        $this->workbook->setDefaultFormat('%.2f');
        // setDefaultFormat - set format for columns with unknown formatting
        
        $this->workbook->setColumnFormat(4, '%.3f');
        //setColumnFormat - set format for column (apply only to number fields);
    }
    
    /*


 $data->sheets[0]['numRows'] - count rows
 $data->sheets[0]['numCols'] - count columns
 $data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column

 $data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell
    
    $data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
        if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
    $data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format 
    $data->sheets[0]['cellsInfo'][$i][$j]['colspan'] 
    $data->sheets[0]['cellsInfo'][$i][$j]['rowspan'] 
*/
    public function read($filepath, $has_header = FALSE, $index_col_name = '')
    {
    	$this->workbook->read($filepath);
    	
    	// Init
    	$result = $col_name = array();
    	$start_row = 0;
    	
    	
    	// have header
    	if ($has_header) {
    		$start_row = 1;
    		$num_col_empty_name = 0;
    		
    		for ($j = 0; $j < $this->workbook->sheets[0]['numCols']; $j++) {
    			$name = trim($this->workbook->sheets[0]['cells'][0][$j]);
    			// if column no name, increase one variable to assign col name
    			if ( ! $name) {
    				$name = $num_col_empty_name++;
    			}
    			$col_name[] = $name;
    		}
    	}
    	
    	for ($i = $start_row; $i < $this->workbook->sheets[0]['numRows']; $i++) {
    		// Init
    		$row = array();
    		
    		for ($j = 0; $j < $this->workbook->sheets[0]['numCols']; $j++) {
    			$value = $this->workbook->sheets[0]['cells'][$i][$j];
    			$key = ($has_header) ? $col_name[$j] : $j;
    			
    			$row[$key] = $value;
    		}
    		
    		// get one column to make key
    		if ($index_col_name && $index_col_name != '') {
    			$result[$row[$index_col_name]] = $row;
    		}
    		else {
    			$result[] = $row;
    		}
    	}
    	
    	return $result;
    }
}

?>
