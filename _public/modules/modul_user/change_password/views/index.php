<center>    
    <div class="profile-sec">
        <div class="container">
            <div class="top-title">
                <h2><i class="fa fa-unlock-alt fa-fw" style="color: hotpink"></i>Ubah Password</h2>
                <p class="profile-info pl-3">Ubah Password secara berkala untuk mengamankan akun anda.</p>
                <hr>    
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xl-10 offset-xl-1 float-left">
                        <?=form_open('change-password/forgot'); ?>
                        <table class="col-12">
                            <tr>
                                <td>Password Lama</td>
                                <td>
                                    <input type="password" class="form-control" value="*******" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td>Password Baru</td>
                                <td>
                                    <input name="password" type="password" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Ulangi Password Baru</td>
                                <td>
                                    <input name="re_password" type="password" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td class="pt-3">
                                    <button class="btn bg-ailin-hotpink text-white bold col-12 r-20">Simpan</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
</center>