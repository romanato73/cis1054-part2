<?php

class Database
{
    /**
     * @var array Current table.
     */
    private static array $table = [];

    /**
     * @var array Current query.
     */
    private array $query = [];

    /**
     * Load the table (file) into variable.
     *
     * @param string $name
     * @return static
     */
    public static function table(string $name): static
    {
        self::$table = json_decode(file_get_contents(__DIR__ . "/../database/$name.json"));

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
        foreach (self::$table as $row) {
            if ($this->compare($row->$column, $value, $operator)) {
                $this->query[] = $row;
            }
        }

        return $this;
    }

    /**
     * Get row(s) from table.
     * If id is not set return all rows
     * otherwise return one row with specific id.
     *
     * @param int|null $id
     * @return array|mixed|null
     */
    public function get(int $id = null): mixed
    {
        if (is_null($id)) {
            if (!empty($this->query)) {
                return $this->query;
            }

            return self::$table;
        }

        foreach (self::$table as $row) {
            if ($row->id === $id) return $row;
        }

        die("Row with id '$id' does not exist.");
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
        switch ($op) {
            case '==': return $val1 == $val2;
            case '>': return $val1 > $val2;
            case '<': return $val1 < $val2;
            case '>=': return $val1 >= $val2;
            case '<=': return $val1 <= $val2;
            case '!=': return $val1 != $val2;
            case '===': return $val1 === $val2;
            case '!==': return $val1 !== $val2;
            default: return false;
        }
    }
}