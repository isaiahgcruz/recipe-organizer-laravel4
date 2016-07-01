@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Search for recipes</h1>                    
                        <div class="form-group">
                            {{ Form::open(['route' => 'recipe.search']) }}
                            <div class="input-group">
                                {{ Form::text('name', '', ['class' => 'form-control']) }}
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>What can I cook with?</h1><br>
                    {{ Form::open(['route' => 'recipe.with']) }}

                    <div class="form-group">
                        {{ Form::label('ingredients', 'Recipes that contains all of the ff ingredients' ) }}
                        <div class="input-group">
                        {{ Form::select('ingredients[]', [] ,null, ['class' => 'form-control ingredients', 'multiple']) }}
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                    <hr>
                    {{ Form::open(['route' => 'recipe.only']) }}
                    <div class="form-group">
                    {{ Form::label('ingredients', 'Recipes that contains only the ff ingredients' ) }}
                    <div class="input-group">
                        {{ Form::select('ingredients[]', [] ,null, ['class' => 'form-control ingredients', 'multiple']) }}
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </div>                    
                    {{ Form::close() }}
                    <hr>
                    {{ Form::open(['route' => 'recipe.some']) }}
                    <div class="form-group">
                    {{ Form::label('ingredients', 'Recipes that some of the ff ingredients' ) }}
                    <div class="input-group select2-bootstrap-prepend">
                    
                        {{ Form::select('ingredients[]', [] ,null, ['class' => 'form-control ingredients', 'multiple']) }}
                    <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </div>    
                    </div>                    

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script>
    $(document).ready( function() {
        $(".ingredients").select2({
            "data" : 
                {{ $ingredients_grouped }}
        });
});
    
</script>
@endsection
