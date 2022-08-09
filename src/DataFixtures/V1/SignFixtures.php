<?php

namespace App\DataFixtures\V1;

use App\DataFixtures\AbstractSignFixtures;
use App\Entity\AbstractSign;
use App\Entity\AisleOrderSign;
use App\Entity\AisleSmallOrderSign;
use App\Entity\SectorOrderSign;
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
                self::ID => 1,
                self::CLASS_NAME => AisleOrderSign::class,
                self::NAME => 'aisle',
                self::TITLE => 'Panneau allée avec pictogramme',
                self::WIDTH => 800,
                self::HEIGHT => 500,
                self::PRINT_FACES => 2,
                self::MATERIAL => 'PVC 5MM',
                self::FINISH => '2 Perfos hautes',
                self::WEIGHT => 0.50,
                self::CUSTOMER_REF => '178738',
                self::PRICE => 14.50,
                self::VARIABLE => true,
                self::CATEGORY => 1
            ],
            [
                self::ID => 2,
                self::CLASS_NAME => AisleSmallOrderSign::class,
                self::NAME => 'aisleSmall',
                self::TITLE => 'Panneau allée',
                self::WIDTH => 900,
                self::HEIGHT => 300,
                self::PRINT_FACES => 2,
                self::MATERIAL => 'PVC 5MM',
                self::FINISH => '2 Perfos hautes',
                self::WEIGHT => 0.40,
                self::CUSTOMER_REF => '178737',
                self::PRICE => 10.50,
                self::VARIABLE => true,
                self::CATEGORY => 1,
            ],
            [
                self::ID => 3,
                self::CLASS_NAME => SectorOrderSign::class,
                self::NAME => 'sector',
                self::TITLE => 'Panneau secteur',
                self::WIDTH => 1600,
                self::HEIGHT => 500,
                self::PRINT_FACES => 2,
                self::MATERIAL => 'PVC 10MM',
                self::FINISH => '2 Perfos hautes',
                self::WEIGHT => 1.50,
                self::CUSTOMER_REF => '178736',
                self::PRICE => 39.00,
                self::VARIABLE => true,
                self::CATEGORY => 1,
            ],
        ];
    }

    public static function getGroups(): array
    {
        return [
            AppVersionFixturesGroup::V1,
        ];
    }
}
