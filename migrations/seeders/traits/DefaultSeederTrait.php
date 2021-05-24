<?php


namespace migrations\seeders\traits;


trait DefaultSeederTrait
{
    abstract protected function getRows();
    abstract protected function getTable();
    abstract protected function getPDO();
    abstract protected function getDB();

    private int $sqlLengthLimit = 2097152; // 2^21 - empirical number

    protected function defaultRun($insertItems = 400, $eachTickFunction = null) {
        $sql = '';
        $table = $this->getTable();
        $rows = $this->getRows();
        $i = 0;
        while (($currentTickRows = array_slice($rows, $i * $insertItems, $insertItems)) !== []) {
            $i++;
            foreach ($currentTickRows as $index => $row)
            {
                if(isset($row['id'])) {
                    unset($currentTickRows[$index]['id']);
                }

            }
            if($currentTickRows !== []) {
                if(count($currentTickRows) === 1) {
                    $this->insertSQL($currentTickRows[0]);
                } else {
                    $this->insertSQL($currentTickRows);
                }
            }


            if($eachTickFunction !== null) {
                $eachTickFunction();
            }
        }

    }

    private function insertSQL($data) {
        try {
            $this->getDB()->table($this->getTable())->insert($data);

        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}