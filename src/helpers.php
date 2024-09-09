<?php

// Fungsi untuk memanggil komponen
function component($name){
    $componentpath = __DIR__ . '/Views/components/' . $name . '.php';
    if(file_exists($componentpath)){
        include $componentpath;
    }else{
        if(define('DEBUG') && DEBUG){
            echo "Component not found: " . htmlspecialchars($name);
        }
    }
}

function imgUrl($path = ''){
    return 'img/' . ltrim($path, '/');
}
