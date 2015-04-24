@extends('crud::app')

@section('content')
<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">@if(isset($form->getModel()->name))
            Edit {{$form->getModel()->name}} Data
            @else
            Create New Example
            @endif</h3>
    </div><!-- /.box-header -->
    <div class="box-body pad">
        {!! form($form) !!}
    </div>
</div>

@endsection

