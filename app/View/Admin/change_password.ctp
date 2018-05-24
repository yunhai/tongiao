<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel-body">
            <?php
            echo $this->Form->create('Admin', array('class' => 'form-signin'));
            ?>
            <fieldset>
                <?php
                echo $this->Form->input(
                        'password', array(
                    'label' => false,
                    'div' => false,
                    'type' => 'password',
                    'class' => 'form-group form-control',
                    'placeholder' => 'Mật khẩu cũ',
                    'required' => false,
                        )
                );

                echo $this->Form->input(
                        'password_new_1', array(
                    'label' => false,
                    'div' => false,
                    'type' => 'password',
                    'class' => 'form-group form-control',
                    'placeholder' => 'Mật khẩu mới',
                    'required' => false,
                        )
                );
                echo $this->Form->input(
                        'password_new_2', array(
                    'label' => false,
                    'div' => false,
                    'type' => 'password',
                    'class' => 'form-group form-control',
                    'placeholder' => 'Lặp lại Mật khẩu mới ',
                    'required' => false,
                        )
                );

                echo $this->Form->submit(
                        "Đổi mật khẩu", array(
                    'type' => 'submit',
                    'class' => 'btn btn-lg btn-success btn-block',
                    'div' => false,
                    'label' => false
                        )
                );
                ?>
            </fieldset>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>