<?php

if(empty($dados['usuarios_id']) && !empty($dados['senha'])) {
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

} elseif(!empty($dados['usuarios_id'])) {

    $read = new \Conn\Read();
    $read->exeRead("usuarios", "WHERE id = :id", "id={$dados['usuarios_id']}");
    if($read->getResult()) {
        $user = $read->getResult()[0];
        $user["nome"] = $dados['razao_social'];
        $user["email"] = $dados['email'];
        $user["status"] = $dados['ativo'];

        $read->exeRead("usuarios", "WHERE nome = :n", "n={$user['nome']}");
        if($read->getResult()) {
            $data['error'] = "Nome de Usuário já Existe";
        } else {
            $user["nome_usuario"] = \Helpers\Check::name($user['nome']);

            if(!empty($dados['senha']))
                $user["password"] = $dados['senha'];

            $up = new \Conn\Update();
            $up->exeUpdate("usuarios", $user, "WHERE id = :id", "id={$dados['usuarios_id']}");
            $react = new \Entity\React("update", "usuarios", $user);
            $dd = $react->getResponse();
            if(!empty($dd['error']))
                $data['error'] = $dd['error'];
        }
    }
}