<?php

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
       if (strlen($name) < 4 || strtoupper($name[0]!==$name[0])) {
            $errors['name'] = 'Имя должно начинаться с большой буквы и не менее 3 букв';
        }
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           $errors['email'] = 'Введен некорректный Email';
     } else {
         $pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');
         $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
         $stmt->execute(['email' => $email]);
         $result = $stmt->fetch();
         if (!empty($result)) {
             $errors['email'] = 'Email  уже занят';
         }
     }

     if (preg_match('((?=.*\d)(?=.*[a-z])(?=.*[A-Z]x`).{8,})', $password))  {
         $errors ['password']= 'Пароль должен содержать минимум 6 символов: английские буквы, цифры и символы';
     }

     if ($passwordRep!==$password){
         $errors['passwordRep'] = 'Пароли не совпадают';
     }

if (empty($errors)) {
    $pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');

// $pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
    $password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch();

//  print_r($result);

}

require_once './get_registration.php';



