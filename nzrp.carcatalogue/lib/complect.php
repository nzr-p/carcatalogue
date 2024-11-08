<?php

namespace Nzrp\CarCatalogue;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Nzrp\CarCatalogue\CarTable;

/**
 *  Комплектация это Equipment, но для облегчения взаимопонимания...
 */
class ComplectTable extends DataManager {

	public static function getMap(): array {
		return [
			new IntegerField('ID',
				[
					'primary' => true,
					'autocomplete' => true
				]
			),
			new StringField('NAME'),

			// complect N:1 model
			new IntegerField('MODEL_ID'),
			(new Reference('MODEL', \Nzrp\CarCatalogue\ModelTable::class,
				Join::on('this.MODEL_ID', 'ref.ID')
			))->configureJoinType('inner'),
			
			// complect 1:N car
			(new OneToMany('CARS', CarTable::class, 'COMPLECT')),
			
			// complect N:M option
			(new ManyToMany('OPTIONS', \Nzrp\CarCatalogue\OptionTable::class))
				->configureTableName("b_nzrp_carcatalogue_options_complects"),
		];
	}
}