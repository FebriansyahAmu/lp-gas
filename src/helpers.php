<?php

// Fungsi untuk memanggil komponen
function component($name, $data = []) {
    $componentpath = __DIR__ . '/Views/components/' . $name . '.php';
    if (file_exists($componentpath)) {
        // Ekstrak data untuk komponen
        extract($data);
        include $componentpath;
    } else {
        // Jika DEBUG diaktifkan, tampilkan pesan error
        if (defined('DEBUG') && DEBUG) {
            echo "Component not found: " . htmlspecialchars($name);
        }
    }
}

function imgUrl($path = '') {
    return 'img/' . ltrim($path, '/');
}
