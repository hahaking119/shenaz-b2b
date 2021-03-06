<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs = array(
    'Products' => array('index'),
    $model->name => array('view', 'id' => $model->product_id),
    'Update',
);

$this->menu = array(
    array('label' => 'List Product', 'url' => array('index')),
    array('label' => 'Create Product', 'url' => array('create')),
    array('label' => 'View Product', 'url' => array('view', 'id' => $model->product_id)),
    array('label' => 'Manage Product', 'url' => array('admin')),
);
?>

<h1>Update Product - <?php echo $model->name; ?></h1>

<?php
echo $this->renderPartial('_form', array(
    'model' => $model,
    'companies' => $companies,
    'categories' => $categories,
    'productImages' => $productImages,
    'productCategory' => $productCategory,
    'productCustomCategory' => $productCustomCategory,
    'productCategoryList' => $productCategoryList,
    'productCustomCategoryList' => $productCustomCategoryList,
    'productImageLists' => $productImageLists,
//    'company_id' => $company_id,
));
?>