<?php

namespace App\Service\Api;

use App\Entity\Order;
use App\Service\Order\OrderSignHelper;
use Symfony\Component\Serializer\SerializerInterface;
use ZipArchive;

class OrderSignsDataHelper
{
    private const ZIP_NAME = 'order.zip';
    private const PUBLIC_API_DIR = '/api';

    public function __construct(
        private string $publicDir,
        private OrderSignHelper $signHelper,
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @param Order $order
     */
    public function generateXmlZipFile(Order $order): void
    {
        $this->setApiDir();
        $this->purgeApiDir();

        $signsByType = $this->signHelper->findOrderSigns($order);

        $zip = new ZipArchive();
        $zip->open($this->getZipName(), ZipArchive::CREATE);

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
    }

    /**
     * @return string
     */
    public function getZipName(): string
    {
        return $this->getApiDir() . '/' . self::ZIP_NAME;
    }

    private function setApiDir(): void
    {
        if (!is_dir($this->getApiDir())) {
            mkdir($this->getApiDir());
        }
    }

    /**
     * @return string
     */
    private function getApiDir(): string
    {
        return $this->publicDir . self::PUBLIC_API_DIR;
    }

    private function purgeApiDir(): void
    {
        if (is_readable($this->getZipName())) {
            unlink($this->getZipName());
        }
    }
}
