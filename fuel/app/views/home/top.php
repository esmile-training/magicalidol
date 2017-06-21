<div><?php echo Asset::img(('background.jpg'), array('width'=>'50%', 'alt'=>'chara')) ?><div>

<?php echo Form::open('mypage'); ?>

<?php


echo Html::anchor('mypage', Asset::img('background.jpg'));
echo Form::input('name', 'value', array('type' => 'image', 'src' => Asset::img('background.jpg')));
?>

<?php echo Form::close(); ?>


<div><a href="<?= CONTENTS_URL.'mypage' ?>">仮マイページ</a></div>
