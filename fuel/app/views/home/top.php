<?php echo Asset::img(('background.jpg'), array('width'=>'50%', 'alt'=>'chara')) ?>


<?php echo Form::open('mypage'); ?>

<?php echo Form::input('name', 'value', array('style' => 'border: medium solid 2px;'));  ?>
<?php echo Form::password('password', 'value', array('style' => 'border: medium solid 2px;'));  ?>
<?php echo Form::button('submit', 'value', array('style' => 'border: 2px;')); ?>

<?php echo Form::close(); ?>


<div><a href="<?= CONTENTS_URL.'mypage' ?>">仮マイページ</a></div>
