@extends('layouts.app')
@section('content')
<div class="container">
<div class="rowjustify-content-center">
<div class="col-md-8">
<div class="card">
<div class="card-header">Effectuer un paiement</div>
<div class="card-body">
<formaction="{{ route('payment.pay') }}" method="POST">
@csrf
<div class="form-group">
<label for="amount">Montant</label>
<input type="text" name="amount" id="amount" class="form-control" required>
</div>
<buttontype="submit" class="btnbtn-primarymt-3">Payer avec PayPal</button>
</form>
</div>
</div>
</div>
</div>
</div>
@endsection