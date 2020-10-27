<ul class="list-unstyled">
    <?php if (count($comments) == 0): ?>
        <li class="by-me m-0 p-3 text-center border">
            Belum ada Ulasan untuk produk ini                            
        </li>
    <?php else: ?>
        <?php foreach ($comments as $value): ?>
            <li class="by-me ">
                <div class="avatar float-left mr-3" style="width: 50px; height: 50px">
                    <b class="c-idle"></b>
                    <?=show_image($value->photo,60, 0, 'staft', '', 'img-middle-center w-100')?>
                </div>
                <div class="chat-content white border" style="margin-left: 65px">
                    <div class="chat-meta bold color-hotpink"><?=$value->username?>
                        <span class="float-right"><?=comment_time($value->create_date)?></span>
                    </div>
                    <?=$value->comment?>
                    <div class="clearfix"></div>
                </div>
            </li>
        <?php endforeach ?>
    <?php endif ?>
   <li class="by-me text-center">

    <?php if ($this->authentication->is_loggedin()): ?>
        <div class="avatar float-left mr-3" style="width: 50px; height: 50px">
            <b class="c-idle"></b>
            <?=show_image($this->authentication->get_info_user('photo'),60, 0, 'staft', '', 'img-middle-center w-100')?>
        </div>
        <div class="chat-content white p-0" style="margin-left: 65px">
            <form method="post" id="formComment">
                <textarea name="comment" cols="5" rows="5" class="form-control" id="komentar"></textarea>
                <button type="submit" class="btn btn-lg bg-ailin-hotpink bold text-center text-white w-100 mt-2">Beri ulasan</button>
            </form>
        </div>
    <?php else: ?>
        <a href="<?=base_url('auth')?>" class="btn btn-lg bg-ailin-hotpink bold text-center text-white w-100">Login untuk komentar</a>
    <?php endif ?>
       
   </li>
</ul>

<script>
    $('#formComment').submit(function(e){
        e.preventDefault();
        id = $('#idnya').val();
        komentar = $('#komentar').val();
        $.ajax({
            method: "POST",
            url: base_url+'ajax/post-comment',
            data: { komentar: komentar, id: id },
            beforeSend: function(){
                looding('dark', '#comment')
            },
            success: function(data){
                url = base_url + 'ajax/comment';
                cari_ajax({id: $('#idnya').val()}, 'comment', url);
            }
        });
    });
</script>