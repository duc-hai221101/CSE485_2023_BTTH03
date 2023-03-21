<?php
require_once 'services/UserService.php';
require_once 'vendor/autoload.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
class UserController
{
    // Hàm xử lý hành động index
    public function index()
    {
    }
    function home()
    {
        $userService = new UserService();
        include "views/home/login.php";
    }
    public function list()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        // echo "Tương tác với Services/Models from Article";
        $userService = new UserService();
        $users = $userService->getAllUsers();
        // Nhiệm vụ 2: Tương tác với View
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('user/list_user.html.twig');
        echo $content->render(array(
            'users' => $users,
        ));
    }
    public function resigter()
    {


        $memberService = new UserService();
        function html_escape($text): string
        {

            $text = $text ?? '';

            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false); // Return escaped string
        }
        if (isset($_POST['signbtn'])) {
            // Lay tu FORM
            $name = html_escape($_POST['txtName']);
            $user = html_escape($_POST['txtUser']);
            $email = html_escape($_POST['txtEmail']);
            $pass = html_escape($_POST['txtPass']);

            try {
                if ($_POST['txtPass'] !== $_POST['txtResetPass']) {
                    echo "Mật khẩu xác nhận không khớp.";
                    exit();
                } else {
                    if (preg_match('/[^\x00-\x7F]/', $_POST['txtUser'])) {
                        $message = "Không được nhập dấu!";
                        echo "<script>alert('$message');</script>";
                    } else {
                        if (strlen($name) > 50) {
                            $message = "Tài khoản không quá 50 ký tự";
                            echo "<script>alert('$message');</script>";
                        } else {
                            if (strlen($email) > 50) {
                                $message = "Email không quá 50 ký tự";
                                echo "<script>alert('$message');</script>";
                            } else {
                                if (strlen($user) > 20) {
                                    $message = "User không quá 20 ký tự";
                                    echo "<script>alert('$message');</script>";
                                } else {
                                    if (strlen($pass) > 255) {
                                        $message = "Pass không quá 255 ký tự";
                                        echo "<script>alert('$message');</script>";
                                    } else {
                                        if (send($email)) {
                                            // Hash mật khẩu
                                            $message = "Đăng ký thành công";
                                            echo "<script>alert('$message');</script>";
                                            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
                                            $result = $memberService->signupMember($name, $email, $user,  $hashed_password, 0);

                                            if ($result) {
                                                header('location:/CSE485_2023_BTTH02/index.php?controller=member&action=home');
                                            } else {
                                                echo "Email could not be sent.";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                echo "Tồn tại!";
            }
        }

        include "views/member/add_member.php"; 
    }
    
    public function edit()
    {
        $userService = new UserService();
        $findUser = $userService ->findUserById($_GET['id']);
        function html_escape($text): string
        {

            $text = $text ?? '';

            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false); // Return escaped string
        }

        if (isset($_POST['signbtn'])) {
            $id = html_escape($_POST['txtID']);
            $name = html_escape($_POST['txtName']);
            $user = html_escape($_POST['txtUser']);
            $email = html_escape($_POST['txtEmail']);
            $is_admin = html_escape($_POST['txtIs_admin']);
            $pass = html_escape($_POST['txtPass']);

           try{
                if ($is_admin == 1 || $is_admin == 0) {
                    if ($_POST['txtPass'] !== $_POST['txtResetPass']) {
                        $message = "Mật khẩu xác nhận không khớp.";
                        echo "<script>alert('$message');</script>";
                    } else {
                        if (preg_match('/[^\x00-\x7F]/', $_POST['txtUser'])) {
                            $message = "Không được nhập dấu!";
                            echo "<script>alert('$message');</script>";
                        } else {
                            if (strlen($name) > 50) {
                                $message = "Tài khoản không quá 50 ký tự";
                                echo "<script>alert('$message');</script>";
                            } else {
                                if (strlen($email) > 50) {
                                    $message = "Email không quá 50 ký tự";
                                    echo "<script>alert('$message');</script>";
                                } else {
                                    if (strlen($user) > 20) {
                                        $message = "User không quá 20 ký tự";
                                        echo "<script>alert('$message');</script>";
                                    } else {
                                        if (strlen($pass) > 255) {
                                            $message = "Pass không quá 255 ký tự";
                                            echo "<script>alert('$message');</script>";
                                        } else {
                                            $hashed_password = password_hash($_POST['txtPass'], PASSWORD_DEFAULT);
                                            $result = $userService->editMember($id, $name, $email, $user,  $hashed_password, $is_admin);

                                            if ($result) {
                                             header('location:/CSE485_2023_BTTH03/index.php?controller=user&action=list');
            }}}}}}}}
        }
        catch (Exception $e) {
            echo "<script>alert('Tồn tại');</script>";
        }
    }

        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('user/edit_user.html.twig');
        echo $content->render(array(
             'findUser' =>$findUser ));
    }

    public function add()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        // echo "Tương tác với Services/Models from Article";
        // Nhiệm vụ 2: Tương tác với View
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        $memberService = new UserService();
        function html_escape($text): string
        {

            $text = $text ?? '';

            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false); // Return escaped string
        }
        try{
        if (isset($_POST['signbtn'])) {
            $name = html_escape($_POST['txtName']);
            $user = html_escape($_POST['txtUser']);
            $email = html_escape($_POST['txtEmail']);
            $pass = html_escape($_POST['txtPass']);
            if (isset($_POST['is_admin']) && $_POST['is_admin'] == 1) {
                $is_admin = 1;
            } else {
                $is_admin = 0;
            }
            
                if ($_POST['txtPass'] !== $_POST['txtResetPass']) {
                    echo "<script>alert('Mật khẩu không khớp');</script>";
                } else {
                    if (preg_match('/[^\x00-\x7F]/', $_POST['txtUser'])) {
                        $message = "User Không được nhập dấu!";
                        echo "<script>alert('$message');</script>";
                    } else {
                        if (strlen($name) > 50) {
                            $message = "Tài khoản không quá 50 ký tự";
                            echo "<script>alert('$message');</script>";
                        } else {
                            if (strlen($email) > 50) {
                                $message = "Email không quá 50 ký tự";
                                echo "<script>alert('$message');</script>";
                            } else {
                                if (strlen($user) > 20) {
                                    $message = "User không quá 20 ký tự";
                                    echo "<script>alert('$message');</script>";
                                } else {
                                    if (strlen($pass) > 255) {
                                        $message = "Pass không quá 255 ký tự";
                                        echo "<script>alert('$message');</script>";
                                    } else {
                                        $hashed_password = password_hash($_POST['txtPass'], PASSWORD_DEFAULT);
                                        $result = $memberService->addMember($name, $email, $user,  $hashed_password, $is_admin);

                                        if ($result) {
                header('location:/CSE485_2023_BTTH03/index.php?controller=user&action=list');
            }}}}}}}
        }}
        catch (Exception $e) {
            echo "<script>alert('Tồn tại user hoặc email');</script>";
        }
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('user/add_user.html.twig');
        echo $content->render(array(
            ));
    }

    public function delete(){
        $userService = new UserService();
        if (isset($_GET['id'])){
            $result = $userService->deleteUser($_GET['id']);
            if($result){
                header('location:/CSE485_2023_BTTH03/index.php?controller=user&action=list');
            }
        }
        include("views/user/list_user.php");
    }


}