<?php

namespace App\Models;

abstract class AModel
{
    protected $tableName;


    /**
     * @param int $id
     * @param array $params
     * @return mixed
     */
    public function editByID($id, $params = [])
    {
        $queryString = 'UPDATE `' . $this->tableName . '` SET ';
        foreach ($params as $key => $value) {
            $queryString .= '`' . $key . '`' . '=:' . $key . ', ';
        }

        $queryString = substr($queryString, 0, -2);
        $queryString .= ' WHERE `id`=:id';

        $params[':id'] = $id;

        return $this->getResult($queryString, $params)->rowCount();
    }

    /**
     * @param array $fields
     * @param array $data
     * @return mixed
     */
    public function insertMultipleRows($fields, $data)
    {
        $queryString = 'INSERT INTO `' . $this->tableName . '` (';

        foreach ($fields as $key => $value) {
            $queryString .= '`' . $value . '`,';
        }

        $queryString = substr($queryString, 0, -1);
        $queryString .= ') VALUES ';

        foreach ($data as $item) {
            $queryString .= '(';
            foreach ($item as $value) {
                $queryString .= '"' . $value . '",';
            }
            $queryString = substr($queryString, 0, -1);
            $queryString .= '),';
        }
        $queryString = substr($queryString, 0, -1);

        return $this->getResult($queryString)->rowCount();
    }


    /**
     * Get all rows from table
     * @return mixed
     */
    public function getAll()
    {
        $queryString = 'SELECT * FROM `' . $this->tableName . '`';

        return $this->getResult($queryString)->fetchAll();
    }

    /**
     * Get record by it's ID
     * @param integer $id
     * @return mixed
     */
    public function getOneByID($id)
    {
        $queryString = 'SELECT * FROM `' . $this->tableName . '` WHERE `id`=:id LIMIT 1';

        $params = [
            ':id' => $id
        ];

        return $this->getResult($queryString, $params)->fetch();
    }


    /**
     * Executing SQL request
     * @param $queryString
     * @param array $params
     * @return mixed
     */
    protected function getResult($queryString, $params = [])
    {
        try {
            $result = \Core\Database\Database::prepare($queryString)->execute($params);
        } catch (\PDOException $e) {
            echo "Database error: " . $e->getMessage();
            exit;
        }

        return $result;
    }

    /**
     * @param $string
     * @return string
     */
    public static function upperCaseStringWords($string)
    {
        $final = '';
        if (!empty(trim($string))) {
            $str = '';
            $arr = explode(' ', $string);
            foreach ($arr as $word) {
                $w = trim($word);
                if (!empty($w)) {
                    $str .= ucfirst($w) . ' ';
                }
            }

            $final = substr($str, 0, -1);
        }
        return $final;
    }

}