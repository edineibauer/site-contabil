<?php
if (!empty($dados['usuarios_id']) && is_numeric($dados['usuarios_id'])) {
    $read = new \Conn\Read();
    $read->exeRead("usuarios", "WHERE id = :id", "id={$dados['usuarios_id']}");
    if($read->getResult()) {
        $user = $read->getResult()[0];
        $del = new \Conn\Delete();
        $del->exeDelete("usuarios", "WHERE id = :id", "id={$dados['usuarios_id']}");
        new \Entity\React("delete", "usuarios", $user, $user);
    }
}