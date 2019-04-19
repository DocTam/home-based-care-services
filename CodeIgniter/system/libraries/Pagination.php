<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/pagination.html
 */
class CI_Pagination {

	var $query = false; //搜索用的

	var $base_url			= ''; // 基本链接,即保留部分的链接
	var $prefix				= ''; // 页码数字前面自定义的内容
	var $suffix				= ''; // 页码数字后面自定义的内容

	var $total_rows			=  0; // 总条数量
	var $per_page			= 10; // 每页条数
	var $num_pages			= 0;  // 总页数
	var $num_links			=  2; // 当前页前后页码数量
	var $cur_page			=  0; // 当前页
	var $use_page_numbers	= FALSE; // 用于表示是否页面 还是 起始偏移量

	var $first_link			= '&lsaquo; First'; //第一页的内容: <a>第一页</a> 中间的三个字
	var $next_link			= '&gt;'; //下一页的内容:  <a>下一页</a> 中间的三个字
	var $prev_link			= '&lt;'; //上一页的内容:  <a>上一页</a> 中间的三个字

	var $show_next_link		= FALSE; //无论如何都要显示上一页(即当前已经是第一页,也要显示上一页)
	var $show_prev_link		= FALSE; //无论如何都要显示下一页(即当前已经是最尾页,也要显示下一页)

	var $last_link			= 'Last &rsaquo;'; //最尾页的内容
	var $uri_segment		= 3; //不知道干啥的
	var $render_pages       = ''; //表示当前前台后台 前台: front.  后台: null

	var $num_front_open     = ''; //前台页面的数字部分的外围标签 
	var $num_front_close    = ''; //前台页面的数字部分的外围标签

	var $full_tag_open		= ''; //所有分页部分的开始标签 <tag> 1,2,3 </tag>
	var $full_tag_close		= '';

	var $first_tag_open		= '';
	var $first_tag_close	= '&nbsp;';
	var $last_tag_open		= '&nbsp;';
	var $last_tag_close		= '';

	var $first_url			= ''; // Alternative URL for the First Page.
	var $cur_tag_open		= '&nbsp;<strong>';
	var $cur_tag_close		= '</strong>';

	var $next_tag_open		= '&nbsp;'; //下一页之前的标签 &nbsp;<a>下一页</a>
	var $next_tag_close		= '&nbsp;';  //下一页之后的标签  <a>下一页</a>&nbsp;

	var $prev_tag_open		= '&nbsp;'; //上一页之前的标签 XX 上一页
	var $prev_tag_close		= '&nbsp;'; //上一页之后的标签  上一页 XX

	var $num_tag_open		= '&nbsp;'; //数字之前的内容 <XX><a>1</a></XX>
	var $num_tag_close		= '&nbsp;';  //数字之后的内容 <XX><a>1</a></XX>

	var $page_query_string	= FALSE;
	var $query_string_segment = 'page';
	var $display_pages		= TRUE;

	var $anchor_class		= '';
	var $anchor_class_prev = '';
	var $anchor_class_next = '';

	var $anchor_class_first = '';
	var $anchor_class_last = '';

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

		if ($this->anchor_class != '')
		{
			$this->anchor_class = 'class="'.$this->anchor_class.'" ';
		}

		log_message('debug', "Pagination Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	function initialize($params = array())
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
	 * Generate the pagination links
	 *
	 * @access	public
	 * @return	string
	 */
	function create_links()
	{
		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
			return '';
		}

		// Calculate the total number of pages
		$num_pages = ceil($this->total_rows / $this->per_page);

		$this->num_pages = $num_pages;

		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages == 1)
		{
			return '';
		}

		// Set the base page index for starting page number
		if ($this->use_page_numbers)
		{
			$base_page = 1;
		}
		else
		{
			$base_page = 0;
		}

		// Determine the current page number.
		$CI =& get_instance();

		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			if ($CI->input->get($this->query_string_segment) != $base_page)
			{
				$this->cur_page = $CI->input->get($this->query_string_segment);

				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}
		else
		{
			if ($CI->uri->segment($this->uri_segment) != $base_page)
			{
				$this->cur_page = $CI->uri->segment($this->uri_segment);

				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}
		
		// Set current page to 1 if using page numbers instead of offset
		if ($this->use_page_numbers AND $this->cur_page == 0)
		{
			$this->cur_page = $base_page;
		}

		$this->num_links = (int)$this->num_links;

		if ($this->num_links < 0)
		{
			show_error('Your number of links must be a positive number.');
		}

		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = $base_page;
		}

		// Is the page number beyond the result range?
		// If so we show the last page
		if ($this->use_page_numbers)
		{
			if ($this->cur_page > $num_pages)
			{
				$this->cur_page = $num_pages;
			}
		}
		else
		{
			if ($this->cur_page > $this->total_rows)
			{
				$this->cur_page = ($num_pages - 1) * $this->per_page;
			}
		}

		$uri_page_number = $this->cur_page;
		
		if ( ! $this->use_page_numbers)
		{
			$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);
		}

		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

		// Is pagination being used over GET or POST?  If get, add a per_page query
		// string. If post, add a trailing slash to the base URL if needed
		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			
			
			if(empty($this->base_url)){
				if($_SERVER['QUERY_STRING']==''){
					$myquery = '';
					if($this->query){
						$myquery = http_build_query($this->query);
					}

					$this->base_url = '?'.$myquery;
				} else {
					$q = $_SERVER['QUERY_STRING'];
					parse_str($q, $output);

					unset($output[$this->query_string_segment]); //取消page

					if($this->query){
						$output = array_merge($output, $this->query);
					}
					$query = http_build_query($output);

					$this->base_url = "?{$query}";
				}
			}
			$this->base_url = rtrim($this->base_url).'&amp;'.$this->query_string_segment.'=';
		}
		else
		{
			$this->base_url = rtrim($this->base_url, '/') .'/';
		}

		// And here we go...
		$output = '';

		// Render the "First" link
		if  ($this->first_link !== FALSE )
		{
			$first_url = ($this->first_url == '') ? $this->base_url : $this->first_url;
			$output .= $this->first_tag_open.'<a '.$this->anchor_class_first.' href="'.$first_url.'">'.$this->first_link.'</a>'.$this->first_tag_close;
		}

		// Render the "previous" link
		if  (($this->prev_link !== FALSE AND $this->cur_page != 1 ) || $this->show_prev_link === true)
		{
			if ($this->use_page_numbers)
			{
				$i = $uri_page_number - 1;
			}
			else
			{
				$i = $uri_page_number - $this->per_page;
			}

			$i = $i < 0 ? 0 : $i; //防止进入小于0的页面

			if ($i == 0 && $this->first_url != '')
			{
				$output .= $this->prev_tag_open.'<a '.$this->anchor_class_prev.' href="'.$this->first_url.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}
			else
			{
				$i = ($i == 0) ? '' : $this->prefix.$i.$this->suffix;
				$output .= $this->prev_tag_open.'<a '.$this->anchor_class_prev.' href="'.$this->base_url.$i.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}

		}

		// Render the pages
		if($this->render_pages == 'front'){//前台页面
			$output .= $this->num_front_open;
		}
		if ($this->display_pages !== FALSE)
		{
			// Write the digit links
			for ($loop = $start -1; $loop <= $end; $loop++)
			{
				if ($this->use_page_numbers)
				{
					$i = $loop;
				}
				else
				{
					$i = ($loop * $this->per_page) - $this->per_page;
				}

				if ($i >= $base_page)
				{
					if ($this->cur_page == $loop)
					{
						$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
					}
					else
					{
						$n = ($i == $base_page) ? '' : $i;

						if ($n == '' && $this->first_url != '')
						{
							$output .= $this->num_tag_open.'<a '.$this->anchor_class.' href="'.$this->first_url.'">'.$loop.'</a>'.$this->num_tag_close;
						}
						else
						{
							$n = ($n == '') ? '' : $this->prefix.$n.$this->suffix;

							$output .= $this->num_tag_open.'<a '.$this->anchor_class.' href="'.$this->base_url.$n.'">'.$loop.'</a>'.$this->num_tag_close;
						}
					}
				}
			}
		}
		if($this->render_pages == 'front'){//前台页面
			$output .= $this->num_front_close;
		}

		// Render the "next" link
		if (($this->next_link !== FALSE AND $this->cur_page < $num_pages) || $this->show_next_link === true )
		{
			if ($this->use_page_numbers)
			{
				$i = $this->cur_page + 1;
				$i = $i > $this->num_pages ? $this->num_pages : $i; //大于最大页数,则取最大页数
			}
			else
			{
				$i = ($this->cur_page * $this->per_page);
				
				$i = $i >= $this->total_rows ? (($this->cur_page -1 )* $this->per_page) : $i;
			}

			$output .= $this->next_tag_open.'<a '.$this->anchor_class_next.' href="'.$this->base_url.$this->prefix.$i.$this->suffix.'">'.$this->next_link.'</a>'.$this->next_tag_close;
		}

		// Render the "Last" link
		if ($this->last_link !== FALSE )
		{
			if ($this->use_page_numbers)
			{
				$i = $num_pages;
			}
			else
			{
				$i = (($num_pages * $this->per_page) - $this->per_page);
			}
			$output .= $this->last_tag_open.'<a '.$this->anchor_class_last.' href="'.$this->base_url.$this->prefix.$i.$this->suffix.'">'.$this->last_link.'</a>'.$this->last_tag_close;
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;

		return $output;
	}
}
// END Pagination Class

/* End of file Pagination.php */
/* Location: ./system/libraries/Pagination.php */