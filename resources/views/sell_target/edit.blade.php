<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('SellTargetController@update', [$sell_target->id]), 'method' => 'PUT', 'id' => 'target_edit_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'Edit Target' )</h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('user_id', __( 'MPO' ) . ':*') !!}
        {!! Form::select('user_id', $users, $sell_target->user_id??null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required']); !!}
      </div>
      <div class="form-group">
        {!! Form::label('target', __( 'Target' ) . ':*') !!}
          {!! Form::text('target', $sell_target->target, ['class' => 'form-control', 'required', 'placeholder' => __( 'Target' )]); !!}
      </div>

      <div class="form-group">
        {!! Form::label('note', __( 'Note' ) . ':') !!}
          {!! Form::text('note', $sell_target->note, ['class' => 'form-control','placeholder' => __( 'Note' )]); !!}
      </div>

        @if($is_repair_installed)
          <div class="form-group">
             <label>
                {!!Form::checkbox('use_for_repair', 1, $sell_target->use_for_repair, ['class' => 'input-icheck']) !!}
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