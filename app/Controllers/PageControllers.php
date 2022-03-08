<?php

namespace App\Controllers;

use App\Views\View;

class PageControllers
{
    public function main(): View
    {
        if (SessionControllers::isAuthorized()) {
            return new View('/main', [
                'authorized' => true,
                'userName' => $_SESSION['name']
            ]);
        } else {
            return new View('/main', []);
        }
    }
}