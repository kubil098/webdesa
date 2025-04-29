<?php
    session_start(); //inisialisasi session
    if(session_destroy()) {//menghapus session
        header("Location: /day2/rai12/register/login.php"); //jika berhasil maka akan diredirect ke file index.php
    }
?>