<?php

namespace App\DataFixtures\V2;

use App\DataFixtures\AbstractSignFixtures;
use App\Entity\MaterialSectorOrderSign;
use App\Entity\Sign;
use App\Service\Fixtures\AppVersionFixturesGroup;

class SignFixtures extends AbstractSignFixtures
{
    /**
     * @return Sign[]
     */
    protected function getSignsData(): array
    {
        return [
            [
                self::ID => 4,
                self::CLASS_NAME => MaterialSectorOrderSign::class,
                self::TYPE => MaterialSectorOrderSign::getType(),
                self::IMAGE => 'material_sector_order_sign.jpg',
                self::TITLE => 'Panneau allée',
                self::DESCRIPTION => 'Format: 1050x1050mm<br>Impression: Recto<br>Matière: Dibond 3MM',
                self::WEIGHT => 4.20,
                self::BUILDER => 'MaterialSectorSignBuilder',
                self::TEMPLATE => 'MaterialSectorSignTemplate',
                self::PRICE => 40.00,
                self::CUSTOMER_REF => 'xxxxxx',
                self::CATEGORY => Sign::CATEGORY_OUTDOOR,
            ]
        ];
    }

    public static function getGroups(): array
    {
        return [
            AppVersionFixturesGroup::V2,
        ];
    }
}
