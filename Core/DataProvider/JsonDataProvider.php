<?php

namespace Core\DataProvider;

/**
 * Class JsonDataProvider
 *
 * @package Core\DataProvider
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class JsonDataProvider extends AbstractProvider
{
    /**
     * @var array
     */
    private $data;

    /**
     *
     * @return array
     * @throws \Exception
     */
    public function getData(): array
    {
        $this->readData();

        return $this->data;
    }

    /**
     *
     * @return void
     * @throws \Exception
     */
    protected function readData()
    {
        $dataFilePath = $this->getSource()['path'];
        if (file_exists($dataFilePath)) {
            $data       = file_get_contents($dataFilePath);
            $this->data = json_decode($data, true);
        } else {
            throw new \Exception(\sprintf('File %s not exists', $dataFilePath));
        }
    }
}
