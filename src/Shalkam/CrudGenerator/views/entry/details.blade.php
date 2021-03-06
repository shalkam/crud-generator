@extends('crud::app')

@section('title')
{{ $entry->name }}
<button type="button" class="btn btn-danger btn-sm pull-right" style="margin-top: -5px" data-toggle="modal" data-target="#myModal">
    <i class="glyphicon glyphicon-remove"></i> Delete {{ $params['name'] }}
</button>
@endsection

@section('content')

<ul>
    @foreach ($entry->getAttributes() as $id=> $val)
    <li>{{ $id }} : {{$val}}</li>
    @endforeach
</ul>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete {{ $params['name'] }}</h4>
            </div>
            {!! Form::model($entry, array('route' => array($params['route'].'.destroy', $entry->id), 'method'=>'DELETE')) !!}
            <div class="modal-body">
                Are you sure you want to delete this {{ $params['name'] }} data?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {!! Form::submit("Delete {$params['name']}", ['class'=>'btn btn-danger' ]) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection