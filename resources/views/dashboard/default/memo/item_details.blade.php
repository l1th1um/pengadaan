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
                        {{ trans('common.memo_process') }}
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
                                    {!! Form::text('memo_no', $item->memo->memo_no, array('id' => 'inputName', 'class' => 'form-control', 'readonly' => true)) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.from') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('memo_no', $item->memo->users->name, array('id' => 'inputName', 'class' => 'form-control', 'readonly' => true)) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.memo_date') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('memo_no', localeDate($item->memo->memo_date, false), array('id' => 'inputName', 'class' => 'form-control', 'readonly' => true)) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.status') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::select('status',trans('common.memo_status'),$item->memo->memo_status,array('class' => 'form-control')); !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <hr />
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-xs-offset-2 col-md-10 col-xs-10">
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
    {!! Theme::js('js/datatables/js/jquery.dataTables.min.js')!!}
    {!! Theme::js('js/datatables/tools/js/dataTables.tableTools.js')!!}
    {!! Theme::js('js/bootstrap-datepicker.min.js')!!}
    {!! Theme::js('js/jasny-bootstrap.min.js')!!}
    {!! Theme::js('js/bootstrap-editable.min.js')!!}
    {!! Theme::css('css/bootstrap-editable.css')!!}
    {!! Theme::js('js/jquery.autocomplete.min.js')!!}
    {!! Theme::js('js/modules/memo.js')!!}

@stop