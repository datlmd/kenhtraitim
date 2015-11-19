<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* * *
 * XML library for CodeIgniter
 *
 * author: Woody Gilk
 * copyright: (c) 2006
 * license: http://creativecommons.org/licenses/by-sa/2.5/
 * file: libraries/Xml.php
 */

class Xml
{

    private $document;
    private $filename;

    function __construct()
    {
        
    }

    /**
     * Load file xml
     * 
     * @param string $file
     * @return boolean
     */
    public function load($file)
    {
        /**
         * @public
         * Load an file for parsing
         */
        $bad = array('|//+|', '|\.\./|');
        $good = array('/', '');
        $file = APPPATH . preg_replace($bad, $good, $file) . '.xml';

        if (!file_exists($file))
        {
            return false;
        }

        $this->document = utf8_encode(file_get_contents($file));
        $this->filename = $file;

        return true;
    }    

    /**
     * parse xml
     * @return type 
     */
    public function parse()
    {
        /**
         * @public
         * Parse an XML document into an array
         */
        $xml = $this->document;
        if ($xml == '')
        {
            return false;
        }

        $doc = new DOMDocument ();
        $doc->preserveWhiteSpace = false;
        if ($doc->loadXML($xml))
        {
            $array = $this->flatten_node($doc);
            if (count($array) > 0)
            {
                return $array;
            }
        }

        return false;
    }

    /**
     * flatten node
     * 
     * @param Object $node
     * @return array 
     */
    private function flatten_node($node)
    {
        /**
         * @private
         * Helper function to flatten an XML document into an array
         */

        $array = array();

        foreach ($node->childNodes as $child)
        {
            if ($child->hasChildNodes())
            {
                if ($node->firstChild->nodeName == $node->lastChild->nodeName && $node->childNodes->length > 1)
                {
                    $array[$child->nodeName][] = $this->flatten_node($child);
                } else
                {
                    $array[$child->nodeName][] = $this->flatten_node($child);

                    if ($child->hasAttributes())
                    {
                        $index = count($array[$child->nodeName]) - 1;
                        $attrs = & $array[$child->nodeName][$index]['__attrs'];
                        foreach ($child->attributes as $attribute)
                        {
                            $attrs[$attribute->name] = $attribute->value;
                        }
                    }
                }
            } else
            {
                return $child->nodeValue;
            }
        }

        return $array;
    }

    /**
     * @author TungCN
     * modified date 2011-11-21 15:30
     * 
     * @param array $data
     * @param array $config_options
     * @return string serialized XML
     */
    public function convert_array_to_xml($data, $config_options = NULL)
    {
        if (!$data)
        {
            return NULL;
        }

        // Set error reporting to ignore notices
        error_reporting(0);

        ini_set('include_path', FPENGUIN . 'application/third_party/PEAR/' . PATH_SEPARATOR . ini_get('include_path'));

        // Include XML_Serializer
        require_once 'XML/Serializer.php';

        // An array of serializer options
        $serializer_options = array(
            'addDecl' => TRUE,
            'encoding' => "ISO-8859-1",
            'indent' => "\t",
            'rootName' => "root",
            'defaultTagName' => "items",
        );

        if (is_array($config_options) && count($config_options) > 0)
        {
            foreach ($config_options as $option_key => $option_value)
            {
                $serializer_options[$option_key] = $option_value;
            }
        }

        // Instantiate the serializer with the options
        $Serializer = new XML_Serializer($serializer_options);

        // Serialize the data structure
        $status = $Serializer->serialize($data);

        // Check whether serialization worked
        if (PEAR::isError($status))
        {

            die($status->getMessage());
        }

		// define header is xml
		header ("content-type: text/xml");
		
        // Display the XML document
        return $Serializer->getSerializedData();
    }

}

?>