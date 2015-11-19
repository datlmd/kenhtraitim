<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Export data to exel
 * 
 * @package PenguinFW
 * @subpackage Report
 * @version 1.0.0
 */
ini_set('include_path', FPENGUIN . 'application/third_party/PEAR/' . PATH_SEPARATOR . ini_get('include_path'));
require_once "Spreadsheet/Excel/Writer.php";

class Write_exel
{
    private $workbook;
    
    function __construct()
    {                        
        $this->workbook = new Spreadsheet_Excel_Writer();
        $this->workbook->setVersion(8);
    }
    
    /**
     * write data to exel
     * 
     * @param array $data
     *  array(
     *      [head1] => array(),
     *      [head2] => array()
     *  )
     * @param string $name 
     */
    public function write($data, $name)
    {
        $worksheet1 = &$this->workbook->addWorksheet($name);
        $worksheet1->setInputEncoding('UTF-8');
        
        $header = &$this->workbook->addFormat();
		$header->setBold();
		$header->setColor('black');
		$header->setFgColor("grey");
		$header->setHAlign('center');
		$header->setBorder(1);
        
        $i = 0;
        foreach ($data[0] as $head => $value)
        {
            $worksheet1->write(0, $i++, get_label($head), $header);
        }
            
        
        $i = 1;
        foreach ($data as $values)
        {
            $j = 0;
            foreach ($values as $value)
            {
                $worksheet1->write($i, $j ++, $value);
            }
            
            $i ++;
        }
        
        $this->workbook->send("$name.xls");
        
        $this->workbook->close();
    }
}

?>
