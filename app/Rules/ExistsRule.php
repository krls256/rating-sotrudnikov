<?php


namespace app\Rules;


use database\Database;
use Illuminate\Contracts\Validation\Rule;

class ExistsRule implements Rule
{
    protected Database $db;
    protected string $table;
    protected string $column;
    public function __construct( $table, $column) {
        $this->db = getDatabase();
        $this->table = $table;
        $this->column = $column;
    }

    public function passes($attribute, $value)
    {
        $row = $this->db->getDB()->table($this->table)->where($this->column, $value)->first();
        return (bool) $row;
    }

    public function message()
    {
        return "Данного :attribute не существует";
    }

}