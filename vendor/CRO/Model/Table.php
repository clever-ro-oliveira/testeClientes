<?php

namespace CRO\Model;


abstract class Table
{
    protected $db;
    protected $table;

    public function __construct(\mysqli $db)
    {
        $this->db = $db;
    }

    public function fetchAll($ordem = "")//retorna um array associativo
    {
        $order = $ordem ? " ORDER BY {$ordem} " : "";
        $query = "SELECT * FROM {$this->table} {$order}";
        return $this->db->query($query);
    }

    public function fetchWhere($clausula, $ordem = "")//retorna um array associativo
    {
        $order = $ordem ? " ORDER BY {$ordem} " : "";
        $query = "SELECT * FROM {$this->table} WHERE 1 {$clausula} {$order}";
        return $this->db->query($query);
    }

    public function find($id, $campo = "id")//retorna um único registro do BD
    {
        $query = "SELECT * FROM {$this->table} WHERE {$campo} = '{$id}'";
        return $this->db->query($query)->fetch_assoc();
    }

    public function alteraStatus($status,$id, $coluna = "")
    {
        $coluna = $coluna ? $coluna : "id";
        $query = "UPDATE {$this->table} SET status = '{$status}' WHERE {$coluna} = '{$id}'";
        return $this->db->query($query);
    }

    public function grava($form)
    {
        if($form['id-cond'])
            $sql = executa($this->db, $form, $this->table, "edita", "id = '".$form['id-cond']."'");
        else
            $sql = executa($this->db, $form, $this->table, "inserir", "");

        if($sql)
            return $form['id-cond'] ? $form['id-cond'] : $sql;
        else
            return false;

    }

}