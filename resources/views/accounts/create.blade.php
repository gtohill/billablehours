@extends('layouts.app')

@section('title', 'Create New Client')

@section('clients')

<div class="container pb-5">
    <div class="text-center display-4 m-5">Create Client</div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form action="/accounts" method="POST">
                @csrf
                <div class="form-group">
                    <label for="formGroupExampleInput">Company Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Company Name" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">Address</label>
                    <input type="text" class="form-control" name="address" placeholder="Address" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">City</label>
                    <input type="text" class="form-control" name="city" placeholder="City" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">Prov</label>
                    <input type="text" class="form-control" name="prov" placeholder="Prov" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">Postal Code</label>
                    <input type="text" class="form-control" name="pc" placeholder="Postal Code" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">Phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" onchange="formatPhoneNumber()" placeholder="Phone" value="" required>
                    <div id="phone-message"></div>
                </div>                
                <div class="form-group">
                    <label for="formGroupExampleInput2"></label>
                    <input type="submit" class="form-control btn-success" value="Create Client">
                </div>
            </form>
        </div>
    </div>
    @if($message ?? "")
        {{$message}}
    @endif
</div>

<script>


function formatPhoneNumber() {
    let x =  document.getElementById('phone').value;
    console.log(x)
    var cleaned = ('' + x).replace(/\D/g, '')
    var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/)
    if (match) {
        document.getElementById('phone').value = '(' + match[1] + ') ' + match[2] + '-' + match[3];
        document.getElementById('phone-message').style.display = "none";
    }else{
        document.getElementById('phone-message').style.display = "inline";
        document.getElementById('phone-message').style.color = "red";
        document.getElementById('phone-message').innerHTML = "please enter a valid 7 digit phone number";
    }
}    
    
</script>

@endsection