<?php
namespace App;

class Controller
{
    public function __construct()
    {
        require_once __DIR__ . '/helpers.php';
    }

    protected function render($view, $data = [], $layout = 'Layout/layout')
    {
        // Ekstrak data untuk view
        extract($data);

        // Path view (tanpa '..')
        $viewPath = __DIR__ . '/Views/' . $view . '.php';

        // Cek apakah file view ada
        if (file_exists($viewPath)) {
            // Jika layout tidak null dan file layout ada
            if ($layout !== null) {
                $layoutPath = __DIR__ . '/Views/' . $layout . '.php';
                
                if (file_exists($layoutPath)) {
                    // Mulai output buffering untuk menangkap output view
                    ob_start();
                    include $viewPath;
                    $content = ob_get_clean(); // Menyimpan konten view

                    // Kirim data ke layout, termasuk konten view
                    include $layoutPath;
                } else {
                    throw new \Exception("Layout not found: " . $layoutPath);
                }
            } else {
                // Jika layout tidak ingin digunakan, langsung tampilkan view
                include $viewPath;
            }
        } else {
            throw new \Exception("View not found: " . $viewPath);
        }
    }
}

