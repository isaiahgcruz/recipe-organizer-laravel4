@extends('layouts.master')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"> Search Result : </div>
                <div class="panel-body">
                    <h1>What can I cook with?</h1><br>
                    {{ Form::open(['route' => $route]) }}
                    <div class="form-group">
                    {{ Form::label('ingredients', $searchMsg ) }}
                    <div class="input-group">
                        {{ Form::select('ingredients[]', [] ,$ingredients_selected, ['class' => 'form-control ingredients', 'multiple']) }}
                        <span class="input-group-btn">
                            {{ Form::submit('=', ['class' => 'btn btn-default'])}} </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($recipes as $recipe)
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $recipe->name }} | Recipe</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Type</th>
                            <td>{{$recipe->type}}</td>
                            <th>Price</th>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Ingredients</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <ul>
                                @foreach ($recipe->ingredients as $ing)
                                    <li>{{ $ing->name }}</li>
                                @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>Instructions</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td colspan="4">{{ $recipe->instruction }}</td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach
    {{$recipes->links()}}
</div>
@stop

@section('scripts')
<script>
    $(document).ready( function() {
        $(".ingredients").select2({
            "data" : 
                {{ $ingredients_grouped }},
        });
        $(".ingredients").val({{$ingredients_selected}}).change();
    });

</script>
@endsection