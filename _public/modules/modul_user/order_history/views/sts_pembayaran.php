<?php 
/*foreach ($result_payment as $value) {
	doi::dump($value->midtrans);
}*/
?>

<?php foreach ($result_payment as $value): ?>
<div class="card bg-withe col-12 mt-3 shadow-sm p-0 border">
	<div class="card-body p-0 d-block">
		<table class="table p-0 mb-0 relative" style="overflow: auto;">
			<tr>
				
				<td style="width: 60px" class="text-center justify-content-center">
					<?=show_image($value->product_logo,60, 100, 'staft', '','')?>
				</td>
				<td>
					<table class="table p-0 mb-0">
						<tr class="fs-12">
							<td style="width: 120px" class="text-left p-0 m-0">No. Transaksi</td>
							<td class="text-left m-0 p-0">: <?=$value->midtrans->order_id?></td>
						</tr><!-- 
						<tr class="fs-12">
							<td style="width: 120px" class="text-left p-0 m-0">Tanggal Transaksi</td>
							<td class="text-left m-0 p-0">: <span class="badge bg-danger fs-12 text-light"><?=$value->midtrans->transaction_time?></span></td>
						</tr> -->
						<tr class="fs-12">
							<td style="width: 120px" class="text-left p-0 m-0">Status Transaksi</td>
							<td class="text-left m-0 p-0">: 
								<?php if ($value->midtrans->transaction_status =="expire"): ?>
									<span class="badge bg-danger fs-12 text-light">kadaluarsa</span>
								<?php endif ?>
								<?php if ($value->midtrans->transaction_status =="pending"): ?>
									<span class="badge bg-info fs-12 text-light">belum di bayar</span>
								<?php endif ?>
								<?php if ($value->midtrans->transaction_status =="settlement"): ?>
									<span class="badge bg-success fs-12 text-light">berhasil</span>
								<?php endif ?>
							</td>
						</tr>
					</table>
				</td>
				<td style="width: 100px;" class="text-center">
					<div class="col-12 mt-2"><button class="btn btn-sm bg-pink text-white btn-detail-order">Detail</button></div>
				</td>
			</tr>
		</table>
		<div class="detail-view border m-1 p-2 text-white" style="display: none; background-color: #eee; position: relative; overflow: auto">
			<div class="col-12 p-0">
				<div class="col-4 float-left text-secondary text-left p-0">No Rekening Pembayaran</div>
				<div class="col-8 float-left text-secondary">: <?=$value->midtrans->va_numbers[0]->va_number?></div>
			</div>

			<div class="col-12 p-0">
				<div class="col-4 float-left text-secondary text-left p-0">Tipe Pembayaran</div>
				<div class="col-8 float-left text-secondary">: <?=ucwords(str_replace('_', ' ', $value->midtrans->payment_type))?></div>
			</div>

			<div class="col-12 p-0">
				<div class="col-4 float-left text-secondary text-left p-0">Total Pembayaran</div>
				<div class="col-8 float-left text-secondary">: <?=rupiah((int)$value->midtrans->gross_amount)?></div>
			</div>

			<div class="col-12 p-0">
				<div class="col-4 float-left text-secondary text-left p-0">Tanggal Transaksi</div>
				<div class="col-8 float-left text-secondary">: 
					<?=$value->midtrans->transaction_time?></div>
			</div>
			<p>
				<?php
						/*echo "<pre class=col-12>";
					var_dump($value->midtrans);
					echo "</pre>";*/
				?>
			</p>
		</div>
	</div>
</div>
<?php endforeach ?>



<!-- <table class="table table-sm border border-right-0 border-left-0 border-bottom-0 mt-3">
	<tr class="border border-right-0 border-left-0 border-top-0">
		<td>Kode Promo</td>
		<td width="18%">
			<input type="text" class="input-sm form-control col-12">
		</td>
	</tr>
	<tr>
		<td>
			Subtotal untuk (10 Produk)
			<span class="fs-16 color-default font-weight-bold">Rp. 500.000</span>
		</td>
		<td width="10%">
			<button class="btn btn-sm bg-pink text-white col-12 fs-16">
				<i class="fa fa-credit-card fa-fw"></i>
				<span>Checkout</span>
			</button>
		</td>
	</tr>
</table> -->
