<?php

declare(strict_types=1);

namespace App\Form;

use App\Core\Request;
use App\Entity\User;

class UserType extends AbstractType
{
    public ?int $id = null;

    public string $nickname;

    public string $email;

    public ?string $file;

    public string $password;

    public function handleRequest(Request $request = null, int $id = null)
    {
        $this->id        = $id;
        $this->nickname  = $request->request('nickname');
        $this->email     = $request->request('email');
        $this->file      = $request->file('file');
        $this->password  = $request->request('password');
        $this->submitted = $request->request('submit');

        if ($this->submitted) {
            $this->validate();
        }

        return $this;
    }

    public function validate(): void
    {
        if (!filter_var($this->email , FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Не корректный Email !!!';
        }

        if ('' === $this->nickname) {
            $this->errors[] = 'Nickname не может быть пустым !!!';
        }

        if (3 > strlen($this->password)) {
            $this->errors[] = 'Пароль не может быть меньше трёх символов !!!';
        }

        $user = User::findOneByColumn('nickname', $this->nickname);

        if (null !== $user) {
            if ($this->id !== $user->getId()) {
                $this->errors[] = 'Пользователь с таким nickname уже существует';
            }
        }

        $user = User::findOneByColumn('email', $this->email);

        if (null !== $user) {
            if ($this->id !== $user->getId()) {
                $this->errors[] = 'Пользователь с таким email уже существует';
            }
        }
    }
}