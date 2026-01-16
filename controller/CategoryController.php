<?php
require_once __DIR__ . '/../autoload.php';

class CategoryController
{
    public function listCategories()
    {
        session_start();
        $categories = (new Category())->listCategory();
        return $categories;
    }

    public function createCategory()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category = new Category();
            $category->categoryName = htmlspecialchars($_POST['categoryName']);
            $category->descriptionCategory = htmlspecialchars($_POST['categoryDescription']);

            $result = $category->ajouteCategory();
            header('Location: ../../views/admin/categories.php');
            exit;
        }
    }

    public function updateCategory($id)
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category = new Category();
            $category->categoryName = htmlspecialchars($_POST['categoryName']);
            $category->descriptionCategory = htmlspecialchars($_POST['categoryDescription']);

            $result = $category->modifyCategory($id);
            header('Location: ../../views/admin/categories.php');
            exit;
        }
    }

    public function deleteCategory($id)
    {
        session_start();


        $result = (new Category())->suppressionCategory($id);
        header('Location: ../../views/admin/categories.php');
        exit;
    }
}