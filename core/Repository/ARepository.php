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
}