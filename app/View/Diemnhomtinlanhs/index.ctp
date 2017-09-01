<?php ?>

<div class="row-fluid">

    <div class="span11 " style="margin-top: 10px; width: 95%;margin-left: 30px;">
        <?php echo $this->Session->flash(); ?>

        <p>
            <?php
            echo $this->Form->create('Diemnhomtinlanh', array('inputDefaults' => array(
                    'label' => false,
                    'div' => false,
                    'error' => false,
                ),
                "type" => "get",
                "class" => "form-inline",
                'url' => Router::url(array('controller' => 'Diemnhomtinlanhs', 'action' => 'index'), true)
            ));
            ?>

        <div class="form-group">
            <?php
            echo $this->Form->input(
                    'search', array(
                'div' => false,
                'label' => false,
                "value" => !empty($search) ? $search : "",
                'type' => 'text',
                "placeholder" => "Họ và tên",
                'required' => false,
                'class' => 'form-control',
                    )
            );
            ?>
        </div>
        <?php
        echo $this->Form->submit(
                "Tìm kiếm", array(
            'type' => 'submit',
            'class' => 'btn btn-default btn-sm',
            'div' => false,
            'label' => false
                )
        );
        ?>
        <span class="text-right pull-right">
            <?php
            $url = Router::url(array('controller' => 'Diemnhomtinlanhs', 'action' => 'add'), true);
            echo $this->Html->link(
                    "Thêm", $url, array('escape' => false, "class" => "btn btn-info btn-sm")
            );
            ?>
        </span>
        <?php echo $this->Form->end();
        ?>
        </p>


        <table class="table table-bordered" >
            <tbody>
                <tr>
                    <td class="aside aligncenter" style="width: 10%;" >Tên điểm nhóm</td>
                    <td class="aside aligncenter" style="width: 10%;">Số điện thoại</td>
                    <td class="aside aligncenter" style="width: 10%;">Số giấy chứng nhận</td>
<!--                    <td class="aside aligncenter" style="width: 10%;">Ngày cấp</td>-->
                    <td class="aside aligncenter" style="width: 15%;">Cơ quan cấp</td>
                    <td class="aside aligncenter" style="width: 25%;"> </td>
                </tr>
                <?php
                if (empty($data)) {
                    ?>
                    <tr>
                        <td colspan="300"> 
                            Không tìm thấy dữ liệu
                        </td>
                    </tr>
                    <?php
                    return;
                }
                foreach ($data as $val) {
                    ?>
                    <tr>
                        <td align="center"> 
                            <?php echo $val["Diemnhomtinlanh"]["tendiemnhom"]; ?>
                        </td >

                        <td align="center"> 
                            <?php echo $val["Diemnhomtinlanh"]["sodienthoai"]; ?>
                        </td >
                        <td align="center"> 
                            <?php echo $val["Diemnhomtinlanh"]["sogiaychungnhan"]; ?>
                        </td >
<!--                        <td align="center"> 
                            <?php echo $val["Diemnhomtinlanh"]["ngaycap"]; ?>
                        </td >-->
                        <td align="center"> 
                            <?php echo $val["Diemnhomtinlanh"]["coquancap"]; ?>
                        </td >
                        <td align="center"> 
                            <?php
                            echo $this->Form->button(
                                    "Sửa", array(
                                'type' => 'button',
                                "style" => "margin-right:10px;",
                                'class' => 'btn btn-info btn-sm',
                                'onclick' =>
                                'window.location.href =  \'' . Router::url(array('controller' => 'Diemnhomtinlanhs', 'action' => 'add', $val["Diemnhomtinlanh"]["id"]), true) . '\'; '
                            ));

                            echo $this->Form->button(
                                    'Xóa', array(
                                'type' => 'button',
                                'name' => 'btn_delete',
                                'class' => 'btn btn-danger btn-sm',
                                'onclick' => 'if(confirm(\'' . __('Bạn có muốn xóa khong？') . '\'))'
                                . '{window.location.href =  \'' . Router::url(array('controller' => 'Diemnhomtinlanhs', 'action' => 'delete', $val["Diemnhomtinlanh"]["id"], $page), true) . '\';} return false;'
                                    )
                            );
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
        if ($this->CustomPaginator->numbers()) {
            ?>
            <div class="pagination pagination-centered">
                <ul>
                    <?php
                    $prev_next_option = array('tag' => 'li', 'escape' => false);
                    echo $this->CustomPaginator->prev('«', $prev_next_option, '', $prev_next_option);
                    $option = array('tag' => 'li', 'currentClass' => 'active', 'separator' => '');
                    echo $this->CustomPaginator->numbers($option);
                    echo $this->CustomPaginator->next('»', $prev_next_option, '', $prev_next_option);
                    ?>
                </ul>
            </div>
            <?php
        }
        ?>

    </div>
</div>
