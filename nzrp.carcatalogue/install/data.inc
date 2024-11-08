<?php
return [
	'options'=>[
		"Магнитола",
		"Сигнализация",
		"Подогрев сидений",
		"17-дюймовые диски",
		"Зимняя резина",
		"Коврики"
	],
	'brands'=>[
	"Toyota"=>[
		"Corolla"=>[
			"Стандарт"=>[
				[1995, 50000],
				[2001, 150000],
				[2011, 450000],
			],
			"Классик" =>[
				[1996, 60000],
				[2002, 160000],
				[2011, 440000],
			],
		],
		"Camry"  =>[
			"Стандарт"=>[
				[1997, 70000],
				[2003, 180000],
				[2012, 445000],
			],
			// у комплектации 4 ничего нет для разнообразия
			"Престиж" =>[]
		],
		"RAV4"   =>[
			"Спорт"  =>[
				[1996, 170000],
				[2002, 280000],
				[2010, 845000],
			],
			"Престиж"=>[
				[2012, 780000],
				[2015, 1245000],
			],
		],
	],
	"Ford"  =>[
		"Focus"   =>[
			"Ambiente"=>[
				[1994, 50000],
				[2011, 150000],
				[2012, 450000],
			],
			"Trend"   =>[
				[1991, 60000],
				[2012, 160010],
				[2012, 160020],
				[2012, 170030],
				[2012, 160040],
				[2013, 440050],
				[2013, 440060],
				[2013, 440060],
				[2013, 440060],
				[2015, 540070],
				[2016, 640080],
			],
			"Titanium"=>[
				[1996, 50000],
				[2021, 150000],
				[2017, 450000],
			],
		],
		"Mondeo"  =>[
			"Классик"=>[
				[1994, 60000],
				[2012, 160000],
				[2018, 440000],
			],
		],
		"EcoSport"=>[
			"Стандарт"=>[
				[1992, 50000],
				[2011, 150000],
				[2011, 450000],
			],
			"Классик" =>[
				[1991, 60000],
				[2001, 160000],
				[2012, 440000],
			],
		
		],
	],
	"Lada"  =>[
		"Калина"=>[
			"Стандарт"=>[
				[1993, 50000],
				[2003, 150000],
				[2013, 450000],
			],
			"Классик" =>[
				[1994, 60000],
				[2004, 160000],
				[2014, 440000],
			],
		
		],
		"Vesta" =>[
			"Стандарт"=>[
				[1996, 50000],
				[2006, 150000],
				[2016, 450000],
			],
			"Классик" =>[
				[1997, 60000],
				[2007, 160000],
				[2017, 440000],
			],
		
		],
		"2115"  =>[
			"Стандарт"=>[
				[1998, 50000],
				[2008, 150000],
				[2018, 450000],
			],
			"Классик" =>[
				[1999, 60000],
				[2009, 160000],
				[2019, 440000],
			],
		
		],
	
	]
]
];