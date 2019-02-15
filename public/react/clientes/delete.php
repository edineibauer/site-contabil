<?php
if (!empty($dados['usuario_id']) && is_numeric($dados['usuario_id'])) {
    $read = new \Conn\Read();
    $read->exeRead("usuarios", "WHERE id = :id", "id={$dados['usuario_id']}");
    if($read->getResult()) {
        $user = $read->getResult()[0];
        $del = new \Conn\Delete();
        $del->exeDelete("usuarios", "WHERE id = :id", "id={$dados['usuario_id']}");
        new \Entity\React("delete", "usuarios", $user, $user);
    }
}