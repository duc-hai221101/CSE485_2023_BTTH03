<?php
require_once("configs/DBConnection.php");
require_once("models/User.php");
class UserService
{
    public function getAllUsers()
    {
        // 4 bước thực hiện
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql = "SELECT * FROM users";
        $stmt = $conn->query($sql);

        // B3. Xử lý kết quả
        $users = [];
        while ($row = $stmt->fetch()) {
            $user = new Member($row['id'], $row['name'], $row['email'], $row['username'], $row['password'], $row['is_admin']);
            array_push($users, $user);
        }
        // Mảng (danh sách) các đối tượng Article Model

        return $users;
    }
    public function countUser()
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT COUNT(id) as count FROM users";
        $result = $conn->query($sql);
        while ($row = $result->fetch()) {
            $count = strval($row['count']);
        }
        return $count;
    }

    public function addMember($name, $email, $user, $pass, $is_admin)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql = "INSERT INTO users VALUES ('','$name','$email','$user','$pass','$is_admin')";
        $stmt = $conn->query($sql);
        if ($stmt) {
            return true;
        } else {
            echo "lỗi";
        }
    }
    public function checkLogin($username)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);
        $users = [];
        while ($row = $result->fetch()) {
            $user = new User($row['id'], $row['username'], $row['password'], $row['is_admin']);
            array_push($users, $user);
        }


        return $users;
    }

    public function findUserById($id){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = $conn ->query($sql);
        return $result;

    }
    public function getAllis_admin()
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SHOW COLUMNS FROM users WHERE Field='is_admin'";
        $stmt = $conn->query($sql);
        while ($row = $stmt->fetch()) {
            $enum_list = explode(",", str_replace("'", "", substr($row['Type'], 5, (strlen($row['Type']) - 6))));
        }

        return $enum_list;
    }
    public function editMember($id, $name, $email, $user, $pass, $is_admin)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        $sql = "UPDATE users SET  name='$name' , email='$email', username='$user', password='$pass',is_admin='$is_admin' WHERE id='$id'";
        $stmt = $conn->query($sql);
        if ($stmt) {
            return true;
        } else {
            echo "lỗi";
        }
    }

    public function deleteUser($id)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        $sql = "DELETE from users where id = '$id';";
        $stmt = $conn->query($sql);
        if ($stmt) {
            return true;
        }
        return false;
    }
    public function signupMember($name, $email, $user, $pass, $is_admin)
    {

        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        $sql = "INSERT INTO users VALUES ('','$name','$email','$user','$pass','$is_admin')";
        $stmt = $conn->query($sql);
        if ($stmt) {
            return true;
        } else {
            echo "lỗi";
        }
    }
}
