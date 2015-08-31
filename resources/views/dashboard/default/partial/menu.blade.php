<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

    <div class="menu_section">
        <ul class="nav side-menu">
            <li {!! parent_link('dashboard', true) !!}>
                <a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Home</span></a>
            </li>
            <li {!! parent_link('dashboard/procurement') !!}>
            <a><i class="fa fa-server"></i> {{ trans('common.procurement') }}</span></a>
            <ul class="nav child_menu">
                <li><a href="{{route('dashboard.procurement.index')}}">{{ trans('common.procurement_list') }}</a></li>
                <li><a href="{{route('dashboard.procurement.create')}}">{{ trans('common.add_procurement') }}</a></li>
            </ul>
            </li>
        </ul>
    </div>
</div>
<!-- /sidebar menu -->

<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
    &nbsp;
</div>
<!-- /menu footer buttons -->