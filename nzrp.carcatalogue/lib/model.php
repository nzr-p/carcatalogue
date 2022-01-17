<?php

namespace Nzrp\CarCatalogue;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Nzrp\CarCatalogue\BrandTable;
use Nzrp\CarCatalogue\ComplectTable;

/**
 *
 */
class ModelTable extends DataManager {

	public static function getMap(): array {
		return [
			new IntegerField('ID',
				[
					'primary' => true,
					'autocomplete' => true
				]
			),
			new StringField('NAME'),

			// model N:1 brand
			new IntegerField('BRAND_ID'),
			(new Reference('BRAND',BrandTable::class,
				Join::on('this.BRAND_ID', 'ref.ID')))
				->configureJoinType('inner'),
			
			// model 1:N complect
			(new OneToMany('COMPLECTS', ComplectTable::class, 'MODEL'))
		];
	}
}