<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>

<div id="m_aside_left" class="m-grid__item	m-aside-left m-aside-left--skin-dark ">


    <div id="m_ver_menu" class="m-aside-menu m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark"
         data-menu-vertical="true" m-menu-scrollable="true" m-menu-dropdown-timeout="500">
        <ul class="m-menu__nav m-menu__nav--dropdown-submenu-arrow ">

                <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                    m-menu-submenu-toggle="click" m-menu-link-redirect="1">
                    <a href="javascript:;" class="m-menu__link m-menu__toggle" title="Website Content">
                        <i class="m-menu__link-icon flaticon-stopwatch"></i>
                        <span class="m-menu__link-text">@lang('admin.layouts.aside_left.group.contents')</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu ">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                           <!--
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/sub-categories') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-tags"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.sub_categories')</span>
                                </a>
                            </li>-->
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('admin/famous-people') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-user"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.famous_people')</span>
                                </a>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/categories') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-tag"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.categories')</span>
                                </a>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/category-meta') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-tag"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.category_meta')</span>
                                </a>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('admin/services') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-gift"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.services')</span>
                                </a>
                            </li>

                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/promotions') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-cart-plus"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.promotions')</span>
                                </a>
                            </li>

                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('admin/faqs') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-gift"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.faqs')</span>
                                </a>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('admin/service-feedbacks') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-gift"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.service_feedbacks')</span>
                                </a>
                            </li>
                            <li class="m-menu__section">
                                <h4 class="m-menu__section-text">@lang('admin.layouts.aside_left.section.news_events')</h4>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/event-types') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-newspaper-o"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.event_types')</span>
                                </a>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/events') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-newspaper-o"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.events')</span>
                                </a>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/news-types') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-newspaper-o"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.news_types')</span>
                                </a>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/news') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-newspaper-o"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.news')</span>
                                </a>
                            </li>

                            <li class="m-menu__section">
                                <h4 class="m-menu__section-text">@lang('admin.layouts.aside_left.section.galleries')</h4>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('admin/gallery-types') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-folder-open-o"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.gallery_types')</span>
                                </a>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('admin/galleries') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-photo"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.galleries')</span>
                                </a>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('admin/image-list') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-camera-retro"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.image_list')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                    m-menu-submenu-toggle="click" m-menu-link-redirect="1">
                    <a href="javascript:;" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon flaticon-tabs"></i>
                        <span class="m-menu__link-text">@lang('admin.layouts.aside_left.section.sequence')</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu ">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__section">
                                <h4 class="m-menu__section-text">@lang('admin.layouts.aside_left.section.sequence')</h4>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/menus/menus-sequence') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-list-ul"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.menus_sequence')</span>
                                </a>
                            </li>
                           <!-- <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/sub-menus/sub-menus-sequence') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-list-ul"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.sub_menus_sequence')</span>
                                </a>
                            </li>-->
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/categories/categories-sequence') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-list-ul"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.categories_sequence')</span>
                                </a>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/sub-categories/sub-categories-sequence') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-list-ul"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.sub_categories_sequence')</span>
                                </a>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/promotions/promotions-sequence') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-list-ul"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.promotions_sequence')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                    m-menu-submenu-toggle="click" m-menu-link-redirect="1">
                    <a href="javascript:;" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon flaticon-users"></i>
                        <span class="m-menu__link-text">@lang('admin.layouts.aside_left.group.contacts_users')</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu ">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/contacts') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-envelope"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.contacts')</span>
                                </a>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/users') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-users"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.users')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="m-menu__item m-menu__item--submenu " aria-haspopup="true"
                    m-menu-submenu-toggle="click" m-menu-link-redirect="1">
                    <a href="javascript:;" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon flaticon-settings"></i>
                        <span class="m-menu__link-text">@lang('admin.layouts.aside_left.group.settings')</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">

                            <!-- <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/menus') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon flaticon-menu-1"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.menus')</span>
                                </a>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/sub-menus') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon flaticon-menu"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.sub_menus')</span>
                                </a>
                            </li> -->
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ url('/admin/configurations') }}" class="m-menu__link ">
                                    <i class="m-menu__link-icon la la-wrench"></i>
                                    <span class="m-menu__link-text">@lang('admin.layouts.aside_left.menu.configurations')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
        </ul>
    </div>
</div>
<div class="m-aside-menu-overlay"></div>
