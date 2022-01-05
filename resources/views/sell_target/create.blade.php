<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('SellTargetController@store'), 'method' => 'post', 'id' => $quick_add ? 'quick_add_target_form' : 'target_add_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'Add Target' )</h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('user_id', __( 'MPO' ) . ':*') !!}
        {!! Form::select('user_id', $users, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required']); !!}
      </div>
      <div class="form-group">
        {!! Form::label('target', __( 'Target' ) . ':*') !!}
          {!! Form::number('target', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'Target' ) ]); !!}
      </div>

      <div class="form-group">
        {!! Form::label('note', __( 'Note' ) . ':') !!}
          {!! Form::text('note', null, ['class' => 'form-control','placeholder' => __( 'Note' )]); !!}
      </div>

        @if($is_repair_installed)
          <div class="form-group">
             <label>
                {!!Form::checkbox('use_for_repair', 1, false, ['class' => 'input-icheck']) !!}
                {{ __( 'repair::lang.use_for_repair' )}}
            </label>
            @show_tooltip(__('repair::lang.use_for_repair_help_text'))
          </div>
        @endif

    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->