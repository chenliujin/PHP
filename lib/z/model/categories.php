<?php
namespace z;

include_once('z/model/z.php');
include_once('z/model/categories_description.php');

class categories extends \Model
{
	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-21
	 */
	static public function getTableName()
	{
		return 'categories';
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-21
	 */
	public function get_category_tree()
	{
		$languages_id = $_SESSION['languages_id'];

		$sql = "
			SELECT * 
			FROM " . self::getTableName() . ", " . categories_descption::getTableName() . " 
			WHERE categories.categories_id = categories_description.categories_id
		   		AND languages_id = " . (int)$languages_id . "
				AND categories_status = 1
			ORDER BY sort_order, categories_name
			";
	
	}
}
