<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}
//active_class((if_route('categories.show') && if_route_param('category', 1)))
function category_nav_active($category_id)
{
//    dd(active_class(if_route('category.show') && if_route_param('category', $category_id)));
//    dd(if_route_param('category', $category_id));

    return active_class(if_route('categories.show') && if_route_param('category', $category_id));
}
