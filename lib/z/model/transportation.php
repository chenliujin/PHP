<?php
namespace z;

include_once('z/model/z.php');


class transportation extends \Model
{
	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-07
	 */
	static public function getTableName()
	{
		return 'transportation';
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-07
	 */
	public function check_enabled()
	{
		global $total_weight;

		$this->check_max_weight($total_weight);
		$this->check_forbidden();
		$this->check_amount();
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-07
	 */
	public function check_max_weight($total_weight)
	{
		if ($this->max_weight && $total_weight >= $this->max_weight) {
			throw new \Exception('total_weight > max_weight');
		}
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-07
	 */
	public function check_forbidden()
	{
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-07
	 */
	public function check_amount()
	{
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-04
	 * @description: 报价
	 * @return array(
	 * 		'id'		=> '',
	 * 		'module'	=> '',
	 * 		'methods'	=> array(
	 * 				array(
	 * 					'id'	=> '',
	 * 					'title'	=> '',
	 * 					'cost'	=> $shipping_cost
	 * 				)
	 * 			),
	 * 		'tax'		=> '',
	 * 		'error'		=> '',
	 * )
	 */
	public function quote()
	{
		$this->check_enabled();

		switch ($this->method) {
			case '1':
				return $this->per_unit_weight();
				break;

			case '2':
				break;

			default:
				throw new Exception('Setting Error: table.field transportation.method setting error');
				break;
		}
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-07
	 * @return array(
	 * 		'id'		=> '',
	 * 		'module'	=> '',
	 * 		'methods'	=> array(
	 * 				array(
	 * 					'id'	=> '',
	 * 					'title'	=> '',
	 * 					'cost'	=> $shipping_cost
	 * 				)
	 * 			),
	 * 		'tax'		=> '',
	 * 		'error'		=> '',
	 * )
	 */
	public function per_unit_weight()
	{
		global $total_weight;

		$transportation_zone = transportation_zone::get_transportation_zone($this->transportation_id, $delivery_country);

		$shipping_cost = $total_weight * $transportation_zone->price;

		return array(
			'id'		=> $this->code,
			'module'	=> $this->code,
			'icon'		=> $this->icon,
			'methods' 	=> array(
				array(
					'id'	=> $this->code,
					'title'	=> $this->code,
					'cost'	=> $shipping_cost
				)
			)
		);
	}


}
