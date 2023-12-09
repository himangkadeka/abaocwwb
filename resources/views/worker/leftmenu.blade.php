<div class="dashboard-bgcolor border-right border-bottom" id="sidebar-wrapper">
    <div class="sidebar-heading text-sm-left  b-db-color" style="font-size: 24px">
        <span class="fas fa-user"></span> &nbsp;<span>{{$wrkr->first_name}} {{$wrkr->last_name}}</span>
    </div>
    <div class="list-group list-group-flush b-leftmenu">

        <ul id="sortable-menu">
            <li><a href='#' class="dashboard-bgcolor b-db-color border-bottom b-newpage">Dashboard</a></li>
            <li class='sub-menu'><a href='javascript:void(0)' class="dashboard-bgcolor border-bottom b-db-color b-newpage">Application History<div class='fa fa-caret-down right'></div></a>
                <ul>
{{--                    <li><a class="b-newpage" href='state'>State</a></li>--}}
{{--                    <li><a class="b-newpage" href='#'>District</a></li>--}}
                </ul>
            </li>
            <li class='sub-menu'><a href='javascript:void(0)' class="dashboard-bgcolor border-bottom b-db-color b-newpage">Schemes<div class='fa fa-caret-down right'></div></a>
                <ul>
                    <li><a class="b-newpage" href='{{route('worker-claimed-schemes')}}'>Claimed Schemes</a></li>
                    <li><a class="b-newpage" href='#'>List</a></li>
                </ul>
            </li>
{{--            <li class='sub-menu'><a href='javascript:void(0)' class="dashboard-bgcolor border-bottom b-db-color b-newpage">Role<div class='fa fa-caret-down right'></div></a>--}}
{{--                <ul>--}}
{{--                    <li><a class="b-newpage" href='#'>Create</a></li>--}}
{{--                    <li><a class="b-newpage" href='#'>List</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class='sub-menu'><a href='javascript:void(0)' class="dashboard-bgcolor border-bottom b-db-color b-newpage">Users<div class='fa fa-caret-down right'></div></a>--}}
{{--                <ul>--}}
{{--                    <li><a class="b-newpage" href='#'>Create</a></li>--}}
{{--                    <li><a class="b-newpage" href='#'>List</a></li>--}}
{{--                    <li><a class="b-newpage" href='#'>Activate</a></li>--}}
{{--                    <li><a class="b-newpage" href='#'>Deactivate</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
            <!--<li><a href='table.html' class="dashboard-bgcolor border-bottom b-newpage b-db-color">Tables</a></li>
            <li><a href='forms.html' class="dashboard-bgcolor border-bottom b-newpage b-db-color">Forms</a></li>
            <li class='sub-menu'><a href='javascript:void(0)' class="dashboard-bgcolor border-bottom b-db-color b-newpage">UI Elements<div class='fa fa-caret-down right'></div></a>
                <ul>
                    <li><a href='typography.html' class="b-newpage">Typography</a></li>
                    <li><a href='buttons.html' class="b-newpage">Buttons</a></li>
                    <li><a href='cards.html' class="b-newpage">Cards</a></li>
                    <li><a href='icons.html' class="b-newpage">Icons</a></li>
                </ul>
            </li>
            <li class='sub-menu'><a href='javascript:void(0)' class="dashboard-bgcolor border-bottom b-db-color b-newpage">Multi-level Dropdown<div class='fa fa-caret-down right'></div></a>
                <ul>
                    <li><a href='javascript:void(0);' class="b-newpage">Second Level Item</a></li>
                    <li><a href='javascript:void(0)' class="b-newpage">Second Level Item</a></li>
                    <li class='sub-sub-menu'><a href='javascript:void(0);' class="b-newpage">Third Level <div class='fa fa-caret-down right'></div></a>
                        <ul>
                            <li><a href='javascript:void(0)' class="b-newpage">Third Level Item</a></li>
                            <li><a href='javascript:void(0);' class="b-newpage">Third Level Item</a></li>
                            <li><a href='javascript:void(0)' class="b-newpage">Third Level Item</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>-->

        </ul>
    </div>
</div>
