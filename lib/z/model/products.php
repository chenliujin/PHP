<?php
namespace z;

include_once('z/model/z.php');

/**
 * TODO
 * products_description.products_url: 添加字段生成产品的链接，考虑 SEO
 */
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
			case !empty($price->sale_price): 
				$str = ' 
					<tr>
						<td class="size-base text-right nowrap">Price:</td>
						<td class="price-del">' . $currencies->format($price->normal_price) . '</td>
					</tr>
					<tr class="price">
						<td class="size-base text-right nowrap">' . PRODUCT_PRICE_SALE .'</td>
						<td class="size-medium">' . $currencies->format($price->sale_price) . '</td>
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

		$price = new \stdClass;

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
			if ($price->normal_price) {
				$price->sale_discount .= '&nbsp;'; 
				$price->sale_discount .= '(' . number_format(100 - (($price->sale_price / $price->normal_price) * 100), SHOW_SALE_DISCOUNT_DECIMALS) . '%)';
			}
		} else {
			$price->sale_discount  = $currencies->format($price->normal_price - $price->special_price);

			if ($price->normal_price) {
				$price->sale_discount .= '&nbsp;';
				$price->sale_discount .= '(' . number_format(100 - (($price->special_price / $price->normal_price) * 100), SHOW_SALE_DISCOUNT_DECIMALS) . '%)';
			}
		}

		return $price;
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-10-09
	 */
	static public function GetAllProducts()
	{
		$sql = "
			SELECT 
				p.products_type, 
				p.products_id, 
				pd.products_name, 
				p.products_image, 
				p.products_price, 
				p.products_tax_class_id, 
				p.products_date_added, 
				m.manufacturers_name, 
				p.products_model, 
				p.products_quantity, 
				p.products_weight, 
				p.product_is_call, 
				p.product_is_always_free_shipping, 
				p.products_qty_box_status, 
				p.master_categories_id 
			FROM " . self::GetTableName() . " p LEFT JOIN " . TABLE_MANUFACTURERS . " m ON (p.manufacturers_id = m.manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd 
			WHERE 
				p.products_status = 1 AND 
				p.products_id = pd.products_id AND 
				pd.language_id = ? 
			"; 

		$params = [
			$_SESSION['languages_id']
		];

		$page = new \Page($sql, $params);
		$page->per_page_rows(12);
		$page->order_by('ORDER BY products_id DESC');

		return $page;
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-10-28
	 */
	static public function GetCategoriesProduct($sql)
	{
		$params = [];

		$page = new \Page($sql, $params);
		$page->per_page_rows(12);
		//$page->order_by('ORDER BY products_id DESC');

		return $page;
	
	}
}
