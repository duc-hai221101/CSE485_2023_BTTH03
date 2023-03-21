<?php
require_once("services/UserService.php");
require_once("services/ArticleService.php");
require_once("services/AuthorService.php");
require_once 'services/CategoryService.php';
require_once 'vendor/autoload.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
class AdminController
{
    // Hàm xử lý hành động index
    public function index()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        echo "Tương tác với Services/Models from Admin";
        // Nhiệm vụ 2: Tương tác với View
        echo "Tương tác với View from Admin";
    }
    public function list()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        $articelService = new ArticleService();
        $articles = $articelService->countArticle();
        $authorService = new AuthorService();
        $authors = $authorService->countAuthor();
        $categoryService = new CategoryService();
        $categorys = $categoryService->countCategory();
        $userService = new UserService();
        $users = $userService->countUser();

        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('admin/index.html.twig');
        echo $content->render(array(
            'articles' => $articles,
            'authors' => $authors,
            'categorys' => $categorys,
            'users' => $users,
        ));
    }
}