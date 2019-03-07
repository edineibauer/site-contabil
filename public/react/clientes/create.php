<?php

if(!empty($dados['senha'])) {
    $user = [
        "nome" => $dados['razao_social'],
        "email" => $dados['email'],
        "password" => $dados['senha'],
        "setor" => 4,
        "nivel" => 1,
        "status" => $dados['ativo']
    ];

    $read = new \Conn\Read();
    $read->exeRead("usuarios", "WHERE nome = :n", "n={$user['nome']}");
    $user['nome'] = $user['nome'] . ($read->getResult() ? strtotime('now') : "");
    $user["nome_usuario"] = \Helpers\Check::name($user['nome']);

    $id = \Entity\Entity::add("usuarios", $user);

    if(is_numeric($id)) {
        $up = new \Conn\Update();
        $up->exeUpdate("clientes", ['usuarios_id' => $id], "WHERE id = :id", "id={$dados['id']}");
    }
}