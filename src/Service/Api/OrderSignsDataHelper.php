<?php

namespace App\Service\Api;

use App\Entity\Order;
use App\Service\Order\OrderSignHelper;
use Symfony\Component\Serializer\SerializerInterface;
use ZipArchive;

class OrderSignsDataHelper
{
    public function __construct(
        private OrderSignHelper $signHelper,
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @param Order $order
     *
     * @return string
     */
    public function generateXmlZipFile(Order $order): string
    {
        $signsByType = $this->signHelper->findOrderSigns($order);

        $zip = new ZipArchive();
        $file = tempnam(sys_get_temp_dir(), 'order_xml_zip');
        $zip->open($file, ZipArchive::CREATE);

        foreach ($signsByType as $typeSigns) {
            foreach ($typeSigns as $sign) {
                $sign->setData($this->serializer->serialize($sign, 'json', ['groups' => 'api_json_data']));
                $zip->addFromString(
                    $sign->getFileName(),
                    $this->serializer->serialize(
                        $sign,
                        'xml',
                        [
                            'groups' => 'api_xml_object',
                            'xml_format_output' => true,
                            'xml_encoding' => 'utf-8',
                            'xml_root_node_name' => 'sign'
                        ]
                    )
                );
            }
        }

        $zip->close();

        return $file;
    }
}
