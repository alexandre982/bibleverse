<?php
namespace App\Controllers;

abstract class AbstractController
{
    protected function render(string $view, array $data = []): void
    {
        array_walk_recursive($data, function (&$v) {
            if (is_string($v)) {
                $v = htmlspecialchars($v);
            }
        });

        extract($data);

        $viewFile = __DIR__ . '/../Views/' . $view;

        require __DIR__ . '/../Views/layout.php';
    }

    protected function redirect(string $route): void
    {
        header('Location: index.php?route=' . $route);
        exit;
    }
}
