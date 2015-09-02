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
                        @if (Route::getCurrentRoute()->getName() == 'dashboard.procurement.edit')
                            {!! Form::model($procurement, array('url' => action('ProcurementController@update', Request::segment(3)), 'class' => 'form-horizontal', 'method' => 'put', 'id' => 'add_procurement', 'files' => true)) !!}
                        @else
                            {!! Form::open(array('url' => action('ProcurementController@store'), 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'add_procurement', 'files' => true)) !!}
                        @endif
                        <div class="form-body">
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.offering_letter_no') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('offering_letter_no',null, array('id' => 'inputName', 'class' => 'form-control', 'required' => true)); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.offering_letter_date') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('offering_letter_date', $date, array('id' => 'inputName', 'class' => 'form-control', 'required' => true, 'autocomplete' => 'off')); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.company_name') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('company_name',null, array('id' => 'inputName', 'class' => 'form-control', 'required' => true)); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.company_address') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::textarea('address',null, array('class' => 'form-control', 'rows' => 3)); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.company_phone') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('phone',null, array('id' => 'inputName', 'class' => 'form-control')); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.company_fax') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('fax',null, array('id' => 'inputName', 'class' => 'form-control')); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.contact_person') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('contact_person',null, array('id' => 'inputName', 'class' => 'form-control')); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.offering_letter') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                        <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="offering_letter"></span>
                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                    @if (Route::getCurrentRoute()->getName() == 'dashboard.procurement.edit')
                                        <div class="col-md-3 col-xs-3">
                                            <a href="#" class="thumbnail">
                                                <img src="{{ asset("/uploads")."/".$procurement->offering_letter }}" >
                                            </a>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="form-group">
                                <hr />
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-xs-offset-2 col-md-10 col-xs-10">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                                        + Tambahkan Item
                                    </button>
                                    <button type="button" class="btn btn-warning" id="del_row">
                                        - Hapus Item
                                    </button>
                                    <table class="table table-striped responsive-utilities jambo_table" id="item_table">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>{{ trans('common.item_name') }}</th>
                                                <th width="15%">{{ trans('common.amount') }}</th>
                                                <th width="15%">{{ trans('common.unit') }}</th>
                                                <th width="20%">{{ trans('common.unit_price') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
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

    <script type="text/javascript">
        var oTable;
    </script>

    @if (Route::getCurrentRoute()->getName() == 'dashboard.procurement.edit')
        <script type="text/javascript">
            var dataSet = {!! $items !!}
            $(document).ready(function(){
                oTable = $('#item_table').DataTable({
                    data: dataSet,
                    "paging":   false,
                    "ordering": false,
                    "info":     false,
                    "searching" : false,
                    "aoColumns": [
                        { "sTitle": "ID"},
                        { "sTitle": "Nama Barang"},
                        { "sTitle": "Jumlah", "sClass": "right"},
                        { "sTitle": "Satuan" },
                        { "sTitle": "Harga Satuan", "sClass": "right"}
                    ],
                    "columnDefs": [
                        {
                            "targets": [ 0 ],
                            "visible": false,
                        }
                    ]
                } );
            });
        </script>
    @else
        <script type="text/javascript">
            $(document).ready(function(){
                oTable = $('#item_table').DataTable({
                    "paging":   false,
                    "ordering": false,
                    "info":     false,
                    "searching" : false,
                    "aoColumns": [
                        { "sTitle": "ID"},
                        { "sTitle": "Nama Barang"},
                        { "sTitle": "Jumlah", "sClass": "right"},
                        { "sTitle": "Satuan" },
                        { "sTitle": "Harga Satuan", "sClass": "right"}
                    ],
                    "columnDefs": [
                        {
                            "targets": [ 0 ],
                            "visible": false,
                        }
                    ]
                } );
            });
        </script>
    @endif

    {!! Theme::js('js/modules/procurement.js')!!}

@stop