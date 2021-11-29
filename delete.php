<?php 
     // connect file index sama utilities 
    require "functions.php";

    if(delete($_GET["id"]) > 0){
        echo "
            <script>
                alert('data berhasil dihapus!');
                document.location.href = './student-list.php';
            </script>
        ";
    }else{
        echo "
            <script>
                alert('data gagal dihapus!');
                document.location.href = './student-list.php';
            </script>
        ";
    }