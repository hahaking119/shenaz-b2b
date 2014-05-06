<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php error_reporting(E_ALL); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css">

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <?php Yii::app()->bootstrap->register(); ?>
    </head>
    <body>
        <div id="header">
            <?php $this->widget('Header'); ?>
        </div>
        <div id="content">
            <?php echo $content; ?>
        </div>
        <div id="footer">
            Copyright &copy; <?php echo date('Y'); ?>. All rights reserved.
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#msg").fadeIn().animate({opacity: 1.0}, 4000).fadeOut("slow");
            });
            function image_error(img) {
                img.attr('src', '<?php echo (Yii::app()->theme->baseUrl . '/images/default-image.png'); ?>');
            }
        </script>
    </body>
</html>

