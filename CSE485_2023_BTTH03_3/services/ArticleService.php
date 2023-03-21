<?php
require_once("configs/DBConnection.php");
include("models/Article.php");
class ArticleService
{
    public function getAllArticles()
    {
        // 4 bước thực hiện
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        // B2. Truy vấn
        $sql = "SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat, theloai.ten_tloai, baiviet.tomtat, baiviet.noidung, tacgia.ten_tgia, baiviet.ngayviet, hinhanh 
        FROM baiviet, theloai, tacgia
        Where baiviet.ma_tloai = theloai.ma_tloai AND baiviet.ma_tgia = tacgia.ma_tgia";
        $stmt = $conn->query($sql);
        // B3. Xử lý kết quả
        $articles = [];
        while ($row = $stmt->fetch()) {
            $article = new Article($row['ma_bviet'], $row['tieude'], $row['ten_bhat'], $row['ten_tloai'], $row['tomtat'], $row['noidung'], $row['ten_tgia'], $row['ngayviet'], $row['hinhanh']);
            array_push($articles, $article);
        }
        // Mảng (danh sách) các đối tượng Article Model
        return $articles;
    }
    public function addArticle($tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $hinhanh)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        $sql = "insert into baiviet (tieude,ten_bhat,ma_tloai,tomtat,noidung,ma_tgia,ngayviet,hinhanh) values('$tieude','$ten_bhat','$ma_tloai','$tomtat','$noidung','$ma_tgia','$ngayviet','$hinhanh');";
        $result = $conn->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function findArticleById($ma_bviet){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat, theloai.ten_tloai, baiviet.tomtat, baiviet.noidung, tacgia.ten_tgia, baiviet.ngayviet, hinhanh 
        FROM baiviet, theloai, tacgia
        Where baiviet.ma_tloai = theloai.ma_tloai AND baiviet.ma_tgia = tacgia.ma_tgia AND ma_bviet = '$ma_bviet'";
        $result = $conn ->query($sql);
        $findArticle = [];
        while ($row = $result->fetch()) {
            $article = new Article($row['ma_bviet'], $row['tieude'], $row['ten_bhat'], $row['ten_tloai'], $row['tomtat'], $row['noidung'], $row['ten_tgia'], $row['ngayviet'], $row['hinhanh']);
            array_push($findArticle,$article);
        }
        return $findArticle;
    }
    public function editArticle($ma_bviet, $tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $hinhanh)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        $sql = "UPDATE baiviet SET tieude='$tieude',ten_bhat='$ten_bhat',ma_tloai='$ma_tloai',tomtat='$tomtat',noidung='$noidung',ma_tgia='$ma_tgia',ngayviet='$ngayviet',hinhanh='$hinhanh' WHERE ma_bviet='$ma_bviet'";
        $result = $conn->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteArticle($ma_bviet){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "delete from baiviet where ma_bviet = '$ma_bviet'";
        $result = $conn ->query($sql);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function countArticle(){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT COUNT(ma_bviet) as count FROM baiviet";
        $result = $conn ->query($sql);
        while ($row = $result->fetch()) {
            $count = strval($row['count']);
        }
        return $count;
    }
}
?>