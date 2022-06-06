<?php

namespace App;

class Database
{
    /**
     * @var array Current table.
     */
    private static array $table = [];

    /**
     * @var array Current query.
     */
    private static array $query = [];

    /**
     * @var array Relationship tables.
     */
    private static array $relationship = [];

    /**
     * Load the table (file) into variable.
     *
     * @param string $name
     * @return static
     */
    public static function table(string $name): static
    {
        self::$table = self::loadFile($name);

        self::$query = self::$table;

        return new static();
    }

    /**
     * Extract data that match the condition.
     *
     * @param  string  $column
     * @param  string  $operator
     * @param  string  $value
     * @return $this
     */
    public function where(string $column, string $operator, string $value): static
    {
        foreach (self::$query as $key => $row) {
            if (!$this->compare($row->$column, $value, $operator)) {
                unset(self::$query[$key]);
            }
        }

        return $this;
    }

    /**
     * Add relationship to data.
     *
     * @param  string  $table
     * @param  string  $foreignKey
     * @return $this
     */
    public function with(string $table, string $foreignKey): static
    {
        $relationship = self::relationship($table);
        $relationshipKey = substr($foreignKey, 0, strpos($foreignKey, '_id'));

        foreach (self::$query as $key => $row) {
            $temp = clone $row;
            $temp->$relationshipKey = $relationship[$table][$row->$foreignKey];
            self::$query[$key] = $temp;
        }

        return $this;
    }

    /**
     * Get row(s) from table.
     * If id is not set return all rows
     * otherwise return one row with specific id.
     *
     * @param int|array|null $id
     * @return array|mixed|null
     */
    public function get(int|array $id = null): mixed
    {
        if (is_null($id)) {
            return static::$query;
        }

        if (is_array($id)) {
            foreach (self::$query as $key => $row) {
                if (!in_array($row->id, $id, true)) {
                    unset(self::$query[$key]);
                }
            }

            return self::$query;
        }

        foreach (self::$query as $row) {
            if ($row->id === $id) {
                return $row;
            }
        }

        return null;
    }

    /**
     * Compare two vales with specified operator.
     *
     * @param $val1
     * @param $val2
     * @param $op
     * @return bool
     */
    private function compare($val1, $val2, $op): bool
    {
        return match ($op) {
            '==' => $val1 == $val2,
            '>' => $val1 > $val2,
            '<' => $val1 < $val2,
            '>=' => $val1 >= $val2,
            '<=' => $val1 <= $val2,
            '!=' => $val1 != $val2,
            '===' => $val1 === $val2,
            '!==' => $val1 !== $val2,
            default => false,
        };
    }

    /**
     * Load relationship tables.
     *
     * @param  string  ...$tables
     * @return array
     */
    private static function relationship(string ...$tables): array
    {
        foreach ($tables as $table) {
            self::$relationship[$table] = [];

            $temp = self::loadFile($table);

            foreach ($temp as $row) {
                self::$relationship[$table][$row->id] = $row;
            }
        }

        return self::$relationship;
    }

    /**
     * Load database file.
     *
     * @param  string  $name
     * @return mixed|void
     */
    private static function loadFile(string $name)
    {
        $path = __DIR__."/../storage/database/$name.json";

        if (!file_exists($path)) {
            die("Error loading '$name' table.");
        }

        return json_decode(file_get_contents($path));
    }
}