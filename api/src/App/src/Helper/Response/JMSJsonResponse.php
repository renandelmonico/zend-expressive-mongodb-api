<?php

namespace App\Helper\Response;

use JMS\Serializer\Serializer;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\InjectContentTypeTrait;
use Zend\Diactoros\Stream;

class JMSJsonResponse extends Response
{
    use InjectContentTypeTrait;

    public function __construct(
        Serializer $JMS,
        $data,
        int $status = 200,
        array $headers = []
    ) {
        $headers = $this->injectContentType('application/json', $headers);

        $body = new Stream('php://temp', 'wb+');
        $body->write($JMS->serialize($data, 'json'));
        $body->rewind();

        parent::__construct(
            $body,
            $status,
            $headers
        );
    }
}
