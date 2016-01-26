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
                        {{ trans('common.procurement_data') }}
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-lg-12">
                        @if (Route::getCurrentRoute()->getName() == 'dashboard.memo.edit')
                            {!! Form::model($memo, array('url' => action('MemoController@update', Request::segment(3)), 'class' => 'form-horizontal', 'method' => 'put', 'id' => 'add_memo')) !!}
                            <input type="hidden" name="memo_id" value="{{  Request::segment(3) }}"/>
                        @else
                            {!! Form::open(array('url' => action('MemoController@store'), 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'add_memo')) !!}
                            <input type="hidden" name="memo_id" value="0"/>
                        @endif
                            <input type="hidden" name="memo_url" value="{{  Route('dashboard.memo.index') }}"/>
                        <div class="form-body">
                            <div class="form-group">
                                <label for="inputName" class="col-md-3 control-label col-xs-3">
                                    {{ trans('common.research_coordinator') }}
                                </label>
                                <div class="col-md-4 col-xs-4">
                                    {!! Form::select('coordinator', $coordinator, null, array('id' => 'inputName', 'class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-3 control-label col-xs-4">
                                    {{ trans('common.ppk') }}
                                </label>
                                <div class="col-md-4 col-xs-4">
                                    {!! Form::select('commitment_official', $commitment_official, null, array('id' => 'inputName', 'class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <hr />
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-xs-12">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                                        + Tambahkan Item
                                    </button>
                                    <button type="button" class="btn btn-warning" id="del_row">
                                        - Hapus Item
                                    </button>
                                    <table class="table table-striped responsive-utilities jambo_table" id="item_memo_table">
                                        <thead>
                                            <tr>
                                                <th width="10px">id</th>
                                                <th>{{ trans('common.item_name') }}</th>
                                                <th>{{ trans('common.catalog') }}</th>
                                                <th width="100px">{{ trans('common.amount') }}</th>
                                                <th width="100px">{{ trans('common.unit') }}</th>
                                                <th width="100px">{{ trans('common.notes') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="form-actions pal">
                                <div class="form-group mbn">
                                    <div class="col-md-2 col-xs-2">
                                        <input type="hidden" name="items">
                                        @if (Route::getCurrentRoute()->getName() == 'dashboard.memo.edit')
                                            <button type="submit" class="btn btn-primary">Print</button>
                                        @else
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
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
                    {!! Form::open(array('url' => Request::url(), 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'addItemMemoModal')) !!}
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
                                {{ trans('common.catalog') }}
                            </label>
                            <div class="col-md-8 col-xs-8">
                                <input id="inputName autocomplete" class="form-control" type="text" name="catalog">
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
                                {{ trans('common.notes') }}
                            </label>
                            <div class="col-md-8 col-xs-8">
                                <input id="inputName" class="form-control" type="text" name="notes">
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