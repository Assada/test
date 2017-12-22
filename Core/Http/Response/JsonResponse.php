<?php

namespace Core\Http\Response;

/**
 * Class JsonResponse
 *
 * @package core\Http\Response
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class JsonResponse extends Response
{
    /**
     * JsonResponse constructor.
     *
     * @param mixed $content
     * @param int   $status
     * @param array $headers
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($content = '', int $status = 200, array $headers = [])
    {
        parent::__construct('', $status, $headers);

        if (!\is_array($content)) {
            $content = new \ArrayObject();
        }

        $this->setJson($content);
    }

    /**
     * @param array $data
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function setJson($data = []): void
    {
        $content = @json_encode($data);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(json_last_error_msg());
        }

        $this->setContent($content);
        $this->addHeaders(['Content-Type' => 'application/json']);
    }

}
