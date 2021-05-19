<?php


namespace migrations\seeders\traits;


trait DefaultSeederTrait
{
    abstract protected function getRows();
    abstract protected function getTable();
    abstract protected function getPDO();
    private $sqlLengthLimit = 2097152; // 2^21 - empirical number
    protected function defaultRun($insertItems = 400, $eachTickFunction = null) {
        $sql = '';
        $table = $this->getTable();
        $rows = $this->getRows();
        $i = 0;
        while (($currentTickRows = array_slice($rows, $i * $insertItems, $insertItems)) !== []) {
            $i++;
            foreach ($currentTickRows as $row)
            {
                $column = array_keys($row);
                $column = array_splice($column, 1);
                $values = array_values($row);
                $values = array_splice($values, 1);
                $values = array_map(function ($item)
                {
                    if ((string)((int)$item) === $item)
                    {
                        return (int)$item;
                    }
                    return "'" . $item . "'";
                }, $values);

                $columnStr = implode(', ', $column);
                $valuesStr = implode(', ', $values);

                $sql .= "INSERT INTO $table ($columnStr) VALUES ($valuesStr); \n";

                if(strlen($sql) > $this->sqlLengthLimit) {
                    $this->insertSQL($sql);
                    $sql = "";
                }
            }
            if($sql !== '') {
                $this->insertSQL($sql);
                $sql = "";
            }
            if($eachTickFunction !== null) {
                $eachTickFunction();
            }
        }

    }

    private function insertSQL($sql) {
        try {
            $req = $this->getPDO()->prepare($sql);
            $req->execute();

        } catch (\Exception $exception) {
            dd($sql, $exception->getMessage());
        }
    }
}