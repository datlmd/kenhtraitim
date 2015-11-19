<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Add MY_Pagination library class
 * 
 * @package PenguinFW
 * @subpackage Core
 * @version 1.0.0
 */

class MY_Pagination extends CI_Pagination
{    
    function __construct($params = array())
    {
        $this->query_string_segment = 'page';
        parent::__construct($params);
    }
    
    /**
     * @author hungtd
	 * Generate the pagination links
	 *
	 * @access	public
     * 
     * @param boolean $show_number show number row on page
	 * @return	string
	 */
	function create_links($show_number = TRUE, $s_between = '-')
	{
		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
			return '';
		}

		// Calculate the total number of pages
		$num_pages = ceil($this->total_rows / $this->per_page);

		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages == 1)
		{
			return '';
		}

		// Determine the current page number.
		$CI =& get_instance();

		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			if ($CI->input->get($this->query_string_segment) != 0)
			{
				$this->cur_page = $CI->input->get($this->query_string_segment);

				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		} elseif ($CI->config->item('enable_named_strings') === TRUE)
        {
            $named_per_page = $CI->input->named($this->query_string_segment);
            if ($named_per_page)
            {
                $this->cur_page = $CI->input->named($this->query_string_segment);

                // Prep the current page - no funny business!
                $this->cur_page = (int) $this->cur_page;
            }
        }else
		{
			if ($CI->uri->segment($this->uri_segment) != 0)
			{
				$this->cur_page = $CI->uri->segment($this->uri_segment);

				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}

		$this->num_links = (int)$this->num_links;

		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}

		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = 0;
		}

		// Is the page number beyond the result range?
		// If so we show the last page
		if ($this->cur_page > $this->total_rows)
		{
			$this->cur_page = ($num_pages - 1) * $this->per_page;
		}

		$uri_page_number = $this->cur_page;
		$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);

		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

		// Is pagination being used over GET or POST?  If get, add a per_page query
		// string. If post, add a trailing slash to the base URL if needed
		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			$this->base_url = rtrim($this->base_url).'&amp;'.$this->query_string_segment.'=';
		} elseif ($CI->config->item('enable_named_strings') === TRUE) 
        {
            $this->base_url = rtrim($this->base_url).'/'.$this->query_string_segment.'.';
        } else
		{
			$this->base_url = rtrim($this->base_url, '/') .'/';
		}

		// And here we go...
		$output = '';

		// Render the "First" link
		if  ($this->first_link !== FALSE AND $this->cur_page > ($this->num_links + 1))
		{
			$first_url = ($this->first_url == '') ? $this->base_url : $this->first_url;
			$output .= $this->first_tag_open.'<a '.$this->anchor_class.'href="'.$first_url.'">'.$this->first_link.'</a>'.$this->first_tag_close;
		}

		// Render the "previous" link
		if  ($this->prev_link !== FALSE AND $this->cur_page != 1)
		{
			$i = $uri_page_number - $this->per_page;

			if ($i == 0 && $this->first_url != '')
			{
				$output .= $this->prev_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}
			else
			{
				$i = ($i == 0) ? '' : $this->prefix.$i.$this->suffix;
				$output .= $this->prev_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$i.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}

		}

		// Render the pages
		if ($this->display_pages !== FALSE)
		{
			// Write the digit links
			for ($loop = $start -1; $loop <= $end; $loop++)
			{
				$i = ($loop * $this->per_page) - $this->per_page;

				if ($i >= 0)
				{
					if ($this->cur_page == $loop)
					{
                        /**
                         * hungtd
                         * custom pagination
                         */
                        if ($show_number == TRUE)
                        {
						$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
                        } else 
                        {
                            $c_num = ($loop-1)*$this->per_page + 1;
                            $c_e_num = (($loop*$this->per_page) < $this->total_rows) ? ($loop*$this->per_page) : $this->total_rows;                            
                            $s_num = $c_num . $s_between . $c_e_num;
                            
                            $output .= $this->cur_tag_open.$s_num.$this->cur_tag_close; // Current page
                        }
					}
					else
					{
						$n = ($i == 0) ? '0' : $i;

						if ($n == '' && $this->first_url != '')
						{
							/**
							 * 
							 * TungCN
							 * custom pagination
							 * 
							 */
							if ($show_number == TRUE)
							{
							$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.'">'.$loop.'</a>'.$this->num_tag_close;
							} else {
								$c_num = ($loop-1)*$this->per_page + 1;
								$c_e_num = (($loop*$this->per_page) < $this->total_rows) ? ($loop*$this->per_page) : $this->total_rows;
								$s_num = $c_num . $s_between . $c_e_num;
								
								$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.'">'.$s_num.'</a>'.$this->num_tag_close;
							}
							
						}
						else
						{
							$n = ($n == '') ? '' : $this->prefix.$n.$this->suffix;

                            /**
                             * hungtd
                             * custom pagination
                             */
                            if ($show_number == TRUE)
                            {
							$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$n.'">'.$loop.'</a>'.$this->num_tag_close;
                            } else 
                            {
                                $c_num = ($loop-1)*$this->per_page + 1;
                                $c_e_num = (($loop*$this->per_page) < $this->total_rows) ? ($loop*$this->per_page) : $this->total_rows;                            
                                $s_num = $c_num . $s_between . $c_e_num;
                                
                                $output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$n.'">'.$s_num.'</a>'.$this->num_tag_close;
                            }
						}
					}
				}
			}
		}

		// Render the "next" link
		if ($this->next_link !== FALSE AND $this->cur_page < $num_pages)
		{
			$output .= $this->next_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$this->prefix.($this->cur_page * $this->per_page).$this->suffix.'">'.$this->next_link.'</a>'.$this->next_tag_close;
		}

		// Render the "Last" link
		if ($this->last_link !== FALSE AND ($this->cur_page + $this->num_links) < $num_pages)
		{
			$i = (($num_pages * $this->per_page) - $this->per_page);
			$output .= $this->last_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$this->prefix.$i.$this->suffix.'">'.$this->last_link.'</a>'.$this->last_tag_close;
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;

		return $output;
	}
}