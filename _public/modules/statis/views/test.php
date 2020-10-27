<script type="text/javascript" src="https://cdn.rawgit.com/sindu12jun/table-dragger/master/dist/table-dragger.min.js"></script>
<div class="card my-3">
    
    <div class="card-body p-0">
        <table class="table table-hover" id="table">
            <thead>
                <th class="text-center" width="30px"><i class="fa fa-sort"></i></th>
                <th>Type Item</th>
                <th class="text-center" width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php for($i=0;$i<5;$i++) { ?>
                <tr id="<?=$i?>">
                    <td class="move text-center"><i class="fa fa-sort"></i></td>
                    <td class="data pl-2"><?=$i?></td>
                    <td class="data d-flex justify-content-center">
                        <button type="button" class="btn btn-sm btn-info tooltip-left action-edit" data-tooltip="Edit" id="">
                            <i class="fa fa-pencil"></i>
                        </button>
                        &nbsp;
                        <button type="button" class="btn btn-sm btn-danger tooltip-left action-delete" data-tooltip="Delete" id="">
                            <i class="fa fa-trash-o"></i> </button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
var dragger = tableDragger(document.getElementById('table'), {
    mode: 'row',
    dragHandler: '.move',
    onlyBody: true,
    animation: 100
});
dragger.on('drop', function(from, to, el, mode) {
    arr = [];
    table = $('#table');
    row = table.find('tbody > tr');
    row.each(function(index) {
        arr[index] = this.id;
    });
    console.log(JSON.stringify(arr))
});

</script>