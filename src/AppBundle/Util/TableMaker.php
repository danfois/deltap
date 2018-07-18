<?php

namespace AppBundle\Util;


class TableMaker
{

    const DEFAULT_TABLE = '<table class="table m-table m-table--head-separator-primary">';

    private $associations;
    private $data;

    private $tableStart;
    private $tableHead;
    private $tableBody;
    private $tableEnd;

    private $table;

    public function __construct(string $option, array $data, array $associations)
    {
        $this->tableStart = $option;
        $this->associations = $associations;
        $this->data = $data;
    }

    public function createTable()
    {
        $this->createTableHead();
        $this->createTableBody();
        $this->composeTable();

        return $this;
    }

    private function createTableHead()
    {
        $this->tableHead .= '<thead><tr>';

        foreach($this->associations as $k => $v) {
            $this->tableHead .= '<th>' . $k . '</th>';
        }

        $this->tableHead .= '</thead></tr>';
    }

    public function getTable()
    {
        return $this->table;
    }

    private function composeTable()
    {
        $this->table .= $this->tableStart;
        $this->table .= $this->tableHead;
        $this->table .= $this->tableBody;
        $this->table .= $this->tableEnd;
    }

    private function createTableBody()
    {
        foreach($this->data as $key => $value) {
            $this->tableBody .= '<tr>';
            foreach ($this->associations as $k => $v) {
                $methodName = 'get'.$this->convertValueToMethod($v);
                $this->tableBody .= '<td>'.$value->$methodName().'</td>';
            }
            $this->tableBody .= '</tr>';
        }
    }

    private function convertValueToMethod($v)
    {
        $v = str_replace('_', ' ', $v);
        $v = ucwords($v);
        $v = str_replace(' ', '', $v);
        return $v;
    }
}