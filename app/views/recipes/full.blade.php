@extends('layouts.master')

@section('content')
<div class="container">
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
</script>
@stop