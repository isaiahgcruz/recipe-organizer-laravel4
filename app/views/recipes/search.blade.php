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
                                {{ Form::text('name', $recipe_name, ['class' => 'form-control']) }}
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
