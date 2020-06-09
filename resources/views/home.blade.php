@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Flow </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('orden') }}" method="POST" >
                    @csrf {{ csrf_field() }}
                        
                        <div class="form-group">
                          <label for="exampleInputEmail1">Orden N°:</label>
                          <input type="text" class="form-control" id="order" name="order">
                        </div>
                        
                        <div class="form-group">
                          <label for="exampleInputPassword1">Monto:</label>
                          <input type="text" class="form-control" id="cost" name="cost"> 
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputPassword1">Descripción:</label>
                            <input type="text" class="form-control" id="description" name="description"> 
                        </div>
                          
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email: <small>(Opcional)</small></label>
                            <input type="email" class="form-control" id="mail" name="mail" aria-describedby="emailHelp">
                        </div>

                        <button type="submit" class="btn btn-primary">Pagar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
