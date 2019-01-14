<style>
    img{
        margin: auto auto auto 100px;
    }
    /*#yw0_button{*/
        /*background-image: url(/themes/tema/assets/img/repeat.png); !* 16px x 16px *!*/
        /*background-color: transparent; !* make the button transparent *!*/
        /*background-repeat: no-repeat;  !* make the background image appear only once *!*/
        /*background-position: 4px 3px;  !* equivalent to 'top left' *!*/
        /*border: none;           !* assuming we don't want any borders *!*/
        /*cursor: pointer;        !* make the cursor like hovering over an <a> element *!*/
        /*height: 40px;           !* make this the size of your image *!*/
        /*width: 40px;           !* make this the size of your image *!*/
        /*padding-left: 16px;     !* make text start to the right of the image *!*/
        /*vertical-align: middle; !* align the text vertically centered *!*/
    /*}*/
</style>
<!--<form action="index.html" class="form-signin">-->
<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'LoginForm',
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>true,
    'focus'=>array($model,'username'),
    'clientOptions'=>array(
        'validateOnChange'=>true,
        'validateOnSubmit'=>true,
    ),
    'htmlOptions'=>array(
        'class'=>'form-signin',
    )
)); ?>
    <p class="text-muted text-center btn-block btn btn-primary btn-rect">
        SILAHKAN ANDA MASUK
    </p>
<?php echo $form->textField($model,'username',array('class'=>'form-control','placeholder'=>'NAMA PENGGUNA')); ?>
<?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'PASSWORD')); ?>

    <?php
    $this->widget('CCaptcha',array(
        'showRefreshButton'=>true,
        'clickableImage' => true));
    echo CHtml::textField('Loginform[verifyCode]','',array('id'=>'verifyCode','placeholder'=>'KODE VERIFIKASI','class'=>'form-control'));
    echo '</br>';
    echo $form->errorSummary($model,'','',array('class' => 'alert alert-danger'));?>
    <button class="btn text-muted text-center btn-success" type="submit"><i class=" icon-signin"></i> Masuk</button>
<!--</form>-->

<?php
$this->endWidget(); ?>
<!--<link href="CSS/bootstrap-combined.min.css" rel="stylesheet" />-->
<!--<link rel="stylesheet" type="text/css" media="screen" href="CSS/bootstrap-datetimepicker.min.css" />-->
