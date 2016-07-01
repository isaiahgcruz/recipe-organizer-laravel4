@extends('layouts.master')

@section('content')
<div class="container">
    <div id="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Ingredients</div>
                <div class="panel-body">
                    <table id="ingredients-table" class="display table table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ingredients as $ingredient)
                                <tr>
                                    <td>{{$ingredient->name}}</td>
                                    <td>{{$ingredient->type}}</td>
                                    <td>{{ link_to_route('ingredient.edit', 'Edit' ,['id' => $ingredient->id])}}</td>

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
                <div class="panel-heading">Add Ingredients</div>
                <div class="panel-body">
                    {{ Form::open(['id' => 'ingredients-add']) }}
                    <div class="form-group">
                        {{ Form::label('name', 'Name:') }}
                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('type', 'Type:') }}
                        {{ Form::select('type', $ingredient_types, null, ['class' => 'form-control']) }}
                    </div>
                    <br />

                        {{ Form::submit('Add Ingredient', ['class' => 'btn btn-default pull-right']) }}

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script>
var iTable;
$('#alert').hide();
    $(document).ready(function () {
        $('#alert').hide();
        iTable = $("#ingredients-table").DataTable({
            "paging": 5,
            "order" : [[1, "asc"], [0, "asc"]] 
        });
    });

    $("#ingredients-add").submit(function(e){
            e.preventDefault(); 
            $.ajax({
                type: "POST",
                url: '{{ route('ingredient.store') }}',
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
                        
                        iTable.row.add([$("input[name=name]").val(),$("select[name=type] option:selected").text()]).draw().sort().node();
                        $("input[name=name]").val("");
                        $("select[name=type]").val(1);
                    }
                }
            })
        });

</script>
@stop