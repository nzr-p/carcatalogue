<?php

namespace Nzrp\CarCatalogue;
use Bitrix\Main\ORM\Fields\FloatField;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;

/**
 */
class CarTable extends DataManager {

	public static function getMap(): array {
		return [
			new IntegerField('ID',
				[
					'primary' => true,
					'autocomplete' => true
				]
			),
			new StringField('NAME'),
			new IntegerField('YEAR'),
			new FloatField('PRICE'),

			// car 1:N complect
			new IntegerField('COMPLECT_ID'),
			(new Reference('COMPLECT', \Nzrp\CarCatalogue\ComplectTable::class,
				Join::on('this.COMPLECT_ID', 'ref.ID')
			))->configureJoinType('inner'),
			
			// car N:M option
			(new ManyToMany('OPTIONS', \Nzrp\CarCatalogue\OptionTable::class))
				->configureTableName("b_nzrp_carcatalogue_options_cars"),
		];
	}
}