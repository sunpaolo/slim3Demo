<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <?php
            foreach ($menus as $title => $subMenu) {
                echo '<li>';
                echo '<a href="#"><i class="fa fa-fw"></i> '.$title.'<span class="fa arrow"></span></a>';
                echo '<ul class="nav nav-second-level">';
                foreach ($subMenu as $menu) {
                    echo '<li><a href="/'.$menu['url'].'">'.$menu['name'].'</a></li>';
                }
                echo '</ul>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>
</div>