<?php


namespace core;


abstract class Model
{

    /**
     * Table in database that relates of extended class
     */
    protected const TABLE = '';

    /**
     * @var int ID in database row that relates of extended class
     */
    public int $id;


    /**
     * Creating a new instance with the values of row obtained by ID
     * @param int $id ID of row in database
     * @return bool|object Returns Object or FALSE on failure
     */
    public static function selectRow(int $id): object|bool
    {
        $db = Database::instance();

        $sql = 'SELECT * FROM ' . static::TABLE . ' WHERE id=:id';

        return $db->query($sql, [':id' => $id], static::class);
    }


    /**
     * Inserting new row into database that relates of extended class
     * @return string ID of inserted row in database
     */
    protected function insertRow(): string
    {
        $db = Database::instance();

        $columns = [];
        $values = [];

        foreach (get_object_vars($this) as $name => $value) {
            $columns[] = $name;
            $values[":$name"] = $value;
        }

        $sql = 'INSERT INTO ' . static::TABLE
            . ' (' . implode(',', $columns) . ')'
            . ' VALUES'
            . ' (' . implode(',', array_keys($values)) . ')';

        $db->execute($sql, $values);

        return $db->lastInsertId();
    }


    /**
     * Update row that relates of extended class in database
     * @param array $columns Array of columns to be updated. If not specified all fields will be updated
     * @return bool
     */
    public function updateRow($columns = []): bool
    {
        $db = Database::instance();

        if (empty($columns)) {
            foreach (get_object_vars($this) as $name => $value) {
                $columns[] = $name;
            }
        } else {
            $columns[] = 'id';
        }

        $values = [];
        $sql = 'UPDATE ' . static::TABLE . ' SET ';
        foreach ($columns as $name) {
            $values[":$name"] = $this->$name;
            if ('id' === $name) {
                continue;
            }
            $sql .= $name . '=:' . $name . ', ';
        }
        $sql = trim($sql, ', ');
        $sql .= ' WHERE id=:id';

        return $db->execute($sql, $values);
    }
}