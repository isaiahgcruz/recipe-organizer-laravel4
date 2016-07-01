@extends('layouts.master')

@section('content')
<div class="container">
    <div id="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Recipes <span class="pull-right"><a href="{{ route('recipe.full' )}}">Full View</a></span></div>
                <div class="panel-body">
                    <table id="recipes-table" class="display table table-bordered" width="100%">
                        <thead>
                            <tr>
                                
                                <th>Name</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recipes as $recipe)
                                <tr>

                                    <td>{{$recipe->name}}</td>
                                    <td>{{$recipe->type}}</td>
                                    <td> {{ link_to_route('recipe.show', 'View', $recipe->id) }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Recipes</div>
                <div class="panel-body">
                    {{ Form::open([ 'route'=>'recipe.store',  'id' => 'recipes-add']) }}
                    <div class="form-group">
                        {{ Form::label('name', 'Name:') }}
                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('instruction', 'Instruction:') }}
                        {{ Form::textarea('instruction', null, ['class' => 'form-control']) }}
                    </div>
                    {{-- <div class="form-group">
                        {{ Form::label('serving_size', 'Serving Size:') }}
                        {{ Form::text('serving_size', null, ['class' => 'form-control']) }}
                    </div> --}}
                    <div class="form-group">
                        {{ Form::label('type', 'Type:') }}
                        {{ Form::select('type', $recipe_types, null, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('ingredients', 'Ingredients:') }}
                        {{ Form::select('ingredients[]', $ingredients_list, null, ['class' => 'form-control select2', 'multiple' => 'multiple']) }}
                    </div>
                    <br />

                        {{ Form::submit('Add Recipe', ['class' => 'btn btn-default pull-right']) }}

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script>

var select2 = $('.select2').select2({
    
});
    $(document).ready(function () {
        $('#alert').hide();
        iTable = $("#recipes-table").DataTable({
            "paging": 5,
            "sorting": false, 
        });
    });

    $("#recipes-add").submit(function(e){
            e.preventDefault(); 
            $.ajax({
                type: "POST",
                url: '{{ route('recipe.store') }}',
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
                    if (data['alert'] == 'success')
                    {
                        $("input[name=name]").val("");
                        $("input[name=instruction]").val("");
                        $("select[name=type]").val(0);
                        $('.select2').val("").change();
                    }
                }
            })
        });

</script>
@stop