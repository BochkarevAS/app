<?php

class UserController {

    public function actionRegistration() {

        $errors = false;

        if (isset($_POST['submit'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!User::checkEmail($email)) {
                $errors[] = 'Не корректный Email !!!';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не может быть меньше трёх символов !!!';
            }

            if (!User::checkExist($email, $password)) {
                $errors[] = 'Email или пароль существует !!!';
            }

            if ($errors == false) {
                User::registration($password, $email);
                header('Location: /user/image');
            }
        }

        require_once(ROOT . '/Resources/views/user/registration.php');

        return true;
    }

    public function actionLogin() {

        $errors = false;

        if (isset($_POST['submit'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!User::checkEmail($email)) {
                $errors[] = 'Не корректный Email !!!';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не может быть меньше трёх символов !!!';
            }

            if (!User::checkExist($email, $password)) {
                $errors[] = 'Email или пароль существует !!!';
            }

            if (!User::login($password, $email)) {
                $errors[] = "Не верный логин или пароль !!!";
            } else {
                header('Location: /user/image');
            }
        }

        require_once(ROOT . '/Resources/views/user/login.php');

        return true;
    }

    public function actionLogout() {
        session_start();
        unset($_SESSION['user']);

        header('Location: /user/login');
    }
}