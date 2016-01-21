@extends('../index')

@section('content')
    @if (Session::has('message'))
        <div class="row">
            <div class="alert alert-success" role="alert">
                <p>{{ Session::get('message') }}</p>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-6 col-xs-6">
            <div class="x_panel tile fixed_height_390">
                <div class="x_title">
                    <h2>Pengumuman</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if ($announcement)
                        @foreach($announcement as $val)
                            <article class="media event">
                                <a class="pull-left date">
                                    <p class="month">{{ getMonth($val->created_at) }}</p>
                                    <p class="day">{{ getDay($val->created_at) }}</p>
                                </a>
                                <div class="media-body">
                                    <a class="title announcement" href="javascript://ajax" alt="{{ $val->id }}">{{ $val->title }}</a>
                                    <p>{!! str_limit($val->content, 100) !!}</p>
                                </div>
                            </article>
                        @endforeach
                    @else
                        Belum Ada Pengumuman
                    @endif


                </div>
            </div>
        </div>

        <div class="col-md-6  col-xs-6">
            <div class="x_panel tile fixed_height_390">
                <div class="x_title">
                    <h2>Agenda</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="my-calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade announcement_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title2">Modal title</h4>
                </div>
                <div class="modal-body2">
                    <p>One fine body&hellip;</p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('footer_js')
{!! Theme::css('css/zabuto_calendar.min.css')!!}
{!! Theme::js('js/zabuto_calendar.min.js')!!}
<script type="application/javascript">
    $(document).ready(function () {
        $("#my-calendar").zabuto_calendar({
            today: true,
            ajax: {
                url: '{{ route('show_agenda') }}',
                modal: true
            }
        });

        $('.announcement').click(function(){
            var id = $(this).attr("alt");

            $.get( "show_announcement/" + id, function( data ) {
                var json = JSON.parse(data);

                $('.modal-title2').html(json.title);
                $('.modal-body2').html(json.content);
                $('.announcement_modal').modal();
            });
        })
    });
</script>
@stop