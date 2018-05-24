<?php
echo $this->Html->css('admin/bower_components/bootstrap/dist/css/bootstrap.min.css');
echo $this->Html->css('admin/dist/css/sb-admin-2.css');
echo $this->Html->css('admin/bower_components/font-awesome/css/font-awesome.min.css');
?>
<?php
echo $this->Html->script(array('admin/bower_components/jquery/dist/jquery.min.js'));
echo $this->Html->script(array('admin/bower_components/bootstrap/dist/js/bootstrap.min.js'));
echo $this->Html->script(array('admin/bower_components/metisMenu/dist/metisMenu.min.js'));
echo $this->Html->script(array('admin/dist/js/sb-admin-2.js'));
?>
<style>
.alert {
    margin-top: 1em;
    margin-bottom: 0;
}
.form-signin {
    margin-bottom: 0;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-green">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>ĐĂNG NHẬP</strong></h3>
                </div>
                <div class="panel-body">
                    <?php
                    echo $this->Form->create('Admin', array('class' => 'form-signin'));
                    ?>
                    <fieldset>
                        <?php
                        echo $this->Form->input(
                                'username', array(
                            'label' => 'Tên đăng nhập',
                            'div' => false,
                            'type' => 'text',
                            'class' => 'form-group form-control',
                            'placeholder' => 'Tên đăng nhập',
                            'required' => false,
                                )
                        );
                        echo $this->Form->input(
                                'password', array(
                            'label' => 'Mật khẩu',
                            'div' => false,
                            'type' => 'password',
                            'class' => 'form-group form-control',
                            'placeholder' => 'Mặt khẩu',
                            'required' => false,
                                )
                        );


                        echo $this->Form->submit(
                                "Đăng nhập", array(
                            'type' => 'submit',
                            'class' => 'btn btn-lg btn-success btn-block',
                            'div' => false,
                            'label' => false
                                )
                        );
                        ?>
                    </fieldset>

                    <?php echo $this->Form->end(); ?>
                    <div class="text-center">
                        <?php echo $this->Session->flash(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


