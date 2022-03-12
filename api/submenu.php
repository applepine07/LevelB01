<?php
include_once "../base.php";

if (isset($_POST['id'])) {
    foreach ($_POST['id'] as $key => $id) {
        if (isset($_POST['del']) && in_array($id, $_POST['del'])) {
            $Menu->del($id);
        } else {
            $sub = $Menu->find($id);
            $sub['name'] = $_POST['name'][$key];
            $sub['href'] = $_POST['href'][$key];
            $Menu->save($sub);
        }
    }
}

if (isset($_POST['name2'])) {
    foreach ($_POST['name2'] as $key => $name) {
        if ($name != '') {
            $Menu->save([
                'name' => $name,
                'href' => $_POST['href'][$key],
                'sh' => 1,
                'parent' => $_GET['main']
            ]);
        }
    }
}

to("../back.php?do=$Menu->table");