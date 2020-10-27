<!-- 
<div class="container">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <div class="logo">
                    <br>
                    <a href=<?php echo base_url(); ?>><img src="<?=css_frontend_url('img/logo-pink.png')?>" class="logo" alt=""></a>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-6">
                <div style="">
                    <div class="img">
                        <br><br>
                        <center><img src="<?=css_frontend_url('img/registration.png')?>"></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="margin-left: 100px">

                <div class="content-tab white">

                    <center>
                        <div class="title-cc">
                            <p class="text-cc" style="margin-bottom: 0;">Daftar</p>
                        </div>
                    </center>
                    <?=form_open('auth/daftar', array('id'=>'form-register')); ?>
                        <div class="clearfix"></div>
                        <hr>
                      
                        <div class="row">
                            <div class="container">
                                <div class="col-12">
                                    <div class="col-12">
                                        <p class="label-profile" style="text-align: left; margin-top: 20px;">Email</p>
                                    </div>
                                    <div class="col-12">
                                        <input type="email" name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="container">
                                <div class="col-12">
                                    <div class="col-12">
                                        <p class="label-profile" style="text-align: left; margin-top: 20px;">Username</p>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="username" class="form-control">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="container">
                                <div class="col-12">
                                    <div class="col-12">
                                        <p class="label-profile" style="text-align: left; margin-top: 20px;">Password</p>
                                    </div>
                                    <div class="col-12">
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <div class="container">
                                <div class="col-12">
                                    <div class="col-12">
                                        <p class="label-profile" style="text-align: left; margin-top: 20px;">Ulangi Password</p>
                                    </div>
                                    <div class="col-12">
                                        <input type="password" name="password_c" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p class="label-profile" style="margin-top: 5px;"></p>
                            </div>
                            <div class="col-12" style="text-align: center">
                                <button type="submit" class="btn-save-login btn r-20 bg-ailin-hotpink bold text-white">DAFTAR</button>
                                <button class="btn r-20 bg-ailin-hotpink bold text-white" id="back-login">BACK</button>
                            </div><br><br><br>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->


<div class="row">
    <div class="col text-center p-5">
            <a href=<?php echo base_url(); ?>><img src="<?=asset_url('images/logo-pink.png')?>" class="logo" alt=""></a>
    </div>
</div>

<div class="row" >
    <div class="col"></div>
    <div class="col-12 col-sm-12 col-md-6 pt-0">
        <div class="content-tab white shadow-sm p-0 r-3 m-auto" style="width: 320px">
            <div class="text-center border-bottom bold p-4">
                <h4 class="bold p-0 m-0">Registration</h4>
                &nbsp;
            </div>
            <?=form_open('auth/daftar', $option); ?>
                <div class="row">
                        <div class="col-12">
                            <div class="col-12 pt-4 pb-3">
                                E-mail
                            </div>
                            <div class="col-12">
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>
                </div>

                <div class="row">
                        <div class="col-12">
                            <div class="col-12 pt-4 pb-3">
                                Username
                            </div>
                            <div class="col-12">
                                <input type="text" name="username" class="form-control">
                            </div>
                        </div>
                </div>

                <div class="row">
                            
                        <div class="col-12">
                            <div class="col-12 pt-4 pb-3">
                                Password
                            </div>
                            <div class="col-12">
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>
                </div>

                <div class="row">
                            
                        <div class="col-12">
                            <div class="col-12 pt-4 pb-3">
                                Password
                            </div>
                            <div class="col-12">
                                <input type="password" name="password_c" class="form-control">
                            </div>
                        </div>
                </div>
                    <div class="col-12 text-center p-4">

                        <button type="submit" class="btn btn-xl bg-ailin-hotpink text-white bold r-30">REGISTER</button>
                        <a href="<?=$google_login_url?>" class="btn btn-xl bg-ailin-hotpink bold r-30">
                            <span class="text-white fs-14" id="back-login">LOGIN</span>
                        </a>
                    </div>
            </form>
        </div>
    </div>
</div>

<img class="sm-none" src="<?=asset_url('images/registration.png')?>" style="position:absolute;top:91px;z-index: -1; background-size: 100%">
