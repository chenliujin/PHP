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
	 * @since 2016-09-29
	 */
	static public function GetPriceList(int $products_id)
	{
		$price_list = [];



		global $db, $currencies;


		$free_tag = "";
		$call_tag = "";

		// 0 = normal shopping
		// 1 = Login to shop
		// 2 = Can browse but no prices
		// verify display of prices
		switch (true) {
		case (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == ''):
			// customer must be logged in to browse
			return '';
			break;
		case (CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == ''):
			// customer may browse but no prices
			return TEXT_LOGIN_FOR_PRICE_PRICE;
			break;
		case (CUSTOMERS_APPROVAL == '3' and TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM != ''):
			// customer may browse but no prices
			return TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM;
			break;
		case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customer_id'] == ''):
			// customer must be logged in to browse
			return TEXT_AUTHORIZATION_PENDING_PRICE;
			break;
		case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customers_authorization'] > '0'):
			// customer must be logged in to browse
			return TEXT_AUTHORIZATION_PENDING_PRICE;
			break;
		case ((int)$_SESSION['customers_authorization'] == 2):
			// customer is logged in and was changed to must be approved to see prices
			return TEXT_AUTHORIZATION_PENDING_PRICE;
			break;
		default:
			// proceed normally
			break;
		}

		// show case only
		if (STORE_STATUS != '0') {
			if (STORE_STATUS == '1') {
				return '';
			}
		}

		// $new_fields = ', product_is_free, product_is_call, product_is_showroom_only';
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

		$show_display_price = '';
		$price_list['normal_price'] = $display_normal_price = zen_get_products_base_price($products_id);
		$price_list['special_price'] = $display_special_price = zen_get_products_special_price($products_id, true);
		$price_list['sale_price'] = $display_sale_price = zen_get_products_special_price($products_id, false);

		$show_sale_discount = '';
		if (SHOW_SALE_DISCOUNT_STATUS == '1' and ($display_special_price != 0 or $display_sale_price != 0)) {
			if ($display_sale_price) {
				if (SHOW_SALE_DISCOUNT == 1) {
					if ($display_normal_price != 0) {
						$show_discount_amount = number_format(100 - (($display_sale_price / $display_normal_price) * 100),SHOW_SALE_DISCOUNT_DECIMALS);
					} else {
						$show_discount_amount = '';
					}
					$show_sale_discount = '<span class="productPriceDiscount price size-base">' . '<br />' 
						. PRODUCT_PRICE_DISCOUNT_PREFIX . $show_discount_amount . PRODUCT_PRICE_DISCOUNT_PERCENTAGE 
						. '</span>';

				} else {
					$show_sale_discount = '<span class="productPriceDiscount price size-base">' . '<br />' 
						. PRODUCT_PRICE_DISCOUNT_PREFIX . $currencies->display_price(($display_normal_price - $display_sale_price), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . PRODUCT_PRICE_DISCOUNT_AMOUNT 
						. '</span>';
				}
			} else {
				if (SHOW_SALE_DISCOUNT == 1) {
					$show_sale_discount = '<span class="productPriceDiscount price size-base">' . '<br />' 
						. PRODUCT_PRICE_DISCOUNT_PREFIX . number_format(100 - (($display_special_price / $display_normal_price) * 100),SHOW_SALE_DISCOUNT_DECIMALS) . PRODUCT_PRICE_DISCOUNT_PERCENTAGE 
						. '</span>';
				} else {
					$show_sale_discount = '<span class="productPriceDiscount price size-base">' . '<br />' 
						. PRODUCT_PRICE_DISCOUNT_PREFIX . $currencies->display_price(($display_normal_price - $display_special_price), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . PRODUCT_PRICE_DISCOUNT_AMOUNT 
						. '</span>';
				}
			}
		}

		if ($display_special_price) {
			$show_normal_price = '<span class="normalprice price-del">' 
				. $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) 
				. ' </span>';

			if ($display_sale_price && $display_sale_price != $display_special_price) {
				$show_special_price = '&nbsp;' 
					. '<span class="productSpecialPriceSale">' 
					. $currencies->display_price($display_special_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) 
					. '</span>';

				if ($product_check->fields['product_is_free'] == '1') {
					$show_sale_price = '<br />' 
						. '<span class="productSalePrice">' . PRODUCT_PRICE_SALE . '<s>' 
						. $currencies->display_price($display_sale_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) 
						. '</s>' . '</span>';
				} else {
					$show_sale_price = '<br />' 
						. '<span class="productSalePrice">' . PRODUCT_PRICE_SALE 
						. $currencies->display_price($display_sale_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) 
						. '</span>';
				}
			} else {
				if ($product_check->fields['product_is_free'] == '1') {
					$show_special_price = '&nbsp;' 
						. '<span class="price size-medium">' . '<s>' 
						. $currencies->display_price($display_special_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) 
						. '</s>' . '</span>';
				} else {
					$show_special_price = '&nbsp;' 
						. '<span class="price size-medium">' 
						. $currencies->display_price($display_special_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) 
						. '</span>';
				}
				$show_sale_price = '';
			}
		} else {
			if ($display_sale_price) {
				$show_normal_price = '<span class="normalprice price-del">' 
					. $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) 
					. ' </span>';
				$show_special_price = '';
				$show_sale_price = '<br />' 
					. '<span class="productSalePrice">' 
					. PRODUCT_PRICE_SALE 
					. $currencies->display_price($display_sale_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) 
					. '</span>';
			} else {
				if ($product_check->fields['product_is_free'] == '1') {
					$show_normal_price = '<span class="productFreePrice"><s>' 
						. $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) 
						. '</s></span>';
				} else {
					$show_normal_price = '<span class="productBasePrice price size-medium">' 
						. $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) 
						. '</span>';
				}
				$show_special_price = '';
				$show_sale_price = '';
			}
		}

		if ($display_normal_price == 0) { // don't show the $0.00
			$final_display_price = $show_special_price . $show_sale_price . $show_sale_discount;
		} else {
			$final_display_price = $show_normal_price . $show_special_price . $show_sale_price . $show_sale_discount;
		}

		// If Free, Show it
		if ($product_check->fields['product_is_free'] == '1') {
			if (OTHER_IMAGE_PRICE_IS_FREE_ON=='0') {
				$free_tag = '<br />' . PRODUCTS_PRICE_IS_FREE_TEXT;
			} else {
				$free_tag = '<br />' . zen_image(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_PRICE_IS_FREE, PRODUCTS_PRICE_IS_FREE_TEXT);
			}
		}

		// If Call for Price, Show it
		if ($product_check->fields['product_is_call']) {
			if (PRODUCTS_PRICE_IS_CALL_IMAGE_ON=='0') {
				$call_tag = '<br />' . PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT;
			} else {
				$call_tag = '<br />' . zen_image(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_CALL_FOR_PRICE, PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT);
			}
		}

		return $price_list;
	}
}
