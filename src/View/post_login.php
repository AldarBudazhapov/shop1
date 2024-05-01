<?php

$email = $_POST['email'];
$password = $_POST['password'];

$errors= [];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Введен некорректный Email';
}

if (preg_match('((?=.*\d)(?=.*[a-z])(?=.*[A-Z]x`).{8,})', $password))  {
    $errors ['password']= 'Пароль должен содержать минимум 6 символов: английские буквы, цифры и символы';
}

if (empty($errors)) {
    $pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');

    $stmt = $pdo->prepare("SELECT * FROM  users WHERE email= :email");
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch();

    if ($user === false) {
        $errors['email'] = 'Пользователя с таким EMAIL не существует';
    } else {
        if (password_verify($password, $user['password'])) {
//            setcookie('user_id', $user['id']);
            session_start();
            $_SESSION['user_id'] = $user['id'];
        } else {
            echo $errors['password'] = 'Пароль указан неверно';
        }

    }
}

require_once "./main.php";
