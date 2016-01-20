<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

    <div class="menu_section">
        <ul class="nav side-menu">
            <li {!! parent_link('dashboard', true) !!}>
                <a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Home</span></a>
            </li>
            <li {!! parent_link('dashboard/memo') !!}>
                <a><i class="fa fa-book"></i> {{ trans('common.memo')." & ".trans('common.item_request') }}</span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('dashboard.memo.create')}}">{{ trans('common.create_memo') }}</a></li>
                    <li><a href="{{route('dashboard.memo.index')}}">{{ trans('common.request_item_list') }}</a></li>
                    @if (Entrust::hasRole('pengadaan'))
                        <li><a href="{{route('memo.forwarded.index')}}">{{ trans('common.forward_procurement') }}</a></li>
                    @endif
                </ul>
            </li>
            @if (Entrust::hasRole('pengadaan'))
                <li {!! parent_link('dashboard/procurement') !!}>
                <a><i class="fa fa-bookmark"></i> {{ trans('common.procurement') }}</span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('dashboard.procurement.index')}}">{{ trans('common.procurement_list') }}</a></li>
                    <li><a href="{{route('dashboard.procurement.create')}}">{{ trans('common.add_procurement') }}</a></li>
                </ul>
            </li>
            @endif
            @if (Entrust::hasRole('administrator'))
                <li {!! parent_link('dashboard/announcement') !!}>
                    <a><i class="fa fa-file-text"></i> {{ trans('common.announcement') }}</span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{route('dashboard.announcement.index')}}">{{ trans('common.announcement_list') }}</a></li>
                        <li><a href="{{route('dashboard.announcement.create')}}">{{ trans('common.add_announcement') }}</a></li>
                    </ul>
                </li>
                <li {!! parent_link('dashboard/agenda') !!}>
                    <a><i class="fa fa-calendar"></i> {{ trans('common.agenda') }}</span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{route('dashboard.agenda.index')}}">{{ trans('common.agenda_list') }}</a></li>
                        <li><a href="{{route('dashboard.agenda.create')}}">{{ trans('common.add_agenda') }}</a></li>
                    </ul>
                </li>
                <li {!! parent_link('dashboard/users') !!}>
                    <a><i class="fa fa-user"></i> {{ trans('common.users') }}</span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{route('dashboard.users.index')}}">{{ trans('common.users_list') }}</a></li>
                        <li><a href="{{route('dashboard.users.create')}}">{{ trans('common.add_user') }}</a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>
<!-- /sidebar menu -->

<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
    &nbsp;
</div>
<!-- /menu footer buttons -->