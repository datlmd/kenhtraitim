<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Layout Class
 *
 * This class manages the view insertion into a layout template
 *
 * @package		Layout
 * @version		1.0
 * @author 		Richard Davey <info@richarddavey.com>
 * @copyright 	Copyright (c) 2011, Richard Davey
 * @link		https://github.com/richarddavey/codeigniter-layout
 */
class Layout
{

    /**
     * Default values
     *
     */
    private $active             = TRUE;
    private $layout             = 'default';
    private $layout_var         = 'content';
    private $layout_title       = 'MainTitle';
    private $layout_image       = 'MainImage';
    private $layout_keyword     = 'MainKeyword';
    private $layout_description = 'MainDescription';
    private $layout_dir         = 'layouts/';
    private $varRel             = 'pgRel';
    private $varJavascript      = 'pgJavascript';
    private $clean_output       = FALSE;
    // config title
    // @author hungtd
    // title set from controller
    private $title              = '';
    private $image              = '';
    private $keyword            = '';
    private $description        = '';
    private $pgRel              = '';
    private $pgJavascript       = '';
    
    private $page_class     = 'Home';
    private $page_id        = 'Home';

    /**
     * Constructor
     *
     * @access	public
     * @param	array	initialization parameters
     */
    public function __construct($params = array())
    {
        if (count($params) > 0)
        {
            $this->initialize($params);
        }

        log_message('debug', "Layout Class Initialized");
    }

    // --------------------------------------------------------------------

    /**
     * Initialize Preferences
     *
     * @access	public
     * @param	array	initialization parameters
     * @return	void
     */
    private function initialize($params = array())
    {
        if (count($params) > 0)
        {
            foreach ($params as $key => $val)
            {
                if (isset($this->$key))
                {
                    $this->$key = $val;
                }
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Getter method for private vars
     *
     * @param 	string
     * @return 	mixed
     */
    public function __get($name)
    {
        // get variable
        return isset($this->$name) ? $this->$name : NULL;
    }

    // --------------------------------------------------------------------

    /**
     * Disable output cleaning
     *
     * @return 	void
     */
    public function disable_clean_output()
    {
        // disable layout
        $this->clean_output = FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * Disable layout
     *
     * @return 	void
     */
    public function disable_layout()
    {
        // disable layout
        $this->active = FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * Enable layout
     *
     * @return	void
     */
    public function enable_layout()
    {
        // enable layout
        $this->active = TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Set layout
     *
     * @param 	string $layout
     * @return 	void
     */
    public function set_layout($layout)
    {
        // set layout
        $this->layout = $layout;
    }

    // --------------------------------------------------------------------

    /**
     * Set layout directory
     *
     * @param 	string $layout_dir
     * @return 	void
     */
    public function set_layout_dir($layout_dir)
    {
        // set layout directory
        $this->layout_dir = $layout_dir;
    }

    // --------------------------------------------------------------------

    /**
     * Output with layout
     *
     * Remove useless whitespace from generated HTML and construct page from
     * template with layout and current set output
     *
     * @return 	void
     */
    public function output()
    {
        // set up CI classes
        $CI = & get_instance();

        // get output
        $buffer = $CI->output->get_output();

        // does layout exist
        if ($CI->layout->active AND $CI->layout->layout AND file_exists(APPPATH . $CI->layout->layout_dir . $CI->layout->layout . '.tpl'))
        {
            // return layout
            $buffer = $CI->parser->parse_layout($CI->layout->layout, array(
                $CI->layout->layout_var             => $buffer,
                $CI->layout->layout_title           => $CI->layout->get_title(),
                $CI->layout->layout_image           => $CI->layout->get_image(),
                $CI->layout->layout_keyword         => $CI->layout->get_keyword(),
                $CI->layout->layout_description     => $CI->layout->get_description(),
                $CI->layout->varRel                 => $CI->layout->get_rel(),
                $CI->layout->varJavascript          => $CI->layout->get_javascript(),
                'layout_page_class'                 => $CI->layout->get_page_class(),
                'layout_page_id'                    => $CI->layout->get_page_id(),
            ));
        }

        // if whitespace compression is needed
        if ($CI->layout->clean_output)
        {
            // search
            $search = array(
                '/\>[^\S \t]+/s', // strip whitespaces after tags, except space and tab
                '/[^\S ]+\</s', // strip whitespaces before tags, except space
                '/(\s)+/s', // shorten multiple whitespace sequences
                '#\/\/\<\!\[CDATA\[[^\S ]+#s' // strip whitespace directly after CDATA
            );

            // replace
            $replace = array(
                '>',
                '<',
                '\\1',
                '//<![CDATA['
            );

            // run search and replace
            $buffer = preg_replace($search, $replace, $buffer);

            // resolve cdata content
            $buffer = str_replace('//<![CDATA[', '//<![CDATA[' . PHP_EOL, $buffer);
        }

        // set output
        $CI->output->set_output($buffer);

        // display output
        $CI->output->_display();
    }

    /**
     * Set title on Layout
     * 
     * @author hungtd
     * 
     * @param string $title title show on web
     */
    public function set_title($title)
    {
        $this->title = $title;
    }
    
    public function set_image($image)
    {
        $this->image = $image;
    }

    /**
     * @author hungtd
     * 
     * @param string $keyword keyword for website
     */
    public function set_keyword($keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * @author hungtd
     * 
     * @param string $description description for website
     */
    public function set_description($description)
    {
        $this->description = $description;
    }

    /**
     * set css file
     * 
     * @param string $style_name 
     */
    public function set_rel($style_name)
    {
        $this->pgRel = $style_name;
    }

    /**
     * set javascript type
     * 
     * @param string $javascript_name 
     */
    public function set_javascript($javascript_name)
    {
        $this->pgJavascript = $javascript_name;
    }

    /**
     * get title add prefix
     * 
     * @author hungtd
     * 
     * @return string title
     */
    public function get_title()
    {
        if ($this->title)
            return $this->title;// . ' | ' . config_item('penguin_site_name');
        else
            return config_item('penguin_site_name');
    }
    
    public function get_image()
    {
        if ($this->image)
            return $this->image;
        else
            return config_item('penguin_site_image');
    }

    /**
     * @author hungtd
     * 
     * @return strong keyword
     */
    public function get_keyword()
    {
        if ($this->keyword)
            return $this->keyword;
        else
            return config_item('penguin_site_keyword');
    }

    /**
     * @author hungtd
     * 
     * @return strong description 
     */
    public function get_description()
    {
        if ($this->description)
            return $this->description;
        else
            return config_item('penguin_site_description');
    }

    /**
     * get Rel
     * 
     * @return string
     */
    public function get_rel()
    {
        // check invalid rel        
        if ($this->pgRel)
        {
            // Nếu là mảng thì add nhiều file css
            if (is_array($this->pgRel))
            {
                $style = '';

                foreach ($this->pgRel as $key => $css)
                {
                    if (is_numeric($key))
                    {
                        $style .= '<link href="' . $this->getLinkStatic('css', $css) . '" rel="stylesheet" type="text/css" />';
                    } else
                    {
                        if (strpos($key, '__') !== FALSE)
                        {
                            $main_key = substr($key, 0, strpos($key, '__'));
                            $style .= '<link href="' . $this->getLinkStatic($main_key, $css) . '" rel="stylesheet" type="text/css" />';
                        } else
                        {
                            $style .= '<link href="' . $this->getLinkStatic($key, $css) . '" rel="stylesheet" type="text/css" />';
                        }
                    }
                }

                // return string add css to view
                return $style;
            } else // là chuỗi thì add 1 file css đến view
            {
                // return string add css to view
                return '<link href="' . $this->getLinkStatic('css', $this->pgRel) . '" rel="stylesheet" type="text/css" />';
            }
        }

        return FALSE;
    }

    /**
     * get javascript
     * 
     * @return string
     */
    public function get_javascript()
    {
        if ($this->pgJavascript)
        {
            // Nếu là mảng thì add nhiều file javascript
            if (is_array($this->pgJavascript))
            {
                $javascript = '';

                foreach ($this->pgJavascript as $key => $js)
                {
                    if (is_numeric($key))
                    {
                        $javascript .= '<script type="text/javascript" src="' . $this->getLinkStatic('js', $js) . '"></script>';
                    } else
                    {
                        $javascript .= '<script type="text/javascript" src="' . $this->getLinkStatic($key, $js) . '"></script>';
                    }
                }

                // return string add javascript to view
                return $javascript;
            } else // là chuỗi thì add 1 file javascript đến view
            {
                // return string add javascript to view
                return '<script type="text/javascript" src="' . $this->getLinkStatic('js', $this->pgJavascript) . '"></script>';
            }
        }

        return FALSE;
    }

    /**
     * Get link to file in static folder
     * 
     * @param string $subfolder
     * @param string $file
     * @return string 
     */
    public function getLinkStatic($subfolder = '', $file = '')
    {
        // link statis
        $link = static_url() . 'static/' . theme_web();

        // get link sub folder
        if ($subfolder)
        {
            $link .= '/' . $subfolder . '/';
        }

        // get link file
        if ($file)
        {
            $link .= $file;
        }

        return $link;
    }

    /**
     * set class to layout
     * 
     * @param string $class 
     */
    public function set_page_class($class)
    {
        $this->page_class = $class;
    }
    
    /**
     * get class to layout
     * 
     * @return string 
     */
    public function get_page_class()
    {
        return $this->page_class;
    }
    
    /**
     * set id to layout
     * 
     * @param string $id 
     */
    public function set_page_id($id)
    {
        $this->page_id = $id;
    }
    
    /**
     * get id to layout
     * 
     * @return string 
     */
    public function get_page_id()
    {
        return $this->page_id;
    }
    
}

// END Layout Class

/* End of file Layout.php */
/* Location: ./application/libraries/Layout.php */