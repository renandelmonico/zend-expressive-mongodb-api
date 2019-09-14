<?php

namespace App\Repository;

use MongoDB\Database;
use MongoDB\Collection;
use MongoDB\UpdateResult;
use MongoDB\BSON\ObjectId;
use App\Repository\Exceptions\UndefinedCollectionException;
use App\Entity\Entity;

/**
 * Classe padrao de repositorio. Todas as implementacoes que devem funcionar
 * em todos os repositorios devem ser feitas aqui
 */
abstract class Repository
{
    /**
     * Collection do repositorio
     *
     * @var string
     */
    protected $collection;

    /**
     * Banco de dados
     *
     * @var Collection
     */
    private $Mongo;

    /**
     * Construtor
     *
     * @param Collection $Mongo
     */
    public function __construct(Database $Mongo)
    {
        if (!$this->collection) {
            throw new UndefinedCollectionException(
                'No collection defined in '.get_called_class()
            );
        }

        $this->Mongo = $Mongo->selectCollection($this->collection);
    }

    /**
     * Busca todos os registros
     *
     * @return array
     */
    public function findAll():array
    {
        return $this->convertMongoIDToString(
            $this->Mongo->find()->toArray()
        );
    }

    /**
     * Busca o registro com a condicional informada por parametro
     *
     * @param array $where
     * @param array $options
     * @return array
     */
    public function find(array $where, array $options = []):array
    {
        return $this->convertMongoIDToString(
            $this->Mongo->find($where, $options)->toArray()
        );
    }

    /**
     * Insere um registro
     *
     * @param Entity $dados
     * @return ObjectId
     */
    public function insert(Entity $dados):ObjectId
    {
        return $this->Mongo->insertOne($dados)->getInsertedId();
    }

    /**
     * Atualiza o registro informado com base na propriedade _id
     *
     * @param string $id
     * @param Entity $dados
     * @return UpdateResult
     */
    public function updateById(string $id, Entity $dados):UpdateResult
    {
        return $this->Mongo->updateOne(
            ['_id' => new ObjectId($id)],
            ['$set' => $dados]
        );
    }

    /**
     * Exclui um registro com base na propriedade _id
     *
     * @param string $id
     * @return boolean
     */
    public function deleteById(string $id):bool
    {
        return $this->Mongo->deleteOne([
            '_id' => new ObjectId($id)
        ])->getDeletedCount() == 1;
    }

    /**
     * Get collection do repositorio
     *
     * @return  string
     */
    public function getCollection():string
    {
        return $this->collection;
    }

    /**
     * Converto o ID padrao do mongo para uma string
     *
     * @param array $dados
     * @return array
     */
    private function convertMongoIDToString(array $dados):array
    {
        return array_map(function ($it) {
            $it['_id'] = (string) $it['_id'];

            return $it;
        }, $dados);
    }
}
