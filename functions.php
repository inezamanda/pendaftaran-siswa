<?php
    // koneksi ke database 
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "pweb";

    $conn = mysqli_connect($host, $username, $password, $database);

    function debug($data){
        var_dump($data);
        die;
    }

    // Bikin fungsi query sendiri
    function query($query){
        global $conn;
        $result = mysqli_query($conn, $query);
        // buat nyimpen per-row
        
        $rows = []; 
        while ($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows; 
    }

    function upload(){
        $nama = $_FILES["image"]["name"];
        $ukuran = $_FILES["image"]["size"];
        $error = $_FILES["image"]["error"];
        $tmpName = $_FILES["image"]["tmp_name"];
        // debug($tmpName);
        // cek apakah ada gambar yang diupload
        if($error === 4){
            echo "<script>
                    alert('Upload gambar telerbih dahulu')
                </script>";
            return false;
        }

        // cek apakah  yang diupload adalah gambar
        $extValid = ["jpg", "jpeg", "png"];
        $extFiles = explode(".", $nama);
        $extFiles = strtolower(end($extFiles));
        // debug($extFiles);
        if(!in_array($extFiles, $extValid)){
            echo "<script>
                    alert('Tolong hanya upload gambar')
                </script>";
            return false;
        }

        // cek jika ukurannya terlalu besar
        if($ukuran > 1000000){
            echo "<script>
                    alert('Ukuran file terlalu besar')
                </script>";
            return false;
        }

        $newNama = uniqid();
        $newNama .= "." . $extFiles;

        move_uploaded_file($tmpName, "./img/" . $newNama);

        return $newNama;
    }

    function insert($data){
        global $conn;

        // ambil data dari tiap input
        $name = htmlspecialchars($data["name"]);
        $address = htmlspecialchars($data["address"]);
        $gender = htmlspecialchars($data["gender"]);
        $religion = htmlspecialchars($data["religion"]);
        $school_origin = htmlspecialchars($data["school_origin"]);
        
        // upload files 
        $img = upload();

        if(!$img){
            return false;
        }

        //query insert data
        $query = "INSERT INTO students (name, address, gender, religion, school_origin, image) VALUES 
            ('$name', '$address', '$gender', '$religion', '$school_origin', '$img')";
        mysqli_query($conn, $query);
        
        // debug($school_origin);
        return mysqli_affected_rows($conn);
    }

    function update($data, $id){
        global $conn;

        // ambil data dari tiap input
        $name = htmlspecialchars($data["name"]);
        $address = htmlspecialchars($data["address"]);
        $gender = htmlspecialchars($data["gender"]);
        $religion = htmlspecialchars($data["religion"]);
        $school_origin = htmlspecialchars($data["school_origin"]);
        $old_image = htmlspecialchars($data["image"]);
        
        if($_FILES["image"]["error"] === 4){
            $image = $old_image;
        }else{
            $image = upload();
        }
        
        //query update data
        $query = "UPDATE students SET 
                    name='$name',
                    address='$address',
                    gender='$gender',
                    religion='$religion',
                    school_origin='$school_origin',
                    image='$image'
                WHERE id=$id";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function delete($id){
        global $conn;
        mysqli_query($conn, "DELETE FROM students WHERE id=$id");
        return mysqli_affected_rows($conn);
    }
