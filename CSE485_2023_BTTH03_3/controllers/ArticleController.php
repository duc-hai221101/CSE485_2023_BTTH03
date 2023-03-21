<?php
require_once("services/ArticleService.php");
require_once("services/AuthorService.php");
require_once 'services/CategoryService.php';
require_once 'vendor/autoload.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
class ArticleController
{
    // Hàm xử lý hành động index
    public function index()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        echo "Tương tác với Services/Models from Article";
        // Nhiệm vụ 2: Tương tác với View
        echo "Tương tác với View from Article";
    }
    public function add()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        // echo "Tương tác với Services/Models from Article";
        // Nhiệm vụ 2: Tương tác với View
        $authorService = new AuthorService();
        $authors = $authorService->getAllAuthors();
        $categoryService = new CategoryService();
        $categorys = $categoryService->getAllCategorys();
        $articleService = new ArticleService();

        if (isset($_POST['submit'])) {
            $hinhanh = $_FILES['hinhanh']['name'];
            $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
            $result = $articleService->addArticle($_POST['tieude'], $_POST['ten_bhat'], $_POST['ma_tloai'], $_POST['tomtat'], $_POST['noidung'], $_POST['ma_tgia'], $_POST['ngayviet'], $hinhanh);
            $target = 'C:/xampp/htdocs/CSE485_2023_BTTH03/views/images/songs/' . basename($_FILES['hinhanh']['name']);
            move_uploaded_file($hinhanh_tmp, $target);
            if ($result) {
                header('location:/CSE485_2023_BTTH03/index.php?controller=article&action=list');
            }
        }
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('article/add_article.html.twig');
        echo $content->render(array(
            'authors'=>$authors,
            'categorys'=>$categorys
        ));
    }
    public function edit()
    {
        function html_escape($text): string
        {
            $text = $text ?? ''; 
            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false); // Return escaped string
        }
        $authorService = new AuthorService();
        $authors = $authorService->getAllAuthors();
        $categoryService = new CategoryService();
        $categorys = $categoryService->getAllCategorys();
        $articleService = new ArticleService();
        $findArticle = $articleService->findArticleById($_GET['id']);
        
        if (isset($_POST['submit'])) {
            if ($_FILES['hinhanh']['name'] == '') {
                $hinhanh = html_escape($findArticle[0]->getHinhanh());
            } else {
                $hinhanh = html_escape($_FILES['hinhanh']['name']);
                $hinhanh_tmp = html_escape($_FILES['hinhanh']['tmp_name']);
                 }
            $result = $articleService->editArticle($_GET['id'], html_escape($_POST['tieude']), html_escape($_POST['ten_bhat']), html_escape($_POST['ma_tloai']), html_escape($_POST['tomtat']), html_escape($_POST['noidung']), html_escape($_POST['ma_tgia']), html_escape($_POST['ngayviet']), $hinhanh);
            $target = 'C:/xampp/htdocs/CSE485_2023_BTTH03/views/images/songs/' . basename($_FILES['hinhanh']['name']);
            move_uploaded_file($hinhanh_tmp, $target);
            if ($result) {
                header('location:/CSE485_2023_BTTH03/index.php?controller=article&action=list');
            }
        }
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('article/edit_article.html.twig');
        echo $content->render(array(
            'authors'=>$authors,
            'categorys'=>$categorys,
            'findArticle'=>$findArticle
        ));
    }
    public function delete()
    {
        $articleService = new ArticleService();
        if (isset($_GET['id'])) {
            $result = $articleService->deleteArticle($_GET['id']);
            if ($result) {
                header('location:/CSE485_2023_BTTH03/index.php?controller=article&action=list');
            }
        }
        return $this->list();
    }
    public function list()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        // echo "Tương tác với Services/Models from Article";
        // Nhiệm vụ 2: Tương tác với View
        $articleService = new ArticleService();
        $articles = $articleService->getAllArticles();

        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('article/list_article.html.twig');
        echo $content->render(array(
            'articles' => $articles,
        ));
    }
}
?>