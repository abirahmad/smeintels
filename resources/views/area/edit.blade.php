<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('AreaController@update', [$area->id]), 'method' => 'PUT', 'id' => 'area_edit_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'Edit Area' )</h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('name', __( 'Area Name' ) . ':*') !!}
          {!! Form::text('name', $area->name, ['class' => 'form-control', 'required', 'placeholder' => __( 'Area Name' )]); !!}
      </div>

      <div class="form-group">
        {!! Form::label('code', __( 'Code' ) . ':') !!}
          {!! Form::text('code', $area->code, ['class' => 'form-control','placeholder' => __( 'Code' )]); !!}
      </div>

        @if($is_repair_installed)
          <div class="form-group">
             <label>
                {!!Form::checkbox('use_for_repair', 1, $area->use_for_repair, ['class' => 'input-icheck']) !!}
                {{ __( 'repair::lang.use_for_repair' )}}
            </label>
            @show_tooltip(__('repair::lang.use_for_repair_help_text'))
          </div>
        @endif

    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.update' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->