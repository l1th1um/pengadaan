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
                        <table class="table table-striped responsive-utilities jambo_table" id="announcement_list">
                            <thead>
                            <tr>
                                <th>{{ trans('common.title') }}</th>
                                <th width="250px">{{ trans('common.date') }}</th>
                                <th width="100px"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                    <tr>
                                        <td> {{ $row->title }}</td>
                                        <td>{{ localeDate($row->created_at)}}</td>
                                        <td class="center">
                                            <a href="{{route('dashboard.announcement.edit', $row->id)}}">
                                                <img src="{{Theme::url('images/edit.png')}}">
                                            </a>
                                            <a href="{{route('dashboard.announcement.destroy', $row->id)}}" data-method="delete" data-token="{{csrf_token()}}" data-confirm="{{ trans('common.are_you_sure') }}" style="padding-left : 10px">
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
    <script type="text/javascript">
        $(document).ready(function()
        {
            /*User List*/
            $('#announcement_list').DataTable({
                "sPaginationType": "full_numbers",
                "order": [[ 1, "desc" ]]
            });
        })
    </script>
@stop