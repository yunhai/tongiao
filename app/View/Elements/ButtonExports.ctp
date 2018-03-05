<ul>
<?php
$index = 0;
foreach ($array as $key => $value) {
    ?>
        <li class='form-group'>
            <button onclick="window.location.href = '<?php echo $this->Html->url('/', true) ?>Exports/download/<?php echo $key;?>';" type="button" class="btn btn-primary"><?php echo $value;?></button>
        </li>
    <?php
    $index ++;
}
?>
</ul>