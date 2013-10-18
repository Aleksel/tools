<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="language" content="en"/>

	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css"
	      href="<?=$this->assetsBase?>/css/ie.css"
	      media="screen, projection"/>
	<![endif]-->

	<link rel="stylesheet" type="text/css"
	      href="<?=$this->assetsBase?>/css/main.css"/>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="wrap">
    <div class="container page">
        <?php $this->renderPartial('/blocks/header') ?>

        <?php if (isset($this->breadcrumbs)): ?>
            <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                'links'=>$this->breadcrumbs,
            )); ?><!-- breadcrumbs -->
        <?php endif?>

        <?php echo $content; ?>

        <div class="clear"></div>

        <!-- footer -->
        <div id="push"></div>
    </div>
</div>
<?php $this->renderPartial('/blocks/footer') ?>
<!-- page -->
</body>
</html>
