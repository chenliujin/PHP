<?php
namespace z;

include_once('z/model/z.php');

class products extends \Model
{
	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-29
	 */
	static public function getTableName()
	{
		return 'products';
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-10-07
	 */
	static public function GetImage($filename, $size)
	{
		$part = explode('.', $filename);

		return $part[0] . '_' . $size . '.' . $part[1];
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-10-08
	 */
	static public function Image($filename, $alt='', $width='', $height='')
	{
		$part = explode('.', $filename);

		$src = $part[0] . '_' . $width . '.' . $part[1];

		return '<img src="' . $src . '" alt="' . $alt . '" title="' . $alt . '" width="' . $width . '" height="' . $height . '" />';
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-29
	 * TODO clear $db, $currencies
	 */
	static public function ShowPriceList( $products_id )
	{
		global $db, $currencies;

		$price = self::GetPriceList( $products_id );

		switch (TRUE) {
			case (!empty($price->special_price)):
				$str = ' 
					<tr>
						<td class="size-base text-right nowrap">List Price:</td>
						<td class="price-del">' . $currencies->format($price->normal_price) . '</td>
					</tr>
					';
				if ($price->special_price != $price->sale_price) {
					$str .= '
						<tr>
							<td class="size-base text-right nowrap">Price:</td>
							<td class="price-del">' . $currencies->format($price->special_price) . '</td>
						</tr>
						<tr>
							<td class="size-base text-right nowrap">' . PRODUCT_PRICE_SALE . '</td>
							<td class="size-medium price">' . $currencies->format($price->sale_price) . '</td>
						</tr>
						';
				} else {
					$str .= '
						<tr>
							<td class="size-base text-right nowrap">Price:</td>
							<td class="size-medium price">' . $currencies->format($price->special_price) . '</td>
						</tr>
						';
				}

				$str .= '
					<tr>
						<td class="size-base text-right nowrap">' . PRODUCT_PRICE_DISCOUNT_PREFIX . '</td>
						<td class="price">' . $price->sale_discount . '</td>
					</tr>
					';
				break;
			
			case (empty($price->special_price) && !empty($price->sale_price)): 
				$str = ' 
					<tr>
						<td class="size-base text-right nowrap">List Price:</td>
						<td class="price-del">' . $currencies->format($price->normal_price) . '</td>
					</tr>
					<tr>
						<td class="size-base text-right nowrap">' . PRODUCT_PRICE_SALE .'</td>
						<td class="size-medium price">' . $currencies->format($price->sale_price) . '</td>
					</tr>
					<tr>
						<td class="size-base text-right nowrap">' . PRODUCT_PRICE_DISCOUNT_PREFIX . '</td>
						<td class="price">' . $price->sale_discount . '</td>
					</tr>
					';
				break;

			default:
				$str = ' 
					<tr>
						<td class="size-base text-right">Price:</td>
						<td class="size-medium price">' . $currencies->format($price->normal_price) . '</td>
					</tr>
					';
				break;
		}

		echo $str;
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-29
	 * TODO clear $db, $currencies
	 */
	static public function GetPriceList( $products_id )
	{
		global $db, $currencies;

		$price = NULL;

		$product_check = $db->Execute("
			select 
				products_tax_class_id, 
				products_price, 
				products_priced_by_attribute, 
				product_is_free, 
				product_is_call, 
				products_type 
			from " . TABLE_PRODUCTS . " 
			where products_id = '" . (int)$products_id . "'" . " limit 1");

		// no prices on Document General
		if ($product_check->fields['products_type'] == 3) {
			return '';
		}

		$price->normal_price 	= zen_get_products_base_price($products_id);
		$price->special_price 	= zen_get_products_special_price($products_id, true);
		$price->sale_price 		= zen_get_products_special_price($products_id, false);

		if ($price->sale_price) {
			$price->sale_discount  = $currencies->format($price->normal_price - $price->sale_price);
			$price->sale_discount .= '&nbsp;'; 
			$price->sale_discount .= '(' . number_format(100 - (($price->sale_price / $price->normal_price) * 100), SHOW_SALE_DISCOUNT_DECIMALS) . '%)';
		} else {
			$price->sale_discount  = $currencies->format($price->normal_price - $price->special_price);
			$price->sale_discount .= '&nbsp;';
			$price->sale_discount .= '(' . number_format(100 - (($price->special_price / $price->normal_price) * 100), SHOW_SALE_DISCOUNT_DECIMALS) . '%)';
		}

		return $price;
	}
}
