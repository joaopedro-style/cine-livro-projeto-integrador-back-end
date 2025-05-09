<?php
require_once "conecta.php";

function listarUsuarios(PDO $conexao):array {
    $sql = "SELECT id, nome, email,data_nascimento FROM usuarios ORDER BY nome";

    try {
    
    $consulta = $conexao->prepare($sql);

    $consulta->execute();

    return $consulta->fetchALL(PDO::FETCH_ASSOC);
    } catch (Exception $erro) {
        die("Erro: ".$erro->getMessage());
    }

    

}

function cadastrarUsuario(PDO $conexao, string $nome, string $email, string $senha, string $data_nascimento):void{

    $sql = "INSERT INTO usuarios (nome, email, senha, data_nascimento) VALUES(:nome, :email, :senha, :data_nascimento)";

    try {
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":nome", $nome, PDO::PARAM_STR);
        $consulta->bindValue(":email", $email, PDO::PARAM_STR);
        $consulta->bindValue(":senha", $senha, PDO::PARAM_STR);
        $consulta->bindValue(":data_nascimento", $data_nascimento, PDO::PARAM_STR);
        $consulta->execute();
    } catch (Exception $erro) {
        die("Erro ao cadastrar: ".$erro->getMessage());
    }
}

function listarUmUsuario(PDO $conexao, int $idUsuario):array {
    $sql = "SELECT * FROM usuarios WHERE id = :id";

    try {
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":id", $idUsuario, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $erro) {
        die("Erro ao carregar usuario: ".$erro->getMessage());
    }
}

function atualizarUsuario(
    PDO $conexao, int $idUsuario, string $nome, string $email, string $senha, string $data_nascimento
    ): void {
    $sql = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, data_nascimento = :data_nascimento WHERE id = :id";

    try {
        $consulta = $conexao->prepare($sql);
        $consulta->bindvalue(":nome", $nome, PDO::PARAM_STR);
        $consulta->bindvalue(":email", $email, PDO::PARAM_STR);
        $consulta->bindvalue(":senha", $senha, PDO::PARAM_STR);
        $consulta->bindvalue(":data_nascimento", $data_nascimento, PDO::PARAM_STR);
        $consulta->bindvalue(":id", $idUsuario, PDO::PARAM_INT);
        $consulta->execute();
    } catch (Exception $erro) {
        die("Erro ao atualizar Usuario: ".$erro->getMessage());
    }
}

function excluirUsuario(PDO $conexao, int $idUsuario): void {
    $sql = "DELETE FROM usuarios WHERE id = :id";

    try {
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":id", $idUsuario, PDO::PARAM_INT);
        $consulta->execute();
    } catch (Exception $erro) {
        die("Erro ao excluir usuario: ".$erro->getMessage());
    }
}