<?php

require_once './../Model/User.php';
class UserController
{
    public function getRegistrate()
    {
        require_once './../View/get_registration.php';
    }
    public function registrate()
    {
        $errors = $this->validateRegistration();

        if (empty($errors)) {
            $pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordRep = $_POST['passwordRep'];
            $name = $_POST['name'];

// $pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
            $password = password_hash($password, PASSWORD_DEFAULT);
            $userModel = new User();
            $userModel->create($name, $email, $password);

            header("location: /login");
//  print_r($result);
        }
        require_once './../View/get_registration.php';
    }

    private function validateRegistration (): array
    {

        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        }
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
        }
        if (isset($_POST['psw'])) {
            $password = $_POST['psw'];
        }
        if (isset($_POST['psw-repeat'])) {
            $passwordRep = $_POST['psw-repeat'];
        }

        $errors= [];
        if (strlen($name) < 4 || strtoupper($name[0] !== $name[0])) {
            $errors['name'] = 'Имя должно начинаться с большой буквы и не менее 3 букв';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введен некорректный Email';
        } else {
            $userModel = new User();
            $result = $userModel-> getByEmail($email);
            if (!empty($result)) {
                $errors['email'] = 'Email  уже занят';
            }
        }

        if (preg_match('((?=.*\d)(?=.*[a-z])(?=.*[A-Z]x`).{8,})', $password))  {
            $errors ['password']= 'Пароль должен содержать минимум 6 символов: английские буквы, цифры и символы';
        }

        if ($passwordRep !== $password){
            $errors['passwordRep'] = 'Пароли не совпадают';
        }
        return $errors;
    }

    public function getLogin()
    {
        require_once './../View/get_login.php';

    }

    public function logout()

    {
        require_once './../View/logout.php';
    }

    public function login()
    {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors = [];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введен некорректный Email';
        }

        if (preg_match('((?=.*\d)(?=.*[a-z])(?=.*[A-Z]x`).{8,})', $password)) {
            $errors ['password'] = 'Пароль должен содержать минимум 6 символов: английские буквы, цифры и символы';
        }

        if (empty($errors)) {
            $pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');

            $userModel = new User();
            $user = $userModel-> getByEmail($email);

            if ($user === null) {
                $errors['email'] = 'Пользователя с таким EMAIL не существует';
            } else {
                if (password_verify($password, $user['password'])) {
//            setcookie('user_id', $user['id']);

                    $_SESSION['user_id'] = $user['id'];

                    header("location: /main");
                } else {
                    echo $errors['password'] = 'Пароль указан неверно';
                    header("location: /login");
                }


            }
//            require_once "./../View/get_login.php";
        }

    }



}