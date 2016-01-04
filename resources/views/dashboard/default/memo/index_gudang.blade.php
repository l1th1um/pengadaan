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
                        {{ trans('common.memo_list') }}
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-lg-12">
                        <table class="table table-striped responsive-utilities jambo_table" id="memo_list">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{ trans('common.memo_no') }}</th>
                                <th width="25%">{{ trans('common.from') }}</th>
                                <th width="25%">{{ trans('common.memo_date') }}</th>
                                <th width="250px">Status</th>
                                <th width="100px"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                    <tr>
                                        <td>
                                            {{ $row->id }}
                                        </td>
                                        <td>
                                            <a href="{{route('dashboard.memo.process', $row->id)}}">
                                                {{ $row->memo_no }}
                                            </a>
                                        </td>
                                        <td>{{ $row->users->name }}</td>
                                        <td>{{ localeDate($row->memo_date) }}</td>
                                        <td>{{ trans('common.memo_status')[$row->memo_status] }}</td>
                                        <td class="center">
                                            <a href="{{route('dashboard.memo.destroy', $row->id)}}" data-method="delete" data-token="{{csrf_token()}}" data-confirm="{{ trans('common.are_you_sure') }}" style="padding-left : 10px">
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