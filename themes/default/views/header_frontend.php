<?php 
$menu = '';
if ($this->authentication->is_loggedin()) {
    $menu .= '<li><a href='.base_url('upload').'>Admin</a></li>';
} else {
	$menu .= '<li><a href='.base_url('auth').'>Login</a></li>';
}

?>

<div class="sticky shadow-md w-100">
    <div class="navbar navbar-expand d-flex justify-content-between bd-navbar ">
        <div class="container">
                <div class="col-3 my-2">
                    <a href="<?=base_url()?>">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcT1lRN5ckqJeNqVqrbBvC7ThG8dUc7lmUCFxw&usqp=CAU" style="height: 50px">
                    </a>
                </div>
                <div class="col-9">
                    <ul class="menu-list float-right p-0 m-0">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                        <?=$menu?>
                    </ul>
                    
                </div>
        </div>
    </div>

</div>

<style>
.menu-list > li {
    float: left;
    padding: 1em 1.2em;
    font-size: 16px;
    font-weight: bolder;
}
.menu-list > li > a {
    color: black
}

</style>