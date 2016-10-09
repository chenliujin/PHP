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
	public function __construct($query, $params)
	{
		$this->query 		= $query;
		$this->query_params = $params;
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-10-09
	 */
	public function setMaxRows($num)
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
	 */
	public function nav()
	{
	}
}
