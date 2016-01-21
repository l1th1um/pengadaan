@include('login.header_login')

<body style="background:#F7F7F7;">
<h1 style="font-size: 48px;text-align:center;font-family: 'Lato', sans-serif;">
    {{ Config::get('qilara.site_name') }}
</h1>
<div class="">
    <a class="hiddenanchor" id="tologin"></a>
    <div id="wrapper">
        <div id="login" class="animate form">
            @if (count($errors) > 0)
                <div class="alert alert-danger" style="margin-bottom : 50px">
                    <ul style="list-style : none">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <section class="login_content circleBase circle1">
                {!! Form::open(array('action' => 'DashboardController@login', 'class' => 'form-horizontal', 'method' => 'post')) !!}
                    <h2>Login Form</h2>
                    <div>
                        <input type="text" class="form-control col-md-6" placeholder="Username" required="" name="username" value="{{ old('username') }}" />
                    </div>
                    <div>
                        <input type="password" class="form-control" placeholder="Password" required="" name="password" />
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">
                            Sign In
                        </button>
                    </div>
                {!! Form::close() !!}
                <!-- form -->
            </section>
            <!-- content -->
        </div>
    </div>
</div>

<div class="row" style="padding : 0 30px">
    <div class="col-md-6 col-xs-6">
        <div class="x_panel tile fixed_height_390">
            <div class="x_title">
                <h2>Pengumuman</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-9 col-xs-9">
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
        </div>
    </div>

    <div class="col-md-6  col-xs-6">
        <div class="x_panel tile fixed_height_390">
            <div class="x_title">
                <h2  style="float: right">Agenda</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-offset-3 col-xs-offset-3 col-md-9 col-xs-9">
                        <div id="my-calendar"></div>
                    </div>
                </div>

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


    <div style="text-align: center">
        <p>©2016 Qilara CMS</p>
    </div>
{!! Theme::js('js/bootstrap.min.js') !!}
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

            $.get( "../show_announcement/" + id, function( data ) {
                var json = JSON.parse(data);

                $('.modal-title2').html(json.title);
                $('.modal-body2').html(json.content);
                $('.announcement_modal').modal();
            });
        })
    });
</script>
</body>

</html>



