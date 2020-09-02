<?php

require_once "model/ProductDAO.php";
require_once "model/Product.php";
require_once "model/Category.php";
require_once "view/View.php";

use Valitron\Validator;

class ProductController
{
    private $data;

    public function index()
    {
        $this->data = array();
        $prodDAO = new ProductDAO();

        try {
            $products = $prodDAO->selectAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $this->data['products'] = $products;

        View::load('view/template/header.html');
        View::load('view/product/index.php', $this->data);
        View::load('view/template/footer.html');
    }

    public function show($id)
    {
        $this->data = array();
        $prodDAO = new ProductDAO();

        try {
            $products = $prodDAO->select($id);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $this->data['products'] = $products;

        View::load('view/template/header.html');
        View::load('view/product/show.php', $this->data);
        View::load('view/template/footer.html');
    }

    public function create()
    {
        $this->data = [];
        $catDAO = new CategoryDAO;

        try {
            $categories = $catDAO->selectAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $this->data['categories'] =  $categories;
        View::load('view/template/header.html');
        View::load('view/product/create.php', $this->data);
        View::load('view/template/footer.html');
    }

    public function store($data)
    {
        try {
            $prodDAO = new ProductDAO();
            $v = new Validator($data);
            $v->rule('required', ['name', 'description', 'price', 'category']);
            if ($v->validate()) {
                $newProduct = new Product();
                $newProduct->setName($data['name']);
                $newProduct->setDescription($data['description']);
                $newProduct->setImage($data['image']);
                $newProduct->setPrice($data['price']);
                $newProduct->setCategoryId($data['category']);
                $prodDAO->insert($newProduct);
                header('location: index.php?product=index');
            } else {
                $this->data = [];
                $catDAO = new CategoryDAO;
                $categories = $catDAO->selectAll();
                $this->data['categories'] =  $categories;
                $this->data['errors'] = $this->handleValidationErrors($v->errors());
                View::load('view/template/header.html');
                View::load('view/product/create.php', $this->data);
                View::load('view/template/footer.html');
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function edit($id)
    {
        $this->data = array();
        $prodDAO = new ProductDAO();
        $catDAO = new CategoryDAO;

        try {
            $products = $prodDAO->select($id);
            $categories = $catDAO->selectAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $this->data['products'] = $products;
        $this->data['categories'] =  $categories;


        View::load('view/template/header.html');
        View::load('view/product/edit.php', $this->data);
        View::load('view/template/footer.html');
    }

    public function update($data)
    {

        try {
            $prodDAO = new ProductDAO();
            $v = new Validator($data);
            $v->rule('required', ['name', 'description', 'price', 'category']);
            if ($v->validate()) {
                $product = new Product();

                $product->setName($data['name']);
                $product->setDescription($data['description']);
                $product->setImage($data['image']);
                $product->setPrice($data['price']);
                $product->setCategoryId($data['category']);;
                $prodDAO->update($product);
                header('location: index.php?product=index');
            } else {
                $this->data = [];
                $products = $prodDAO->select($data['id']);
                $catDAO = new CategoryDAO;
                $categories = $catDAO->selectAll();
                $this->data['products'] = $products;
                $this->data['categories'] =  $categories;
                $this->data['errors'] = $this->handleValidationErrors($v->errors());
                View::load('view/template/header.html');
                View::load('view/product/edit.php', $this->data);
                View::load('view/template/footer.html');
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function destroy($id)
    {
        $prodDAO = new ProductDAO();
        try {
            $prodDAO->delete($id);
            header('location: index.php?product=index');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function handleValidationErrors($errors)
    {
        $data = [];
        foreach ($errors as $errors) {
            foreach ($errors as $validation) {
                array_push($data, $validation);
            }
        }
        return $data;
    }
}
