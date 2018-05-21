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

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Đăng nhập</h3>
                </div>
                <div class="panel-body">
                    <?php
                    echo $this->Form->create('Admin', array('class' => 'form-signin'));
                    ?>
                    <fieldset>
                        <?php
                        echo $this->Form->input(
                                'username', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'text',
                            'class' => 'form-group form-control',
                            'placeholder' => 'Username',
                            'required' => false,
                                )
                        );
                        echo $this->Form->input(
                                'password', array(
                            'label' => false,
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
                            'class' => 'btn btn-lg btn-primary btn-block',
                            'div' => false,
                            'label' => false
                                )
                        );
                        ?>
                    </fieldset>

                    <?php echo $this->Form->end(); ?>
                    <div style="margin-top: 20px; text-align: center;">
                        <?php echo $this->Session->flash(); ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


