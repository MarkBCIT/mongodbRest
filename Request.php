<?php

class Request
{


    private static $method_type = array('get', 'post', 'put', 'delete');

    public static function getRequest()
    {

        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if (in_array($method, self::$method_type)) {

            $method_name = $method . 'Data';
            return self::$method_name($_REQUEST);
        }
        return false;
    }


    private static function getData($request_data)
    {
        if ((int) $request_data['i'] == null) {
            $filter = [];
            $options = [
                'sort' => ['index' => 1],
            ];
            $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
            $query = new MongoDB\Driver\Query($filter, $options);
            $cursor = $manager->executeQuery('todo.list', $query);
            $arr = $cursor->toArray();
            return $arr;
        } else {
            $filter = [
                'index' => (int) $request_data['i'],
            ];
            $options = [
                'sort' => ['index' => 1],
            ];
            $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
            $query = new MongoDB\Driver\Query($filter, $options);
            $cursor = $manager->executeQuery('todo.list', $query);
            $arr = $cursor->toArray();
            return $arr;
        }
    }

    private static function postData($request_data)
    {

        $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $bulk = new MongoDB\Driver\BulkWrite;
        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
        $document = ['_id' => new MongoDB\BSON\ObjectID, 'name' => $request_data['name'], 'index' => (int) $request_data['index']];
        $bulk->insert($document);
        $result = $manager->executeBulkWrite('todo.list', $bulk, $writeConcern);
        return $result;
    }

    private static function putData($request_data)
    {

        $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $bulk = new MongoDB\Driver\BulkWrite;
        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
        $bulk->update(
            ['index' => (int) $request_data['i']],
            ['$set' => ['name' => $request_data['name'], 'index' => (int) $request_data['i']]],
            ['multi' => true, 'upsert' => false]
        );
        $result = $manager->executeBulkWrite('todo.list', $bulk, $writeConcern);
        return  $result;
    }


    private static function deleteData($request_data)
    {
        $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");  
        $bulk = new MongoDB\Driver\BulkWrite;
        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
        $bulk->delete(['index' => (int) $request_data['i']]);
        $result = $manager->executeBulkWrite('todo.list', $bulk, $writeConcern);
        return $result;
    }
}
