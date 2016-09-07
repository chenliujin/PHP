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
		$this->check_enabled_for_zone();
		$this->check_max_weight();
		$this->check_forbidden();
		$this->check_amount();
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-07
	 */
	public function check_enabled_for_zone()
	{
		$transportation_zone 		= new \z\transportation_zone;
		$transportation_zone_list 	= $transportation_zone->get($this->transportation_id);

		foreach ($tansportation_zone_list as $transportation_zone) {
			if ($transportation_zone->countries == 'ALL') {
				return $transportation_zone;
			}

			if (in_array($delivery_country, explode(',', $transportation_zone->countries))) {
				return $transportation_zone;
			}
		}

		throw new Exception('Error: Transportation Zone Not Exists');
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
		$shipping_cost = $shipping_weight * $transportation_zone->price;

		return array(
			'methods' => array(
				array(
					'cost'	=> $shipping_cost
				)
			)
		);
	}


}
