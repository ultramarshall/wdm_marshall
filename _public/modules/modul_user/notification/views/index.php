
<!-- <input type="hidden" id="destination" value="<?=$destination?>"> -->
<!-- <input type="hidden" id="total_weight" value="<?=$total_weight?>"> -->

<div class="card mb-5 p-0 shadow-sm" style="min-height: 345px">
    <div class="card-body p-0">
        <table class="table tbl-no-border m-0">
            <thead>
                <tr>
                    <th class="bold pl-5">NOTIFIKASI</th>
                    <th width="20%">TANDAI TELAH DIBACA</th>
                </tr>
            </thead>
            <tbody id="item"></tbody>
        </table>
    </div>
</div>




<style>
    .card {
        border: 0;
    }
    .tbl-no-border {
        border-collapse: none;
    }
    table.tbl-no-border th,
    .tbl-no-border td {
        border: 0;
    }
    thead {
        border-bottom: 3px solid hotpink
    }

    .border-none {
        border: 0;
    }
    .btn-promo:hover {
        color: #000;
    }

    .btn-promo:active {
        color: #000;
        background-color: hotpink;
    }

</style>