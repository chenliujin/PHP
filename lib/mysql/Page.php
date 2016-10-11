<?php
/*
$page = new Page($query);
$rs = $page->data();
 */

class Page extends \Model 
{
	public $query;
	public $query_params;
	public $page_name = 'page';
	public $page_total;
	public $number_of_rows_per_page = 20;
	public $current_page;



	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-10-09
	 */
	public function __construct($query, $params = array())
	{
		$this->query 		= $query;
		$this->query		= str_replace(PHP_EOL, ' ', $this->query); //去掉换行符
		$this->query_params = $params;
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-10-09
	 */
	public function per_page_rows($num)
	{
		$this->number_of_rows_per_page = intval($num) > 0 ? intval($num) : 20;
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-10-09
	 */
	public function setPageName($page_name)
	{
		$this->page_name = $page_name;
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-10-09
	 */
	public function total()
	{
		$query = preg_replace('/SELECT.+FROM/i', 'SELECT COUNT(*) AS total FROM', $this->query);
		$result = $this->query($query, $this->query_params);

		return $result[0]->total;
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-10-09
	 */
	public function data()
	{
		$this->current_page = !empty($_REQUEST[$this->page_name]) ? intval($_REQUEST[$this->page_name]) : 1;
		$this->number_of_rows = $this->total();
		$this->page_total = ceil($this->number_of_rows / $this->number_of_rows_per_page);

		if ($this->current_page > $this->page_total) {
			$this->current_page = $this->page_total;
		}

		$offset = ($this->current_page - 1) * $this->number_of_rows_per_page;
		$offset = $offset . ',' . $this->number_of_rows_per_page;

		$this->query .= ' LIMIT ' . $offset;

		return $this->query($this->query, $this->query_params);
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-10-09
	 * TODO: SEO
	 */
	public function nav()
	{
		$url = $_SERVER['REQUEST_URI'];
		$url = preg_replace('/(#.+$|[?&]+' . $this->page_name . '=[0-9]+)/', '', $url);

		if ($this->current_page <= 1) {
			$pre = '<span class="tmp">&lt;</span>'; 
			$next = $this->page_total > 1 ? ('<a href="' . $url . ((strpos($url, '?') ? '&' : '?') . $this->page_name . '=' . 2) . '"><span class="tmp">&gt;</span></a>') : '&gt;';
		} else {
			$preUrl = $url . (strpos($url, '?') ? '&' : '?') . $this->page_name . '=' . ($this->current_page - 1);

			$pre = '
				<a href="' . $preUrl . '">
					<span class="tmp">&lt;</span>
				</a>';

			if ($this->current_page+1 > $this->page_total) {
				$next = '<span class="tmp">&gt;</span>';
			} else {
				$url .= (strpos($url, '?') ? '&' : '?') . $this->page_name . '=' . (($this->current_page + 1 > $this->page_total) ? $this->page_total : $this->current_page + 1);
				$next = '<a href="' . $url . '"><span class="tmp">&gt;</span></a>';
			}
		}

		$nav = <<<EOB
<style>
.pre, .next  {
	border:1px #ccc solid;
	border-radius:2px;
	background:#FFF;
	display: inline-block;
}
.tmp {
	width: 15px;
	padding:0.3em 1.5em;
	background:#FFF;
	display: inline-block;

}
</style>
		<ul style="list-style: none">
			<li class="pre L" style="">$pre</li>
			<li class="next R" style="margin-left: 10px">$next</li>
		</ul>
EOB;
		echo $nav;
	}
}
