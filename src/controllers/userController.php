<?php
require_once "../config/database.php";
require_once "../classes/user.php";

class UserController
{
    public function index()
    {
        $database = new Database();
        $conn = $database->getConnection();

        $user = new User($conn);
        $result = $user->getAll();

        $user_arr = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $user_item = array(
                "id" => $id,
                "username" => $username,
                "email" => $email
            );

            array_push($user_arr, $user_item);
        }

        http_response_code(200);
        echo json_encode($user_arr);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->username) &&
            !empty($data->email) &&
            !empty($data->password)
        ) {
            $database = new Database();
            $conn = $database->getConnection();

            $user = new User($conn);

            $user->username = $data->username;
            $user->email = $data->email;
            $user->password = password_hash($data->password, PASSWORD_BCRYPT);

            if ($user->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Usuário criado com sucesso."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Não foi possível criar usuário."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Não foi possível criar usuário. Dados incompletos."));
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->username) &&
            !empty($data->email)
        ) {
            $database = new Database();
            $conn = $database->getConnection();

            $user = new User($conn);

            $user->id = $id;
            $user->username = $data->username;
            $user->email = $data->email;

            if ($user->update()) {
                http_response_code(200);
                echo json_encode(array("message" => "Usuário atualizado com sucesso."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Não foi possível atualizar usuário."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Não foi possível atualizar usuário. Dados incompletos."));
        }
    }

    public function delete($id)
    {
        $database = new Database();
        $conn = $database->getConnection();

        $user = new User($conn);

        $user->id = $id;

        if ($user->delete()) {
            http_response_code(200);
            echo json_encode(array("message" => "Usuário deletado com sucesso."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Não foi possível deletar usuário."));
        }
    }
}
?>