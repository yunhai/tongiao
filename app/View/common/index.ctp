<?php ?>
<div class="row-fluid">
    <div class="span12">
        <?php echo $this->Session->flash(); ?>
        <p>
            <?php
                echo $this->Form->create($model, array('inputDefaults' => array(
                        'label' => false,
                        'div' => false,
                        'error' => false,
                        ),
                        "type" => "get",
                        "class" => "form-inline",
                        'url' => Router::url(array('controller' => $controller, 'action' => 'index'), true)
                    )
                );
            ?>
            <?php
                $value = "";
                foreach ($showField as $key => $val) {
                    $value = $key;
                    break;
                }
                echo $this->Form->input('search', array(
                    'div' => false,
                    'label' => false,
                    "value" => !empty($search) ? $search : "",
                    'type' => 'text',
                    "placeholder" => $value,
                    'required' => false,
                    'class' => 'form-control',
                    )
                );
            ?>
        <?php
            echo $this->Form->submit(LOCAL_SEARCH, array(
                'type' => 'submit',
                'class' => 'btn btn-primary btn-sm',
                'div' => false,
                'label' => false
                )
            );
        ?>
        <span class="text-right pull-right">
            <?php
                $url = Router::url(array('controller' => $controller, 'action' => 'add'), true);
                echo $this->Html->link(LOCAL_INSERT, $url, array(
                    'escape' => false, 
                    'class' => 'btn btn-info btn-sm'
                    )
                );
            ?>
        </span>
        <?php echo $this->Form->end();?>
        </p>
        <table class="table table-bordered table-condensed table-striped table-hover">
            <tbody>
                <tr>
                    <?php foreach ($showField as $key => $val) { ?>
                        <th class="aside aligncenter info"><?php echo $key; ?></th>
                    <?php } ?>
                    <td class="aside aligncenter info" style="width: 12% !important;"> <?php echo LOCAL_ACTION; ?> </td>
                </tr>
                <?php
                if (empty($data)) {
                    ?>
                    <tr>
                        <td colspan="300" style="text-align: center;"> 
                            <?php echo NOT_FOUND; ?>
                        </td>
                    </tr>
                    <?php
                    return;
                }
                foreach ($data as $val) {
                    ?>
                    <tr>
                        <?php foreach ($showField as $key => $v) { ?>
                            <td align="center"> 
                                <?php echo $val[$model][$v]; ?>
                            </td >
                        <?php } ?>
                        <td align="center"> 
                            <?php
                                echo $this->Form->button(LOCAL_EDIT, array(
                                    'type' => 'button',
                                    "style" => "margin-right: 8px;",
                                    'class' => 'btn btn-info btn-sm',
                                    'onclick' =>
                                    'window.location.href =  \'' . Router::url(array('controller' => $controller, 'action' => 'add', $val[$model]["id"]), true) . '\'; '
                                    )
                                );
                                echo $this->Form->button(LOCAL_DELETE, array(
                                    'type' => 'button',
                                    'name' => 'btn_delete',
                                    'class' => 'btn btn-danger btn-sm',
                                    'onclick' => 'if(confirm(\'' . __(LOCAL_ALERT_DELETE) . '\'))' . '{window.location.href =  \'' . Router::url(array('controller' => $controller, 'action' => 'delete', $val[$model]["id"]), true) . '\';} return false;'
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
            <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate" style="text-align: center;">
                <ul class="pagination">
                    <?php
                    $prev_next_option = array('tag' => 'li', 'escape' => false);
                    echo $this->CustomPaginator->prev('«', $prev_next_option, '', $prev_next_option);
                    $option = array('tag' => 'li', 'currentClass' => 'active', 'separator' => '', 'first' => 2, 'last' => 2, "ellipsis" => "<li class='ellipsis'><span>...</span></li>");
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
