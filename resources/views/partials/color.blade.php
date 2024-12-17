@if($setting->primary_color)
    <style>
        body[data-sidebar=dark] .vertical-menu,body[data-sidebar=dark] .navbar-brand-box,.bg-primary{
            background: {{ $setting->primary_color }} !important;
        }
        body[data-sidebar=dark] .mm-active .active,.btn-primary,body[data-sidebar=dark] #sidebar-menu ul>li>a.mm-active,body[data-sidebar=dark] .mm-active>a{
            background-color: {{ $setting->primary_color }} !important;
        }
        .active>.page-link, .page-link.active{
            background-color: {{ $setting->primary_color }} !important;
            border-color: {{ $setting->primary_color }} !important;

        }
    </style>
@endif