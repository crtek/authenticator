@extends('Authenticator::auth')

@section('content')
<div class="container">
    <div class="col-md-12">
        <h1>Welcome {{$user->name}}</h1>
        <p>
        	You will receive a confirmation email from the system. 
        	You must activate your account by clicking on the link in this confirmation email in order to use the account.
        </p>
    </div>
</div>
@stop