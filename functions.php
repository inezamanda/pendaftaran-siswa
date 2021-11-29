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

    function insert($data){
        global $conn;

        // ambil data dari tiap input
        $name = htmlspecialchars($data["name"]);
        $address = htmlspecialchars($data["address"]);
        $gender = htmlspecialchars($data["gender"]);
        $religion = htmlspecialchars($data["religion"]);
        $school_origin = htmlspecialchars($data["school_origin"]);
    
        //query insert data
        $query = "INSERT INTO students (name, address, gender, religion, school_origin) VALUES 
            ('$name', '$address', '$gender', '$religion', '$school_origin')";
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
        
        //query update data
        $query = "UPDATE students SET 
                    name='$name',
                    address='$address',
                    gender='$gender',
                    religion='$religion',
                    school_origin='$school_origin'
                WHERE id=$id";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function delete($id){
        global $conn;
        mysqli_query($conn, "DELETE FROM students WHERE id=$id");
        return mysqli_affected_rows($conn);
    }
