<?php
include_once "../base.php";

if (!empty($_FILES['img']['tmp_name'])) {
    // 先上傳
    move_uploaded_file($_FILES['img']['tmp_name'], "../img/" . $_FILES['img']['name']);
    // 再依那個按鈕的id去撈出資料
    $data=$DB->find($_POST['id']);
    // 然後將撈出的資料陣列中，key為img的資料更新為這次上傳的檔名
    $data['img']=$_FILES['img']['name'];
    // 再存進去
    $DB->save($data);
}

to("../back.php?do=" . $DB->table);
