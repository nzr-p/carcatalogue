<?php

namespace Nzrp\CarCatalogue\Model;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;

/**
 */
class OptionTable extends DataManager {

	public static function getMap(): array {
		return [
			new IntegerField('ID',
				[
					'primary' => true,
					'autocomplete' => true
				]
			),
			new StringField('NAME'),

			// option N:M complect
			(new ManyToMany('COMPLECTS', ComplectTable::class))
				->configureTableName("b_nzrp_carcatalogue_options_complects"),
			
			// option N:M car
			(new ManyToMany('CARS', CarTable::class))
				->configureTableName("b_nzrp_carcatalogue_options_cars"),
		
		];
	}
}