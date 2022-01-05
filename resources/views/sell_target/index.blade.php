@extends('layouts.app')
@section('title', 'Sell Target')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'Sell Target' )
        <small>@lang( 'Manage Your Sell Target' )</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'All Your Sell target' )])
        @can('role.create')
            @slot('tool')
                <div class="box-tools">
                    <button type="button" class="btn btn-block btn-primary btn-modal" 
                        data-href="{{action('SellTargetController@create')}}" 
                        data-container=".target_modal">
                        <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
                </div>
            @endslot
        @endcan
        @can('role.view')
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="target_table">
                    <thead>
                        <tr>
                            <th>@lang( 'Target' )</th>
                            <th>@lang( 'MPO' )</th>
                            <th>@lang( 'Note' )</th>
                            <th>@lang( 'messages.action' )</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endcan
    @endcomponent

    <div class="modal fade target_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection
