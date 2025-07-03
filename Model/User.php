<?php

namespace Model;

use Model\Connection;

use PDO;
use PDOException;
use Exception;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    //FUNÇÃO DE INSERÇÃO DE USUÁRIO
    public function post($user_fullname, $email, $password)
    {

        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO user (user_fullname, email, password, created_at) VALUES (:user_fullname, :email, :password, NOW())";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":user_fullname", $user_fullname, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);


            $execute = $stmt->execute();

            if($execute) {
                return true;
            } else {
                return throw new Exception("Erro ao inserir os dados do usuário");
            }

        } catch (PDOException $error) {
            echo "Erro de execução " . $error->getMessage();
            return false;
        }
    }

    public function getUserByEmail($email):string {
        try{
            $sql = "SELECT * FROM user WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare(query: $sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $error){
            return "Erro ao pagar informações: ". $error->getMessage();
        }
    }

public function getUserInfo($user_fullname, $email):string{
    try{
        $sql="SELECT user_fullname, email FROM user WHERE id= :id";
 
        $stmt = $this->db->prepare(query: $sql);
 
        $stmt->bindParam(":user_fullname", $user_fullname, PDO::PARAM_STR);
 
        $stmt->bindParam(":email",email, PDO::PARAM_STR);
 
        $stmt->execute();
    }catch(PDOException $error){
        return "Erro ao buscar e-mail".$error->getMessage();
    }
} 
}
?>