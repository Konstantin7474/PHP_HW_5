<?php

namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Render;
use Geekbrains\Application1\Models\User;

class UserController
{
    public function actionSave()
    {
        $name = $_GET["name"] ?? null;
        $birthday = $_GET["birthday"] ?? null;

        if ($name &&  $birthday) {
            $birthdayTimestamp = strtotime($birthday);
            $user = new User($name, $birthdayTimestamp);


            if ($user->save()) {
                return "Пользователь добавлен";
            } else {
                return "Ошибка при сохранении пользователя";
            }
        } else {
            return "Недостаточно данных для добавления";
        }
    }

    public function actionIndex()
    {
        $users = User::getAllUsersFromStorage();

        $render = new Render();

        if (!$users) {
            return $render->renderPage(
                'user-empty.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден"
                ]
            );
        } else {
            return $render->renderPage(
                'user-index.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users
                ]
            );
        }
    }
}
