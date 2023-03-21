<?php
require_once("configs/DBConnection.php");
include("models/Author.php");
class AuthorService{
    public function getAllAuthors(){
        // 4 bước thực hiện
       $dbConn = new DBConnection();
       $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql = "SELECT * FROM tacgia";
        $stmt = $conn->query($sql);

        // B3. Xử lý kết quả
        $authors = [];
        while($row = $stmt->fetch()){
            $author = new Author($row['ma_tgia'], $row['ten_tgia'], $row['hinh_tgia']);
            array_push($authors,$author);
        }
        // Mảng (danh sách) các đối tượng Article Model

        return $authors;
    }

    public function addAuthor($ten_tgia, $hinh_tgia){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "insert into tacgia (ten_tgia, hinh_tgia) values('$ten_tgia', '$hinh_tgia');";
        
        $result = $conn->query($sql);
        if($result){
            return true;
        }else{
            return false;
        }

    }

    public function findAuthorById($ma_tgia){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT * FROM tacgia WHERE ma_tgia = '$ma_tgia'";
        $result = $conn ->query($sql);

        $findAuthor = [];
        while($row = $result->fetch()){
            $author = new Author($row['ma_tgia'], $row['ten_tgia'], $row['hinh_tgia']);
            array_push($findAuthor,$author);
        }
        return $findAuthor;

    }
    public function editAuthor($ma_tgia, $ten_tgia, $hinh_tgia){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "UPDATE tacgia SET ten_tgia = '$ten_tgia', hinh_tgia = '$hinh_tgia' Where ma_tgia = '$ma_tgia'";

        $result = $conn -> query($sql);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function deleteAuthor($ma_tgia){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "delete from tacgia where ma_tgia = '$ma_tgia'";
        $result = $conn ->query($sql);
        if($result){
            return true;
        }else{
            return false;
        }


    }
    public function countAuthor(){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT COUNT(ma_tgia) as count FROM tacgia";
        $result = $conn ->query($sql);
        while ($row = $result->fetch()) {
            $count = strval($row['count']);
        }
        return $count;
    }
    
}