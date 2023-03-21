<?php
require_once("configs/DBConnection.php");
include("models/Category.php");
class CategoryService{
    public function getAllCategorys(){
        // 4 bước thực hiện
       $dbConn = new DBConnection();
       $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql = "SELECT * FROM theloai";
        $stmt = $conn->query($sql);

        // B3. Xử lý kết quả
        $categorys = [];
        while($row = $stmt->fetch()){
            $category = new Category($row['ma_tloai'], $row['ten_tloai'], $row['SLBaiViet']);
            array_push($categorys,$category);
        }
        // Mảng (danh sách) các đối tượng Article Model

        return $categorys;
    }

    public function addCategory($ten_tloai){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "insert into theloai (ten_tloai) values('$ten_tloai');";
        
        $result = $conn->query($sql);
        if($result){
            return true;
        }else{
            return false;
        }

    }

    public function findCategoryById($ma_tloai){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT * FROM theloai WHERE ma_tloai = '$ma_tloai'";
        $result = $conn ->query($sql);
        return $result;

    }
    public function editCategory($ma_tloai, $ten_tloai){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "UPDATE theloai SET ten_tloai = '$ten_tloai' Where ma_tloai = '$ma_tloai'";

        $result = $conn -> query($sql);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function deleteCategory($ma_tloai){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "delete from theloai where ma_tloai = '$ma_tloai'";
        $result = $conn ->query($sql);
        if($result){
            return true;
        }else{
            return false;
        }


    }
    public function countCategory(){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT COUNT(ma_tloai) as count FROM theloai";
        $result = $conn ->query($sql);
        while ($row = $result->fetch()) {
            $count = strval($row['count']);
        }
        return $count;
    }
    
}
?>