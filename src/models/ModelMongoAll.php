<?php

namespace Cmendoza\ApiCdc\models;

use Exception;
use Cmendoza\ApiCdc\lib\Model;

class ModelMongoAll extends Model
{
    protected string $id;
    protected string $title;
    protected string $body;
    protected string $id_publi;
    protected $send;

    public function __construct($cool)
    {
        parent::__construct();
        $this->connectionDBMongo($cool);
    }

    public function get($params)
    {
        try {
            $result = $this->collection->find($params)->toArray();
            return $result;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getById($param)
    {
        try {
            $result = $this->collection->find(['_id' => $param])->toArray();
            return $result;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getAll()
    {
        try {
            $result = $this->collection->find()->toArray();
            return $result;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function save($fields)
    {
        try {
            // $this->db->notificacion->bodyNotificacion;
            $result = $this->collection->insertOne($fields);
            return $result->getInsertedId();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function update($fields, $param)
    {
        try {
            $result = $this->collection->updateOne(['_id' => $param], ['$set' => $fields]);
            return $result->getModifiedCount();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function delete($param)
    {
        try {
            $result = $this->collection->deleteOne($param);
            return $result->getDeletedCount();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
