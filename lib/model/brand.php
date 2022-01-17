<?php

namespace Nzrp\CarCatalogue\Model;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\StringField;

/**
 *
 */
class BrandTable extends DataManager {

	public static function getMap(): array {
		return [
			new IntegerField('ID',
				[
					'primary' => true,
					'autocomplete' => true
				]
			),
			new StringField('NAME'),
			
			// brand 1:N model
			(new OneToMany('MODELS', ModelTable::class, 'BRAND'))
		];
	}
}