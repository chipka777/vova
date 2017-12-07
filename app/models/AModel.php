<?php

namespace App\Models;

abstract class AModel
{
    protected $tableName;

    protected $queryParams = [];

    protected $queryString;

    public static function find($id) 
    {
        $class =  get_called_class();
        $obj = new $class;
        $queryString = 'SELECT * FROM `' . $obj->tableName . '` WHERE `id`=:id LIMIT 1';

        $params = [
            ':id' => $id
        ];

        $result = $obj->getResult($queryString, $params)->fetch();

        foreach ($obj->fillable as $field) {
            $obj->$field = $result[$field];
        } 

        return $obj;
    }

    public static function where($field, $operand, $value) 
    {
        if (empty($operand)) $operand = '=';

        $class = get_called_class();

        $obj = new $class;

        $obj->queryString = 'WHERE `' . $field . '`' . $operand . ':' . $field;

        $obj->queryParams[] = $field . ':' .  $value; 

        return $obj;
    }

    public static function all()
    {
        $class = get_called_class();

        $obj = new $class;

        $query = 'SELECT * FROM `' . $obj->tableName . '`';

        $params = [];

        $result = $obj->getResult($query, $params)->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function andWhere($field, $operand, $value) 
    {
        if (empty($operand)) $operand = '=';

        $this->queryString .= ' AND `' . $field . '`' . $operand . ':' . $field;
        $this->queryParams[] = $field . ':' .  $value; 

        return $this;
    }

    public function get()
    {
        $query = 'SELECT * FROM `' . $this->tableName . '`' . $this->queryString;

        $params = [];

        foreach ($this->queryParams as $param) {
            $par = $this->parse($param);
            $params[':' . $par[0]] = $par[1]; 
        }

        $result = $this->getResult($query, $params)->fetchAll();

        return $result;   
         
    }

    public function first()
    {
        $query = 'SELECT * FROM `' . $this->tableName . '`' . $this->queryString . ' LIMIT 1';

        $params = [];

        foreach ($this->queryParams as $param) {
            $par = $this->parse($param);
            $params[':' . $par[0]] = $par[1]; 
        }

    
        $result = $this->getResult($query, $params)->fetch();

        foreach ($this->fillable as $field) {
            $this->$field = $result[$field];
        } 

        return $this;
         
    }

    public function firstOrFail()
    {
        
        $query = 'SELECT * FROM `' . $this->tableName . '`' . $this->queryString . ' LIMIT 1';

        $params = [];

        foreach ($this->queryParams as $param) {
            $par = $this->parse($param);
            $params[':' . $par[0]] = $par[1]; 
        }

    
        $result = $this->getResult($query, $params)->fetch();
    

        foreach ($this->fillable as $field) {
            $this->$field = $result[$field];
        } 

        return $this;
         
    }

    public function create() 
    {
        $query = "INSERT INTO `$this->tableName`(";

        $values = '(';

        foreach ($this->fillable as $field) {
            if ($field == 'id' && !$this->$field) continue;

            $values .=  ' "' . htmlspecialchars($this->$field) . '",';
            $query .= " `$field`,";
        }

        $values = substr($values, 0, -1);
        $query = substr($query, 0, -1);        
        $query.= ") VALUES $values )";

        return $this->getResult($query)->rowCount();
        
    }

    public function update() 
    {
        $query = "UPDATE `$this->tableName` SET ";

        foreach ($this->fillable as $field) {
            if ($field == 'id' && !$this->$field) continue;
            $query .= "`$field` = '" . htmlspecialchars($this->$field) . "',";
        }

        $query = substr($query, 0, -1);        
        $query.= " WHERE id = " . $this->id;


        return $this->getResult($query)->rowCount();
        
    }

    public function destroy()
    {
        $query = "DELETE FROM `$this->tableName` WHERE ID = $this->id";
        
        return $this->getResult($query)->rowCount();
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

    public function parse($str, $symbol = ':')
    {
        return explode($symbol, $str);
    }

}