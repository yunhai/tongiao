<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title><?php echo $title_for_layout; ?></title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        echo $this->Html->css('admin/bower_components/bootstrap/dist/css/bootstrap.min.css');
        echo $this->Html->css('admin/dist/css/sb-admin-2.css');
        echo $this->Html->css('admin/bower_components/font-awesome/css/font-awesome.min.css');
        echo $this->Html->css(array('style.css'));
        ?>
        <?php
        echo $this->Html->script(array('admin/bower_components/jquery/dist/jquery.min.js'));
        echo $this->Html->script(array('admin/bower_components/bootstrap/dist/js/bootstrap.min.js'));
        echo $this->Html->script(array('admin/bower_components/metisMenu/dist/metisMenu.min.js'));
        //echo $this->Html->script(array('admin/bower_components/morrisjs/morris.min.js'));
        //echo $this->Html->script(array('admin/js/morris-data.js'));
        echo $this->Html->script(array('admin/dist/js/sb-admin-2.js'));
        echo $this->Html->script(array('bootstrap.file-input'));
        echo $this->Html->script(array('js_popup', 'bootstrap.file-input',"common"));
        echo $this->Html->script(array('moment.js', "moment-with-locales.js"));
        echo $this->Html->script(array('bootstrap-datetimepicker.min'));
        echo $this->Html->css('bootstrap-datetimepicker.min');
        ?>
        <script type="text/javascript">
            var is_ac_add =0;
             var model = '<?php echo $model ?>';
            var base_url = '<?php echo $this->Html->url('/', true) ?>';
             var fiedlAuto = '<?php echo @$fiedlAuto ?>';
        </script>
    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand"  href="<?php echo $this->Html->url('/', true) ?>">
                        TÔN GIÁO
                    </a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">

                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <a href="<?php echo $this->Html->url('/', true) ?>Admin/changePassword">
                                    <i class='fa fa-lock fa-fw'> </i>Đổi mật khẩu
                                </a>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo $this->Html->url('/', true) ?>Admin/logout"><i class="fa fa-sign-out fa-fw"></i> Thoát</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="#">
                                    <i class="fa fa-tag fa-fw"></i> Tin lành<span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Chucsactinlanhs">
                                            Chức sắc tin lành
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Chihoitinlanhs">
                                            Chi hội
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Diemnhomtinlanhs">
                                            Điểm nhóm
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-tag fa-fw"></i> Công giáo<span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Chucsacnhatuhanhconggiaotrieus">
                                            Chức sắc, nhà tu hành Công giáo (triều)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Chucsacnhatuhanhcongiaodongtus">
                                            Chức sắc, nhà tu hành Công giáo (dòng tu)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Dongtuconggiaos">
                                            Giáo xứ, dòng tu (tu viện, cộng đoàn, đan viện)
                                        </a>
                                    </li>
									<li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Giaoxus">
                                            Giáo xứ
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-tag fa-fw"></i> Phật giáo hòa hảo<span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Chucviecphathoahaos">
                                            Chức việc phật giáo Hòa hảo
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-tag fa-fw"></i> Tịnh độ cư sĩ phật hội<span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Chucviectinhdocusiphathoivietnams">
                                            Chức việc Tịnh độ cư sĩ phật hội
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Chihoitinhdocusiphatgiaovietnams">
                                            Chi hội/ Hội quán
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-tag fa-fw"></i> Cao đài<span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Chucsaccaodais">
                                            Chức sắc Cao đài
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Hodaocaodais">
                                            Họ đạo Cao đài
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-tag fa-fw"></i> Phật giáo<span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Chucsacnhatuhanhphatgiaos">
                                            Chức sắc, nhà tu hành Phật giáo
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Huynhtruonggiadinhphattus">
                                            Huynh trưởng gia đình phật tử
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Tuvienphatgiaos">
                                            Tự, Viện Phật giáo
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Giadinhphattus">
                                            Gia đình Phật tử
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-tag fa-fw"></i> Hoạt động tín ngưỡng<span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Nguoihoatdongtinnguongchuyennghieps">
                                            Người hoạt động tín ngưỡng chuyên nghiệp
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Cosotinnguongs">
                                            Cơ sở tín ngưỡng
                                        </a>
                                    </li>
                                </ul>
                            </li>
							<li>
                                <a href="#">
                                    <i class="fa fa-tag fa-fw"></i> Hồi giáo<span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Chucviechoigiaos">
                                            Chức việc Hồi giáo
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $this->Html->url('/', true) ?>Cosohoigiaoislams">
                                            Cơ sở Hồi giáo Islam
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo $this->Html->url('/', true) ?>Exports">
                                    <i class="fa fa-tag fa-fw"></i> TỔNG HỢP
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>


            <div id="page-wrapper">
                <div class="row">
                    <div style="margin-left: 5px; padding-top:10px;">
                        <?php echo $this->Session->flash(); ?>
                    </div>
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $title_for_layout; ?>
                        </h1>
                    </div>
                    <?php
                    if (!empty($is_show_add)) {
                        echo $this->Form->submit(
                                LOCAL_STORE, array(
                            'type' => 'submit',
                            'class' => 'btn  btn-info',
                            'div' => false,
                            'id' => 'ac_store',
                            "style" => "position: fixed; z-index: 3000; float: right; right: 10px;",
                            'label' => false
                                )
                        );
                    }
                    ?>
                    <?php echo $this->fetch('content'); ?>
                </div>
            </div>
        </div>

        <?php //echo $this->element('sql_dump'); ?>
    </body>
</html>
