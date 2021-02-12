<?php


namespace Core\Repository;


use Core\Database\Database;

abstract class ARepository
{
    abstract protected function getEntity(): string;

    protected function getEntityClass(): string
    {
        $split = explode('\\', $this->getEntity());
        return $split[count($split) - 1];
    }

    public function findAll(): array
    {
        return Database::getDatabase()->query(
            'SELECT * FROM ' . $this->getEntityClass()
            , [], $this->getEntity());
    }

    public function findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null): array
    {
        $parameters = [];

        $whereSql = '';
        if (count($criteria) > 0) {
            $whereSql = ' WHERE ';

            $first = true;
            foreach ($criteria as $column => $value) {
                if (!$first) {
                    $whereSql .= ' AND ';
                }
                $whereSql .= '`' . $column . '`' . '=:' . 'where_' . $column . '';
                $parameters['where_' . $column] = $value;

                $first = false;
            }
        }

        $limitOffsetSql = ($limit) ? ' LIMIT ' . $limit : '';
        $limitOffsetSql .= ($limit && $offset) ? ',' . $offset : '';

        $sql = 'SELECT * FROM ' . $this->getEntityClass() . $whereSql . $limitOffsetSql;

        return Database::getDatabase()->query(
            $sql,
            $parameters,
            $this->getEntity());
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $result = $this->findBy($criteria, $orderBy, 1, 0);

        if (count($result) === 0) {
            return null;
        }

        return $result [0];
    }

    public function insert(array $values)
    {
        $sql = 'INSERT INTO ' . $this->getEntityClass() . " ( ";
        $first = true;
        foreach($values as $column => $value){
            if (!$first) {
                $sql .= ' , ';
            }
            $sql .= $column;

            $first = false;

        }

        $sql .= " ) VALUES ( ";

        $first = true;
        $parameters = [];
        foreach($values as $column => $value){
            if (!$first) {
                $sql .= ' , ';
            }
            $sql .= " ? ";
            array_push($parameters, $value);
            $first = false;

        }
        
        $sql .= ")";

     
        return Database::getDatabase()->query($sql, $parameters, null, false);

    }

    public function deleteBy(array $criteria){
        $parameters = [];

        $whereSql = '';
        if (count($criteria) > 0) {
            $whereSql = ' WHERE ';

            $first = true;
            foreach ($criteria as $column => $value) {
                if (!$first) {
                    $whereSql .= ' AND ';
                }
                $whereSql .= '`' . $column . '`' . '=:' . 'where_' . $column . '';
                $parameters['where_' . $column] = $value;

                $first = false;
            }
        }



        $sql = 'DELETE FROM ' . $this->getEntityClass() . $whereSql ;

        Database::getDatabase()->queryWithoutResult( $sql,$parameters);


    }

    public function update(array $criteria, $setters){
        $parameters = [];

        $settersSql = '';
        if (count($criteria) > 0) {
            $settersSql = ' SET ';

            $first = true;
            foreach ($setters as $column => $value) {
                if (!$first) {
                    $settersSql .= ' , ';
                }
                $settersSql .= '`' . $column . '`' . '=:' . 'set_' . $column . '';
                $parameters['set_' . $column] = $value;

                $first = false;
            }
        }

        $whereSql = '';
        if (count($criteria) > 0) {
            $whereSql = ' WHERE ';

            $first = true;
            foreach ($criteria as $column => $value) {
                if (!$first) {
                    $whereSql .= ' AND ';
                }
                $whereSql .= '`' . $column . '`' . '=:' . 'where_' . $column . '';
                $parameters['where_' . $column] = $value;

                $first = false;
            }
        }



        $sql = 'UPDATE ' . $this->getEntityClass(). $settersSql . ' ' . $whereSql ;

        Database::getDatabase()->queryWithoutResult( $sql,$parameters);


    }
}