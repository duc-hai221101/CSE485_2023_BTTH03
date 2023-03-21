<?php
require_once("services/ArticleService.php");
require_once("services/UserService.php");
require_once 'vendor/autoload.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
class HomeController
{
    // Hàm xử lý hành động index
    public function index()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        $articelService = new ArticleService();
        $articles = $articelService->getAllArticles();
        // Nhiệm vụ 2: Tương tác với View
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('home/index.html.twig');
        echo $content->render(array(            
            'articles' => $articles
            ));

    }

    public function login()
    {
        session_start();
        $this->userService = new UserService();
        if (isset($_POST['Login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $users = $this->userService->checkLogin($username);
            if ($users > 0) {
                $pass_hash = $users[0]->getPassword();
                $role = $users[0]->getRole();
                if ($pass_hash = $password) {
                    if ($role == 'admin') {
                        $_SESSION['admin'] = $_POST['username'];
                        header('location:/CSE485_2023_BTTH03/index.php?controller=admin&action=list');
                    } else {
                        echo 'mật khẩu không chính xác';
                    }
                }
            }

        }
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('home/login.html.twig');
        echo $content->render();
    }
    public function logout()
    {
        session_start();
        unset($_SESSION['admin']);
        session_destroy();
        header("Location:/CSE485_2023_BTTH03/index.php?controller=home&action=login");
        exit;
    }

    public function detail()
    {
        $id = $_GET['id'];
        $this->articleService = new ArticleService();
        $findArticle = $this->articleService->findArticleById($id);

        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('home/detail.html.twig');
        echo $content->render(array(            
            'findArticle' => $findArticle
            ));
    }
}