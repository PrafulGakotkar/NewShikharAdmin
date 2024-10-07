<?php

namespace App\Models;

use CodeIgniter\Model;

class CommonModal extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $session = \Config\Services::session();
    }
    function saveTableData($valueArray, $table)
    {
        $this->db->table($table)->insert($valueArray);
        return $this->db->insertId();
    }
    function getTableData($table, $where)
    {
        return $this->db->table($table)->where($where)->get()->getRow();
    }
    function updateTableData($table, $where, $value)
    {
        $this->db->table($table)->where($where)->update($value);
    }

    function getRowTableData($table, $where)
    {
        return $this->db->table($table)->where($where)->get()->getRow();
    }
    function getRowTableWithOrderData($table, $where, $orderby, $pattern)
    {
        return $this->db->table($table)->where($where)->orderBy($orderby, $pattern)->get()->getRow();
    }
    function getResultData($table)
    {
        return $this->db->table($table)->get()->getResult();
    }
    function getResultWhereData($table, $where)
    {
        return $this->db->table($table)->where($where)->get()->getResult();
    }
    function getResultWhereInData($table, $whereIn)
    {
        return $this->db->table($table)->whereIn($whereIn)->get()->getResult();
    }
    function getResultWhereWithOrderData($table, $where, $orderby, $pattern)
    {
        return $this->db->table($table)->where($where)->orderBy($orderby, $pattern)->get()->getResult();
    }
    function getResultWithOrderData($table,$orderby, $pattern)
    {
        return $this->db->table($table)->orderBy($orderby, $pattern)->get()->getResult();
    }
    function updateStatus($table, $whereArray, $dataArray)
    {
        $this->db->table($table)->where($whereArray)->update($dataArray);
        return 2;
    }
    function updateAllStatus($table, $dataArray)
    {
        $this->db->table($table)->update($dataArray);
        return 2;
    }

    function deleteDataWithWhere($table, $where)
    {
        return $this->db->table($table)->where($where)->delete();
    }
    function bulkUpdateTable($table, $output, $key)
    {
        $this->db->table($table)->updateBatch($output, $key);
        return 2;
    }
    function bulkInsertTable($table, $output)
    {
        $this->db->table($table)->insertBatch($output);
    }
}
