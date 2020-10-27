<?php 
if((bool)$this->authentication->get_Info_User('photo')){
    $url = staft_url($this->authentication->get_Info_User('photo'));
    $photo = show_image($this->authentication->get_Info_User('photo'),160, 100, 'staft', '', 'img shadow w-100 pfoto img-middle-center');
} elseif((bool)$this->authentication->get_Info_User('photo_google')) {
    $url = $this->authentication->get_Info_User('photo_google');
    $photo = '<img src="'.$this->authentication->get_Info_User('photo_google').'" alt="" class="img shadow w-100 pfoto img-middle-center" style="width:200px">';
} else {
    $url = img_url('default-user.png');
    $photo = '<img src="'.img_url('default-user.png').'" alt="" class="img  w-100 pfoto img-middle-center" style="width:200px">';
}


$gender = (int)$this->authentication->get_Info_User('gender');

?>
<section class="section pt-0">
    <div class="row">
        <div class="col-10 m-auto">
            
            <h2><i class="fa fa-user-o fa-fw" style="color: hotpink"></i>Profile</h2>
            <p class="profile-info pl-1 fs-12 p-0 m-0 border-bottom mb-3">
                Kelola informasi profil anda untuk mengontrol, melindungi dan mengamankan akun
            </p>
            <?=form_open_multipart('profiles/save')?>
                <div class="row">
                    <div class="col-4 float-left text-center p-3">
                        <?=$photo?>
                        <input type="file" name="file" id="file" class="inputfile d-none" value="<?=$url?>">
                        <label for="file" class="pilih-photo  cur-pointer"></label>
                        <label for="file" class="btn-pilih-photo cur-pointer btn btn-default text-white bold r-0 w-100 bg-ailin-hotpink border-0" style="z-index: 4">upload foto</label>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-7 float-left">
                                             
                        <div class="card-body p-0 mb-2">
                            <div class="card-title">Nama</div>
                            <div class="input-group">
                                <input type="text" name="nama_lengkap" class="form-control" value="<?=$this->authentication->get_Info_User('nama_lengkap')?>">
                                <span class="input-group-append">
                                    <span class="input-group-text add-on white">
                                        <i class="icon-user"></i>
                                    </span>
                                </span>
                            </div>
                        </div>   

                        <div class="card-body p-0 mb-2">
                            <div class="card-title">Nomor Handphone</div>
                            <div class="input-group">
                                <input type="text" name="hp" class="form-control hp" value="<?=$this->authentication->get_Info_User('hp')?>">
                                <span class="input-group-append">
                                    <span class="input-group-text add-on white">
                                        <i class="icon-phone"></i>
                                    </span>
                                </span>
                            </div>
                        </div>       
                        <div class="card-body p-0 mb-2">
                            <div class="card-title">Jenis Kelamin</div>
                            <div class="input-group white">
                                <select name="gender" class="select2 text-black form-control white">
                                    <option value="0" <?=($gender==0)?'selected':''?> >Male</option>
                                    <option value="1" <?=($gender==1)?'selected':''?> >Female</option>
                                </select>
                            </div>
                        </div>                
                        <div class="card-body p-0 mb-2">
                            <div class="card-title">Tanggal Lahir</div>
                            <div class="input-group">
                                <input type="text" name="tgl_lahir" class="date-time-picker form-control" data-options="{&quot;timepicker&quot;:false, &quot;format&quot;:&quot;d-m-Y&quot;}" value="<?=$this->authentication->get_Info_User('tgl_lahir')?>">
                                <span class="input-group-append">
                                    <span class="input-group-text add-on white">
                                        <i class="icon-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-0 mb-2">
                            <button type="submit" class="btn btn-lg shadow-sm bg-ailin-hotpink r-20 bold text-white pl-5 pr-5 pull-right">
                                <i class="icon-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>



<style>
    .pilih-photo {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }
</style>
