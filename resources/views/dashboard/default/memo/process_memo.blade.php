@extends('../index')

@section('content')
    @if (Session::has('message'))
        <div class="row">
            <div class="alert alert-success" role="alert">
                <p>{{ Session::get('message') }}</p>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="row">
            <div class="alert alert-error" role="alert">
                <p>{{$errors->first()}}</p>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        {{ $title }}
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-lg-12">
                        {!! Form::open(array('url' => action('MemoController@updateMemoStatus', Request::segment(4)), 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'add_procurement')) !!}
                        <input type="hidden" name="memo_id" value="{{  Request::segment(4) }}"/>
                        <input type="hidden" name="memo_url" value="{{  Route('dashboard.memo.index') }}"/>

                        <div class="form-body">
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.memo_no') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('memo_no', $memo->memo_no, array('id' => 'inputName', 'class' => 'form-control', 'readonly' => true)) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.from') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('memo_no', $memo->name, array('id' => 'inputName', 'class' => 'form-control', 'readonly' => true)) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.memo_date') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('memo_no', localeDate($memo->memo_date, false), array('id' => 'inputName', 'class' => 'form-control', 'readonly' => true)) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.item_name') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('item_name', $memo->item_name, array('id' => 'inputName', 'class' => 'form-control', 'readonly' => true)) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.catalog') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('catalog', $memo->catalog, array('id' => 'inputName', 'class' => 'form-control', 'readonly' => true)) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.amount') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('amount', $memo->amount." ". $memo->unit, array('id' => 'inputName', 'class' => 'form-control', 'readonly' => true)) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.notes') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('notes', $memo->notes, array('id' => 'inputName', 'class' => 'form-control', 'readonly' => true)) !!}
                                </div>
                            </div>
                            @if (Entrust::hasRole('gudang'))
                                <div class="form-group">
                                    <label for="inputName" class="col-md-2 control-label col-xs-2">
                                        {{ trans('common.status') }}
                                    </label>
                                    <div class="col-md-10 col-xs-10">
                                        {!! Form::select('status',trans('common.request_item_status'),$memo->status,array('class' => 'form-control')); !!}
                                    </div>
                                </div>
                            @endif
                            @if (Entrust::hasRole('pengadaan'))
                                <div class="form-group">
                                    <label for="inputName" class="col-md-2 control-label col-xs-2">
                                        {{ trans('common.status') }}
                                    </label>
                                    <div class="col-md-10 col-xs-10">
                                        {!! Form::select('procurement_status',trans('common.forward_procurement_status'),$memo->procurement_status,array('class' => 'form-control')); !!}
                                    </div>
                                </div>
                                <div class="form-actions pal">
                                    <div class="form-group mbn">
                                        <div class="col-md-2 col-xs-2 right">
                                            <input type="hidden" name="items">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Item</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(array('url' => Request::url(), 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'addItemModal')) !!}
                    <div class="form-body">
                        <div class="form-group">
                            <label for="inputName" class="col-md-4 control-label col-xs-4">
                                {{ trans('common.item_name') }}
                            </label>
                            <div class="col-md-8 col-xs-8">
                                <input id="inputName" class="form-control" type="text" name="item_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-md-4 control-label col-xs-4">
                                {{ trans('common.amount') }}
                            </label>
                            <div class="col-md-8 col-xs-8">
                                <input id="inputName" class="form-control numeric" type="text" name="amount">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-md-4 control-label col-xs-4">
                                {{ trans('common.unit') }}
                            </label>
                            <div class="col-md-8 col-xs-8">
                                <input id="inputName" class="form-control" type="text" name="unit">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-md-4 control-label col-xs-4">
                                {{ trans('common.unit_price') }}
                            </label>
                            <div class="col-md-8 col-xs-8">
                                <input id="inputName" class="form-control numeric" type="text" name="unit_price">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_js')
    {!! Theme::css('css/datatables/tools/css/dataTables.tableTools.css')!!}
    {!! Theme::css('css/bootstrap-datepicker.min.css')!!}
    {!! Theme::css('css/jasny-bootstrap.css')!!}
    {!! Theme::js('js/datatables/js/jquery.dataTables.min.js')!!}
    {!! Theme::js('js/datatables/tools/js/dataTables.tableTools.js')!!}
    {!! Theme::js('js/bootstrap-datepicker.min.js')!!}
    {!! Theme::js('js/jasny-bootstrap.min.js')!!}
    {!! Theme::js('js/bootstrap-editable.min.js')!!}
    {!! Theme::css('css/bootstrap-editable.css')!!}
    {!! Theme::js('js/jquery.autocomplete.min.js')!!}
    {!! Theme::js('js/modules/memo.js')!!}

@stop