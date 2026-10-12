
<?php 
    require('includes/db.php');
    include('includes/auth.php');
    include('includes/header_main.php');
    include('includes/navbar_main.php');
?>
<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">
                Payment Voucher
            </h3>
        </div>
        <div class="card-body">
        	<form action="">
        		<div class="form-row">
	        		<div class="col-md-4 mb-4">
	        			<label for="pvno">PV No</label>
						<input type="text" class="form-control" name="pvno" id="receiptpvnono">
	        		</div>
	        		<div class="col-md-4 mb-4">
	        			<label for="refno">Reference No</label>
						<input type="text" class="form-control" name="refno" id="refno">
	        		</div>
	        		<div class="col-md-4 mb-4">
	        			<label for="recdate">Date</label>
						<input type="date" class="form-control" name="recdate" id="recdate">
	        		</div>
	        	</div>
	        	<div class="form-row">
					<div class="col-md-3 mb-3">
						<label for="debit">Receiving Ledger (Dr)</label>
						<input type="text" class="form-control" name="debit" id="debit">
					</div>
					<div class="col-md-3 mb-3">
						<label for="credit">Paying Ledger (Cr)</label>
						<input type="text" class="form-control" name="credit" id="credit">
					</div>
					<div class="col-md-3 mb-3">
						<label for="payee">Payee</label>
						<input type="text" class="form-control" name="payee" id="payee">
					</div>
					<div class="col-md-3 mb-3">
						<label for="pvamt">Amount</label>
						<input type="text" class="form-control" name="recamt" id="recamt">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-3 mb-3">
						<label for="mop">Mode Of Payment</label>
						<input type="text" class="form-control" name="mop" id="mop">
					</div>
					<div class="col-md-3 mb-3">
						<label for="instno">Instrument No</label>
						<input type="text" class="form-control" name="instno" id="instno">
					</div>
					<div class="col-md-3 mb-3">
						<label for="bank">Bank</label>
						<input type="text" class="form-control" name="bank" id="bank">
					</div>
					<div class="col-md-3 mb-3">
						<label for="branch">Branch</label>
						<input type="text" class="form-control" name="branch" id="branch">
					</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="narration">Narration</label>
							<textarea type="textarea" rows="4"  class="form-control" name="narration" id="narration" value=""></textarea>
						</div>
					</div>
				</div>
        	</form>
        </div>
        <div class="footer">
			<button type="submit" name="patientsavebtn" class="btn btn-primary btn-block">Save</button>
		</div>
    </div>
</div>
<?php include('includes/scripts_main.php');?>
<?php include('includes/footer_main.php');?>