@php 
    $colspan = 15;
    $custom_labels = json_decode(session('business.custom_labels'), true);
@endphp
<div class="table-responsive">
    <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all-row" data-table-id="product_table"></th>
                <th>@lang('messages.action')</th>
                <th>@lang('sale.product')</th>
                <th>@lang('Quantity')</th>
                <th>@lang('product.product_type')</th>
                <th>@lang('Total')</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td >
                <div style="display: flex; width: 100%;">
                    @can('product.delete')
                        {!! Form::open(['url' => action('OpeningStockController@massDestroy'), 'method' => 'post', 'id' => 'mass_delete_form' ]) !!}
                        {!! Form::hidden('selected_rows', null, ['id' => 'selected_rows']); !!}
                        {!! Form::submit(__('lang_v1.delete_selected'), array('class' => 'btn btn-xs btn-danger', 'id' => 'delete-selected')) !!}
                        {!! Form::close() !!}
                    @endcan
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>