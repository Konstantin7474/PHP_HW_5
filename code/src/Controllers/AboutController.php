<?php

namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Models\Phone;
use Geekbrains\Application1\Render;

class AboutController
{
    public function actionIndex() {
        $phone = (new Phone())->getPhone();
        $currentTime = date("Y-m-d H:i:s");
        $render = new Render();

        return $render->renderPage('about.twig', [
            'phone' => $phone,
            'current_time' => $currentTime
        ]);
    }

}