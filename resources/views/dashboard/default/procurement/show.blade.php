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
                    <div class="col-md-8 col-xs-8 padding_0">
                        <h2>
                            {{ trans('common.procurement_data') }}
                        </h2>
                    </div>
                    <div class="col-md-4 col-xs-4 right">
                        {{--<a href="{{route('dashboard.procurement.purchase_order', Request::segment(3))}}" target="_blank">
                            <i class="fa fa-print fa-2x"></i>
                        </a>--}}

                        <a href="{{route('dashboard.procurement.edit', Request::segment(3))}}" style="padding-left : 20px">
                            <i class="fa fa-edit fa-2x"></i>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row line_30">
                        <div class="col-md-2 control-label col-xs-2">
                            <label for="inputName" class="control-label">
                                {{ trans('common.offering_letter_no') }}
                            </label>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            {{ $data->offering_letter_no }}
                        </div>
                        <div class="col-md-2 control-label col-xs-2">
                            <label for="inputName" class="control-label">
                                {{ trans('common.offering_letter_date') }}
                            </label>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            {{ localeDate($data->offering_letter_date) }}
                        </div>
                    </div>
                    <div class="row line_30">
                        <div class="col-md-2 control-label col-xs-2">
                            <label for="inputName" class="control-label">
                                {{ trans('common.company_name') }}
                            </label>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            {{ $data->company_name}}
                        </div>
                        <div class="col-md-2 control-label col-xs-2">
                            <label for="inputName" class="control-label">
                                {{ trans('common.company_address') }}
                            </label>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            {{ $data->address }}
                        </div>
                    </div>
                    <div class="row line_30">
                        <div class="col-md-2 control-label col-xs-2">
                            <label for="inputName" class="control-label">
                                {{ trans('common.company_phone') }}
                            </label>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            {{ $data->phone}}
                        </div>
                        <div class="col-md-2 control-label col-xs-2">
                            <label for="inputName" class="control-label">
                                {{ trans('common.company_fax') }}
                            </label>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            {{ $data->fax }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 control-label col-xs-2">
                            <label for="inputName" class="control-label">
                                {{ trans('common.contact_person') }}
                            </label>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            {{ $data->contact_person}}
                        </div>
                        <div class="col-md-2 control-label col-xs-2">
                            <label for="inputName" class="control-label">
                                {{ trans('common.offering_letter') }}
                            </label>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            @if (! empty($data->offering_letter))
                                <a href="{{ asset("/uploads")."/".$data->offering_letter }}" target="_blank">
                                    <i class="fa fa-file-photo-o"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="row line_30">
                        <div class="col-md-2 control-label col-xs-2">
                            <label for="inputName" class="control-label">
                                {{ trans('common.input_by') }}
                            </label>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            @if (isset($data->users->name))
                                {{ $data->users->name }}
                            @endif
                        </div>
                        <div class="col-md-2 control-label col-xs-2">
                            <label for="inputName" class="control-label">
                                {{ trans('common.input_date') }}
                            </label>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            {{ localeDate($data->created_at) }}
                        </div>
                    </div>
                    </div>

                    <div class="x_title">
                        <h2>
                            {{ trans('common.invoice') }}
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row line_30">
                            <div class="col-md-2 control-label col-xs-2">
                                <label for="inputName" class="control-label">
                                    {{ trans('common.status') }}
                                </label>
                            </div>
                            <div class="col-md-4 col-xs-4">
                                <a class="label label-success">
                                    {{ trans('common.proc_status')[$data->proc_status] }}
                                </a>
                            </div>
                            {{--<div class="col-md-2 control-label col-xs-2">
                                <label for="inputName" class="control-label">
                                    {{ trans('common.updated_by') }}
                                </label>
                            </div>
                            <div class="col-md-4 col-xs-4">
                                @if (! empty($data->invoice->users->name))
                                    {{ $data->invoice->users->name }}
                                @endif
                            </div>--}}
                        </div>
                        <div class="row line_30">
                            <div class="col-md-2 control-label col-xs-2">
                                <label for="inputName" class="control-label">
                                    {{ trans('common.invoice') }}
                                </label>
                            </div>
                            <div class="col-md-4 col-xs-4">
                                @if (! empty($data->invoice->path))
                                    <a href="{{ asset("/uploads")."/".$data->invoice->path }}" target="_blank">
                                        <i class="fa fa-file-photo-o"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="col-md-2 control-label col-xs-2">
                                <label for="inputName" class="control-label">
                                    {{ trans('common.payment_proof') }}
                                </label>
                            </div>
                            <div class="col-md-4 col-xs-4">
                                @if (! empty($data->payment_proof) )
                                    <a href="{{ asset("/uploads")."/".$data->payment_proof }}" target="_blank">
                                        <i class="fa fa-file-photo-o"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <table class="table table-striped responsive-utilities jambo_table" id="show_item">
                            <thead>
                            <tr>
                                <th>{{ trans('common.item_name') }}</th>
                                <th width="15%">{{ trans('common.amount') }}</th>
                                <th width="15%">{{ trans('common.unit') }}</th>
                                <th width="20%">{{ trans('common.unit_price') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($data->procurement_item as $row)
                                    <tr>
                                        <td>{{ $row->item_name }}</td>
                                        <td class="center">{{ number_format($row->amount) }}</td>
                                        <td>{{ $row->unit}}</td>
                                        <td class="right">{{ number_format($row->unit_price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                {!! Form::open(array('url' => action('ProcurementController@uploadInvoice', Request::segment(3)), 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'upload_invoice', 'files' => true)) !!}
                <div class="form-body">
                    <div class="form-group">
                        <label for="inputName" class="col-md-2 control-label col-xs-2">
                            {{ trans('common.upload_invoice') }}
                        </label>
                        <div class="col-md-10 col-xs-10">
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="invoice"></span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
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
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        {{ trans('common.purchase_order') }}
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    {!! Form::open(array('url' => action('ProcurementController@printPO', Request::segment(3)), 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'print_po')) !!}
                    <div class="form-body">
                        <div class="form-group">
                            <label for="inputName" class="col-md-2 control-label col-xs-2">
                                {{ trans('common.purchase_order_no') }}
                            </label>
                            <div class="col-md-10 col-xs-10">
                                {!! Form::text('purchase_order_no',$letter_no, array('id' => 'inputName', 'class' => 'form-control')); !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-md-2 control-label col-xs-2">
                                {{ trans('common.date') }}
                            </label>
                            <div class="col-md-10 col-xs-10">
                                {!! Form::text('po_letter_date', $po_letter_date, array('id' => 'inputName', 'class' => 'form-control', 'required' => true, 'autocomplete' => 'off')); !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-md-2 control-label col-xs-2">
                                {{ trans('common.tos') }}
                            </label>
                            <div class="col-md-10 col-xs-10">
                                {!! Form::textarea('additional_info',$additional_info, array('id' => 'inputName', 'class' => 'form-control editor')); !!}
                            </div>
                        </div>
                        <div class="form-actions pal">
                            <div class="form-group mbn">
                                <div class="col-md-2 col-xs-2 right">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                                <div class="col-md-10 col-xs-10 right">
                                    @if ($po_letter_date)
                                    <a href="{{route('dashboard.procurement.purchase_order', Request::segment(3))}}" target="_blank" class="btn btn-info">
                                        <i class="fa fa-print"></i> Print
                                    </a>
                                    @endif
                                    {{--<a href="{{route('dashboard.procurement.purchase_order', Request::segment(3))}}" target="_blank">
                            <i class="fa fa-print fa-2x"></i>
                        </a>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        {{ trans('common.procurement_status') }}
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    {!! Form::open(array('url' => Request::url(), 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'add_invoice', 'files' => true)) !!}
                    <div class="form-body">
                        <div class="form-group">
                            <label for="inputName" class="col-md-2 control-label col-xs-2">
                                {{ trans('common.status') }}
                            </label>
                            <div class="col-md-10 col-xs-10">
                                {!! Form::select('status',trans('common.proc_status'),$data->proc_status,array('class' => 'form-control')); !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-md-2 control-label col-xs-2">
                                {{ trans('common.upload_payment_proof') }}
                            </label>
                            <div class="col-md-10 col-xs-10">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                    <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="payment_proof"></span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
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


@stop

@section('footer_js')
    {!! Theme::css('css/datatables/tools/css/dataTables.tableTools.css')!!}
    {!! Theme::css('css/bootstrap-datepicker.min.css')!!}
    {!! Theme::css('css/jasny-bootstrap.css')!!}
    {!! Theme::css('css/summernote.css')!!}
    {!! Theme::js('js/datatables/js/jquery.dataTables.min.js')!!}
    {!! Theme::js('js/datatables/tools/js/dataTables.tableTools.js')!!}
    {!! Theme::js('js/bootstrap-datepicker.min.js')!!}
    {!! Theme::js('js/jasny-bootstrap.min.js')!!}
    <!-- richtext editor -->
    {!! Theme::js('js/summernote.min.js')!!}
    {!! Theme::js('js/bootstrap-editable.min.js')!!}
    {!! Theme::js('js/modules/procurement.js')!!}

    <script type="text/javascript">
        $(document).ready(function(){
            $('.editor').summernote({
                height: 200,
                tabsize: 2,
                styleWithSpan: false,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['mics',['codeview']]
                ]
            });
        });
    </script>
@stop
