<?php

namespace Nzrp\CarCatalogue;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;

/**
 *  Комплектация это Equipment, но для облегчения взаимопонимания...
 */
class ComplectTable extends DataManager {
	// само пусть формируется
//	public static function getTableName(): string {
//		return 'brand';
//	}
	
	public static function getMap(): array {
		return [
			new IntegerField('ID',
				[
					'primary' => true,
					'autocomplete' => true
				]
			),
			new StringField('NAME'),

			// модели соответсвует только 1 брэнд
			new IntegerField('MODEL_ID'),
			(new Reference('MODEL',ModelTable::class,
				Join::on('this.MODEL_ID', 'ref.ID')
			))->configureJoinType('inner')
		];
	}
}