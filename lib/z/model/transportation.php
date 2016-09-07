<?php
namespace z;

class transportation extends Model
{
	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-07
	 */
	public function check_enabled()
	{
		$this->check_max_weight();
		$this->check_forbidden();
		$this->check_amount();
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-07
	 */
	public function check_max_weight()
	{
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
	 * @return array (
	 * 	'code'
	 * 	'cost'
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
				throw new Exception('Setting Error: Transportation Method Not Exists');
				break;
		}

	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-07
	 */
	public function per_unit_weight()
	{
		$transportation_zone = transportation_zone::get_transportation_zone($this->transportation_id, $delivery_country);

		$shipping_cost = $shipping_weight * $transportation_zone->price;

		return array(
			'id'		=> $this->code,
			'module'	=> '',
			'methods' 	=> array(
				array(
					'id'	=> $this->code,
					'title'	=> '',
					'cost'	=> $shipping_cost
				)
			)
		);
	}


}
