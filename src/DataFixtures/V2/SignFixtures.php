<?php

namespace App\DataFixtures\V2;

use App\DataFixtures\AbstractSignFixtures;
use App\Entity\AbstractSign;
use App\Entity\AisleOrderSign;
use App\Entity\AisleSmallOrderSign;
use App\Entity\MaterialAlgecoOrderSign;
use App\Entity\MaterialDirOrderSign;
use App\Entity\MaterialSectorOrderSign;
use App\Entity\MaterialServiceOrderSign;
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
                self::BUILDER => 'AisleSignBuilder',
                self::TEMPLATE => 'AisleSignTemplate',
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
                self::BUILDER => 'AisleSmallSignBuilder',
                self::TEMPLATE => 'AisleSmallSignTemplate',
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
                self::BUILDER => 'SectorSignBuilder',
                self::TEMPLATE => 'SectorSignTemplate',
                self::VARIABLE => true,
                self::CATEGORY => AbstractSign::CATEGORY_INDOOR,
            ],
            [
                self::ID => 4,
                self::CLASS_NAME => MaterialSectorOrderSign::class,
                self::NAME => 'materialSector',
                self::TITLE => 'Panneau allée',
                self::WIDTH => 1050,
                self::HEIGHT => 1050,
                self::PRINT_FACES => 1,
                self::MATERIAL => 'Dibond 3MM',
                self::FINISH => null,
                self::WEIGHT => 4.20,
                self::CUSTOMER_REF => 'xxxxxx',
                self::PRICE => 40.00,
                self::BUILDER => 'MaterialSectorSignBuilder',
                self::TEMPLATE => 'MaterialSectorSignTemplate',
                self::VARIABLE => true,
                self::CATEGORY => 2,
            ],
            [
                self::ID => 5,
                self::CLASS_NAME => MaterialDirOrderSign::class,
                self::NAME => 'materialDir',
                self::TITLE => 'Panneau directionnel',
                self::WIDTH => 1050,
                self::HEIGHT => 1050,
                self::PRINT_FACES => 1,
                self::MATERIAL => 'Dibond 3MM',
                self::FINISH => null,
                self::WEIGHT => 4.20,
                self::CUSTOMER_REF => 'xxxxxx',
                self::PRICE => 40.00,
                self::BUILDER => null,
                self::TEMPLATE => 'MaterialDirSignTemplate',
                self::VARIABLE => false,
                self::CATEGORY => 2,
            ],
            [
                self::ID => 6,
                self::CLASS_NAME => MaterialAlgecoOrderSign::class,
                self::NAME => 'materialAlgeco',
                self::TITLE => 'Panneau entrée algeco',
                self::WIDTH => 500,
                self::HEIGHT => 700,
                self::PRINT_FACES => 1,
                self::MATERIAL => 'Dibond 3MM',
                self::FINISH => null,
                self::WEIGHT => 1.33,
                self::CUSTOMER_REF => 'xxxxxx',
                self::PRICE => 40.00,
                self::BUILDER => 'MaterialAlgecoSignBuilder',
                self::TEMPLATE => 'MaterialAlgecoSignTemplate',
                self::VARIABLE => true,
                self::CATEGORY => 2,
            ],
            [
                self::ID => 7,
                self::CLASS_NAME => MaterialServiceOrderSign::class,
                self::NAME => 'materialService',
                self::TITLE => 'Panneau services',
                self::WIDTH => 1050,
                self::HEIGHT => 525,
                self::PRINT_FACES => 1,
                self::MATERIAL => 'Dibond 3MM',
                self::FINISH => null,
                self::WEIGHT => 2.09,
                self::CUSTOMER_REF => 'xxxxxx',
                self::PRICE => 40.00,
                self::BUILDER => null,
                self::TEMPLATE => 'MaterialServiceSignTemplate',
                self::VARIABLE => false,
                self::CATEGORY => 2,
            ],
        ];
    }

    public static function getGroups(): array
    {
        return [
            AppVersionFixturesGroup::V2,
        ];
    }
}
