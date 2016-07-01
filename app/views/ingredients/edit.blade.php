@extends('layouts.master')

@section('content')
<div class="container">
    <div id="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Update Ingredients</div>
                <div class="panel-body">
                    {{ Form::open(['route' => ['ingredient.update', $ingredient->id], 'method' => 'PUT', 'id' => 'ingredient-edit']) }}
                    <div class="form-group">
                        {{ Form::label('name', 'Name:') }}
                        {{ Form::text('name', $ingredient->name, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('type', 'Type:') }}
                        {{ Form::select('type', $ingredient_types, $ingredient->type, ['class' => 'form-control']) }}
                    </div>
                    <br />

                        {{ Form::submit('Update Ingredient', ['class' => 'btn btn-default pull-right']) }}

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@stop


@section('scripts')
<script>

    $('#alert').hide();
    $("#ingredient-edit").submit(function(e){
        
            e.preventDefault(); 
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(data) {
                    console.log(data);
                    $('#alert').show();
                    $('#alert').removeClass('alert alert-success alert-danger');
                    $("#alert").addClass('alert alert-'+data['alert']);
                    var html = "";
                    for (var i = 0; i < data['messages'].length; i++) {
                        html += "<li>" + data['messages'][i] + "</li>";
                    }
                    $('#alert').html(html);
                }
            })
        });
</script>

@endsection