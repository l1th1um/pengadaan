@extends('../index')

@section('content')
    @if (Session::has('message'))
        <div class="row">
            <div class="alert alert-success" role="alert">
                <p>{{ Session::get('message') }}</p>
            </div>
        </div>
    @endif

    @if (Session::has('memo_id'))
    <script type="text/javascript">
        window.open('{!! route('dashboard.memo.printMemo', Session::get('memo_id')) !!}','_blank');
    </script>
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
                        {{ trans('common.request_item_list') }}
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-lg-12">
                        <table class="table table-striped responsive-utilities jambo_table" id="memo_list">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th width="120px">{{ trans('common.memo_no') }}</th>
                                <th width="180px">{{ trans('common.memo_date') }}</th>
                                <th>{{ trans('common.item_name') }}</th>
                                <th>{{ trans('common.catalog') }}</th>
                                <th width="150px">{{ trans('common.amount') }}</th>
                                <th width="150px">Status</th>
                                <th width="100px"></th>
                            </tr>
                            </thead>
                            <tbody>
                             @foreach($data as $row)
                                <tr>
                                    <td>
                                        {{ $row->memo_id }}
                                    </td>
                                    <td>{{ $row->memo_no }}</td>
                                    <td>{{ localeDate($row->memo_date) }}</td>
                                    <td>{{ $row->item_name }}</td>
                                    <td>{{ $row->catalog }}</td>
                                    <td>{{ $row->amount." ". $row->unit}}</td>
                                    <td>
                                        <span class="label label-success">
                                            {{ trans('common.request_item_status')[$row->status] }}
                                        </span>
                                        @if (!empty($row->procurement_status))
                                            <span class="label label-warning">
                                                {{ trans('common.forward_procurement_status')[$row->procurement_status] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="center">
                                        <a href="{{route('dashboard.memo.edit', $row->memo_id)}}">
                                            <img src="{{Theme::url('images/edit.png')}}">
                                        </a>
                                        <a href="{{route('dashboard.memo.destroy', $row->memo_id)}}" data-method="delete" data-token="{{csrf_token()}}" data-confirm="{{ trans('common.are_you_sure_remove_request_item') }}" style="padding-left : 10px">
                                            <img src="{{Theme::url('images/delete.png')}}">
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_js')
    {!! Theme::css('css/datatables/tools/css/dataTables.tableTools.css')!!}
    {!! Theme::js('js/datatables/js/jquery.dataTables.min.js')!!}
    {!! Theme::js('js/autoNumeric.js')!!}
    {!! Theme::js('js/laravel.js')!!}
    {!! Theme::css('css/bootstrap-datepicker.min.css')!!}
    {!! Theme::js('js/bootstrap-datepicker.min.js')!!}
    {!! Theme::js('js/bootstrap-datepicker.min.js')!!}
    {!! Theme::js('js/modules/memo.js')!!}
@stop