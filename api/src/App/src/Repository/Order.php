<?php

namespace App\Repository;

use MongoDB\Database;
use JMS\Serializer\Serializer;
use App\Entity\Entity;
use App\Entity\Order as OrderEntity;

class Order extends Repository
{
    /**
     * Collection do repositorio
     *
     * @var string
     */
    protected $collection = 'orders';

    /**
     * JMS
     *
     * @var Serializer
     */
    private $JMS;

    /**
     * Construtor
     *
     * @param Database $Mongo
     * @param Serializer $JMS
     */
    public function __construct(
        Database $Mongo,
        Serializer $JMS
    ) {
        $this->JMS = $JMS;
        parent::__construct($Mongo);
    }

    public function findAll():array
    {
        $registros = $this->formatDateFields(parent::findAll());
        $registros = $this->formatMongoIds($registros);

        return $this->JMS->deserialize(
            json_encode($registros),
            'array<App\Model\OrderList>',
            'json'
        );
    }

    public function find(array $where, array $options = []): array
    {
        $registros = $this->formatDateFields(parent::find($where, $options));
        $registros = $this->formatMongoIds($registros);

        return $this->JMS->deserialize(
            json_encode($registros),
            'array<App\Entity\Order>',
            'json'
        );
    }

    private function formatDateFields(array $registros):array
    {
        return array_map(function ($it) {
            $it = json_decode(json_encode($it));

            if ($it->created_at) {
                $it->created_at = (new \DateTime($it->created_at->date))->format('Y-m-d H:i:s');
            }

            if ($it->cancelDate) {
                $it->cancelDate = (new \DateTime($it->cancelDate->date))->format('Y-m-d H:i:s');
            }

            return $it;
        }, $registros);
    }

    private function formatMongoIds(array $orders):array
    {
        $id = '$oid';

        return array_map(function ($it) use ($id) {
            $it->buyer->_id = $it->buyer->id->{$id};

            foreach ($it->items as &$item) {
                $item->product->_id = $item->product->id->{$id};
            }

            return $it;
        }, $orders);
    }
}
