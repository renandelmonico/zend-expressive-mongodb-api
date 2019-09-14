<?php

namespace App\Repository;

use MongoDB\Database;
use JMS\Serializer\Serializer;
use App\Entity\Entity;
use App\Entity\Customer as CustomerEntity;

class Customer extends Repository
{
    /**
     * Collection do repositorio
     *
     * @var string
     */
    protected $collection = 'customers';

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

        return $this->JMS->deserialize(
            json_encode($registros),
            'array<App\Entity\Customer>',
            'json'
        );
    }

    public function find(array $where, array $options = []): array
    {
        $registros = $this->formatDateFields(parent::find($where, $options));

        return $this->JMS->deserialize(
            json_encode($registros),
            'array<App\Entity\Customer>',
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

            if ($it->updated_at) {
                $it->updated_at = (new \DateTime($it->updated_at->date))->format('Y-m-d H:i:s');
            }

            return $it;
        }, $registros);
    }
}
