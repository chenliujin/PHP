<?php

namespace z;

class transportation_zone extends Model
{
	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-07
	 */
	static public function get_transportation_zone($transportation_id, $delivery_country)
	{
		$transportation_zone 		= new self;
		$transportation_zone_list 	= $transportation_zone->findAll(array('transportation_id' => $transportation_id));

		foreach ($tansportation_zone_list as $transportation_zone) {
			if ($transportation_zone->countries == 'ALL') {
				return $transportation_zone;
			} elseif (in_array($delivery_country, explode(',', $transportation_zone->countries))) {
				return $transportation_zone;
			}
		}

		throw new Exception('Error: Transportation Zone Not Exists');
	}
}
