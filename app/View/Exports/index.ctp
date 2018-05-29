<style>
.prefecture input {
    margin-left: 0px !important;
}
.ton_giao input {
    margin-left: 0px !important;
}
.label_filter {
    margin-bottom: 10px;
}
hr {
    margin-top: 5px;
    margin-bottom: 5px;
}
</style>
<script>
$(function(){
	$('button').click(function(){
        $('form').append('<input type="hidden" name="type" value="'+$(this).attr('data-value')+'" />');
    });
    //select all checkboxes
    $(".all").change(function(){  //"select all" change 
        $(this).closest('.col-lg-6').find('input[type=checkbox]').prop('checked',$(this).is(':checked'));
    });

    //".checkbox" change 
    $('.checkbox input[type=checkbox]').change(function(){ 
        //uncheck "select all", if one of the listed checkbox item is unchecked
        if(false == $(this).prop("checked")){ //if this item is unchecked
            $(this).closest('.col-lg-6').find('.all').prop('checked', false); //change "select all" checked status to false
        }
        //check "select all" if all checkbox items are checked
        /*if ($('.checkbox input[type=checkbox]:checked').length == $('.checkbox input[type=checkbox]').length ){
        	$(this).closest('.col-lg-6').find('.all').prop('checked', true);
        }*/
        if ($(this).closest('.col-lg-6').find('.checkbox input[type=checkbox]:checked').length == $(this).closest('.col-lg-6').find('.checkbox input[type=checkbox]').length ){
            $(this).closest('.col-lg-6').find('.all').prop('checked', true);
        }
    });
});
</script>
<form action="Exports/download/" method="post">
<?php
    foreach ($header as $key => $value) {
        ?>
<div class="row">
    <div class="col-xs-12 text-left ">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title fa fa-file-excel-o">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $key; ?>" aria-expanded="true" aria-controls="collapseOne">
                        <?php echo $value; ?> 
                    </a>
                </h4>
            </div>
            <div id="collapse_<?php echo $key; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="input-group col-xs-12 ">
                        <?php
                            switch ($key) {
                                case 'a':
                                    echo $this->element("ButtonExports", array("array" => $arrayButtonLable1));
                                    break;
                                case 'b':
                                    echo $this->element("ButtonExports", array("array" => $arrayButtonLable2));
                                    break;
                                default:
                                    break;
                            }
                        ?>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<?php } ?>
</form>