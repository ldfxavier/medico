<?php
    $dado = $_POST;
    $where = [];

    $data = [];
    if(!empty($dado['data_inicio'])) $data[] = "`data_inicio` >= '".Converter::data($dado['data_inicio'], 'Y-m-d')." 00:00:00'";
    if(!empty($dado['data_final'])) $data[] = "`data_final` <= '".Converter::data($dado['data_final'], 'Y-m-d')." 23:59:59'";
    if($data) $where[] = '('.implode(" AND ", $data).')';



    if(!empty($dado['titulo'])) $where[] = "`titulo` LIKE '%".$dado['titulo']."%'";
    if(!empty($dado['status']) || is_numeric($dado['status'])) $where[] = "`status` = '".$dado['status']."'";

    $where = !empty($where) ? implode(" AND ", $where) : "`id` > '0'";
