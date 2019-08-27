<?php

return [
    'confirm' => [
        'delete' => [
            'text' => 'Are you sure you want to delete? You won\'t be able to revert this!',
            'confirm_button' => 'Yes',
            'cancel_button' => 'Cancel'
        ]
    ],
    'buttons' => [
        'create' => 'Create',
        'update' => 'Update',
        'cancel' => 'Cancel',
        'upload' => 'Upload Image',
        'save_change' => 'Lưu Thay Đổi',
        'back' => 'Back',
    ],
    'tooltip_title' => [
        'edit' => 'Edit',
        'delete' => 'Delete',
        'duplicate' => 'Duplicate',
        'change_sequence' => 'Drag and drop to change sequence'
    ],
    'layouts' => [
        'header' => [
            'logout' => 'Logout',
            'my_profile' => 'My Profile'
        ],
        'aside_left' => [
            'group' => [
                'reservations' => 'Reservations',
                'contents' => 'Contents',
                'contacts_users' => 'Contacts & Users',
                'settings' => 'Settings',
                'order' => 'Orders'
            ],
            'section' => [
                'events' => 'Events',
                'galleries' => 'Galleries',
                'sequence' => 'Change Sequence',
                'news_events' => 'News and Event'
            ],
            'menu' => [
                'reservations' => 'Reservations',
                'items' => 'Items',
                'categories' => 'Treatment Package Type',
                'sub_categories' => 'Sub Categories',
                'famous_people' => 'Famous People',
                'events' => 'Events',
                'event_types' => 'Event Type',
                'news' => 'News',
                'news_types' => 'News Type',
                'services' => 'Treatment Package',
                'gallery_types' => 'Gallery Types',
                'galleries' => 'Galleries',
                'contacts' => 'Contacts',
                'users' => 'Users',
                'currencies' => 'Currencies',
                'payment_method' => 'Payment Methods',
                'menus' => 'Menus',
                'sub_menus' => 'Sub Menus',
                'promotions' => 'Promotions',
                'configurations' => 'Setting',
                'menus_sequence' => 'Menus',
                'sub_menus_sequence' => 'Sub Menus',
                'categories_sequence' => 'Treatment Package Type',
                'sub_categories_sequence' => 'Sub Categories',
                'promotions_sequence' => 'Promotions',
                'items_sequence' => 'Items',
                'roles' => 'Roles',
                'email_template' => 'Email Template',
                'weekly_menus' => 'Weekly Menus',
                'abouts_us' => 'Abouts Us',
                'image_list' => 'Image Storage',
                'booking' => 'Booking',
                'order' => 'Order',
                'faqs' => 'Asked & Answer',
                'service_feedbacks' => 'Customer Feedback',
                'category_meta'=> 'Danh mục'
            ],
        ],
        'breadcrumbs' => [
            'change_sequence' => 'Change sequence'
        ]
    ],
    'users' => [
        'search' => [
            'status' => 'Status',
            'role' => 'Role',
            'place_holder_text' => 'Search by name or email...'
        ],
        'title' => [
            "details" => 'Personal Detail',
            "role" => 'Role and Permission',
            'update_profile' => 'Update Profile',
            'message' => 'Message',
            'settings' => 'Settings',
            'change_password' => 'Change Password',
        ],
        'columns' => [
            'full_name' => 'Full Name',
            'email' => 'Email',
            'phone' => 'Phone Number',
            'dob' => 'Day of Birth',
            'address' => 'Address',
            'role' => 'Role',
            'locked' => 'Locked',
            'status' => 'Status',
            'action' => 'Action',
            'current_password' => 'Current Password',
            'new_password' => 'New Password',
            'confirm_new_password' => 'Confirm New Password',
        ],
        'breadcrumbs' => [
            'title' => 'Users',
            'user_index' => 'Users list',
            'my_profile' => 'My profile'
        ],
        'statuses' => [
            'all' => 'All',
            'locked' => 'Locked',
            'active' => 'Active'
        ],
        'roles' => [
            'all' => 'All',
            'select_role' => 'Select Role',
            'user' => 'Regular User',
            'admin' => 'Admin'
        ],
        'not_found' => 'Don\'t have any user!'
    ],
    'items' => [
        'search' => [
            'category' => 'Category',
            'sub_category' => 'Sub Category',
            'place_holder_text' => 'Search by name...'
        ],
        'text' => [
            'all' => 'All',
            'category' => 'Choose Category',
            'sub_category' => 'Choose Sub Category',
            'upload_text' => 'Drop file here or click to upload',
            'sub_item_name' => 'Item name'
        ],
        'createButton' => 'Add New Item',
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'price' => 'Price',
            'discount_price' => 'Discount Price',
            'item_type' => 'Menu Item type',
            'image' => 'Image',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'description_ja' => 'Japanese Description',
            'active' => 'Status',
            'sub_category' => 'Sub Category',
            'sub_sub_category' => 'Sub Sub Categories',
            'category' => 'Category',
            'action' => 'Action',
            'sequence' => 'Sequence',
            'normal_item' => 'Normal Item',
            'set_item' => 'Set Item',
            'weekly_item' => 'Weekly Item',
            'begin_date' => 'Begin Date',
            'end_date' => 'End Date',
            'thumb_image' => 'Thumb Image'
        ],
        'breadcrumbs' => [
            'title' => 'Items',
            'item_index' => 'Items list',
            'item_create' => 'Add item',
            'item_update' => 'Edit item',
        ],
        'not_found' => 'Don\'t have any items!',
        'flash_message' => [
            'new' => 'Item has been created!',
            'update' => 'Item has been updated!',
            'destroy' => 'Item has been deleted!',
        ],
    ],
    'contacts' => [
        'search' => [
            'date' => 'Date',
            'place_holder_text' => 'Search by email...',
            'date_place_holder_text' => 'Select date'
        ],
        'columns' => [
            'name' => 'Name',
            'phone' => 'Phone Number',
            'email' => 'Email',
            'content' => 'Content',
            'note' => 'Note',
            'created_date' => 'Created Date',
            'action' => 'Action'
        ],
        'breadcrumbs' => [
            'title' => 'Contacts',
            'contact_index' => 'Contacts list',
            'contact_update' => 'Edit contact',
            'contact_detail' => 'Contact Detail',
        ],
        'flash_message' => [
            'update' => 'Contact has been updated!',
        ],
        'not_found' => 'Don\'t have any contacts!'
    ],
    'gallery_types' => [
        'search' => [
            'status' => 'Status'
        ],
        'status' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'createButton' => 'Add New Gallery Type',
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'active' => 'Status',
            'action' => 'Action'
        ],
        'breadcrumbs' => [
            'title' => 'Gallery type',
            'gallery_type_index' => 'Gallery types list',
            'gallery_type_create' => 'Add gallery type',
            'gallery_type_update' => 'Edit gallery type'
        ],
        'flash_message' => [
            'update' => 'Gallery type has been updated!',
            'new' => 'Gallery type has been created!',
            'destroy' => 'Gallery type has been deleted!',
            'can\'t_destroy' => 'Can not delete because gallery type is in used!'
        ],
        'not_found' => 'Don\'t have any gallery types!'
    ],
    'galleries' => [
        'search' => [
            'gallery_type' => 'Gallery Type'
        ],
        'createButton' => 'Add New Gallery',
        'text' => [
            'all' => 'All',
            'upload_text' => 'Drop file here or click to upload'
        ],
        'status' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'columns' => [
            'image' => 'Image',
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'gallery_type' => 'Gallery Type',
            'active' => 'Status',
            'action' => 'Action'
        ],
        'breadcrumbs' => [
            'title' => 'Galleries',
            'gallery_index' => 'Galleries list',
            'gallery_create' => 'Add gallery',
            'gallery_update' => 'Edit gallery',
        ],
        'flash_message' => [
            'update' => 'Gallery has been updated!',
            'new' => 'Gallery has been created!',
            'destroy' => 'Gallery has been deleted!',
            'not_allowed' => 'You can upload only 14 image!'
        ],
        'not_found' => 'Don\'t have any galleries'
    ],
    'menus' => [
        'search' => [
            'status' => 'Status',
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'url' => 'URL',
            'sequence' => 'Sequence',
            'status' => 'Status',
            'action' => 'Action'
        ],
        'forms' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'url' => 'URL',
            'status' => 'Status',
            'active' => 'Action'
        ],
        'breadcrumbs' => [
            'title' => 'Menus',
            'menu_index' => 'Menu list',
            'new_menu' => 'New menu',
            'data_of_menu' => 'Data of menu',
            'add_menu' => 'Add menu',
            'edit_menu' => 'Edit menu',
            'delete_menu' => 'Delete menu',
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'upgrate' => 'Upgrate',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Menu created!',
            'update' => 'Menu updated!',
            'destroy' => 'Menu deleted!',
            'can\'t_destroy' => 'Can not delete because menu is in used'
        ],
        'not_found' => 'Don\'t have any menus!'
    ],
    'sub_menus' => [
        'search' => [
            'status' => 'Status',
            'menu' => 'Menu type',
            'choose' => 'Choose Menu Type',
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'url' => 'URL',
            'sequence' => 'Sequence',
            'menu_types' => 'Menu Types',
            'status' => 'Status',
            'action' => 'Action'
        ],
        'forms' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'url' => 'URL',
            'menu_types' => 'Menu Types',
            'status' => 'Status',
            'active' => 'Action'
        ],
        'breadcrumbs' => [
            'title' => 'Sub menus',
            'sub_menu_index' => 'Sub menu list',
            'new_sub_menu' => 'New sub menu',
            'data_of_sub_menu' => 'Data of sub menu',
            'add_menu' => 'Add menu',
            'edit_menu' => 'Edit menu',
            'delete_menu' => 'Delete menu'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'upgrate' => 'Upgrate',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Sub menu created!',
            'update' => 'Sub menu updated!',
            'destroy' => 'Sub Menu deleted!',
            'can\'t_destroy' => 'Can not delete because sub menu is in used'
        ],
        'not_found' => 'Don\'t have any sub menus!'
    ],
    'famous_people' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'description_vi' => 'Description Vietnamese',
            'description_en' => 'Description English',
            'image' => 'Image',
            'status' => 'Status',
            'action' => 'Action'
        ],
        'forms' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'status' => 'Status',
            'active' => 'Active',
            'link_video' => 'Link Video',
            'description_en' => 'Description English',
            'description_vi' => 'Description Vietnamese',
        ],
        'breadcrumbs' => [
            'title' => 'Famous People',
            'all' => 'All',
            'famous_people_index' => 'Famous people list',
            'new_famous_people' => 'New famous people',
            'data_of_famous_people' => 'Data of famous people',
            'add_famous_people' => 'Add famous people',
            'edit_famous_people' => 'Edit famous people',
            'delete_famous_people' => 'Delete famous people'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Famous People created!',
            'update' => 'Famous People updated!',
            'destroy' => 'Famous People deleted!',
            'can\'t_destroy' => 'Can not delete because Famous People is in used'
        ],
        'not_found' => 'Don\'t have any Famous People!'
    ],

    'faq' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'columns' => [
            'question_en' => 'English Question',
            'question_vi' => 'Vietnamese Question',
            'anwser_en' => 'English Answer',
            'anwser_vi' => 'Vietnamese Answer',
            'image' => 'Image',
            'status' => 'Status',
            'action' => 'Action'
        ],
        'forms' => [
            'question_en' => 'English Question',
            'question_vi' => 'Vietnamese Question',
            'anwser_en' => 'English Answer',
            'anwser_vi' => 'Vietnamese Answer',
            'status' => 'Status',
            'active' => 'Active',
        ],
        'breadcrumbs' => [
            'title' => 'FAQ',
            'all' => 'Tất Cả',
            'faq_index' => 'FAQ list',
            'new_faq' => 'New FAQ',
            'data_of_faq' => 'Data of FAQ',
            'add_faq' => 'Add FAQ',
            'edit_faq' => 'Edit FAQ',
            'delete_faq' => 'Delete FAQ'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'FAQ created!',
            'update' => 'FAQ updated!',
            'destroy' => 'FAQ deleted!',
            'can\'t_destroy' => 'Can not delete because FAQ is in used'
        ],
        'not_found' => 'Don\'t have any FAQ!'
    ],
    'service_feedback' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'image' => 'Image',
            'status' => 'Status',
            'action' => 'Action'
        ],
        'forms' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'status' => 'Status',
            'active' => 'Active',
        ],
        'breadcrumbs' => [
            'title' => 'Feedback',
            'all' => 'Tất Cả',
            'service_feedback_index' => 'Feedback list',
            'new_service_feedback' => 'New Feedback',
            'data_of_service_feedback' => 'Data of Feedback',
            'add_service_feedback' => 'Add Feedback',
            'edit_service_feedback' => 'Edit Feedback',
            'delete_service_feedback' => 'Delete Feedback'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Feedback created!',
            'update' => 'Feedback updated!',
            'destroy' => 'Feedback deleted!',
            'can\'t_destroy' => 'Can not delete because Feedback is in used'
        ],
        'not_found' => 'Don\'t have any Feedback!'
    ],

    'event_types' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'status' => 'Status',
            'action' => 'Action'
        ],
        'forms' => [
            'name_en' => 'English name',
            'name_vi' => 'Vietnamese name',
            'name_ja' => 'Japanese name',
            'slug' => 'Slug',
            'status' => 'Status',
            'active' => 'Active'
        ],
        'breadcrumbs' => [
            'title' => 'Event types ',
            'event_type_index' => 'Event type list',
            'new_event_type' => 'New event type',
            'data_of_event_type' => 'Data of event type',
            'add_event_type' => 'Add event type',
            'edit_event_type' => 'Edit event type',
            'delete_event_type' => 'Delete event type'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'upgrate' => 'Upgrate',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Event type created!',
            'update' => 'Event type updated!',
            'destroy' => 'Event type deleted!',
            'can\'t_destroy' => 'Can not delete because event type is in used'
        ],
        'not_found' => 'Don\'t have any event types!',
    ],
    'events' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'text' => [
            'all' => 'All',
            'upload_text' => 'Drop file here or click to upload'
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'status' => 'Status',
            'action' => 'Action',
            'image' => 'Image',
        ],
        'forms' => [
            'name_en' => 'English name',
            'name_vi' => 'Vietnamese name',
            'status' => 'Status',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'short_description_en' => 'English Short Description',
            'short_description_vi' => 'Vietnamese Short Description',
            'image' => 'Image',
            'video' => 'Link Video',
            'active' => 'Active',
            'event_type' => 'Event Type',
            'location' => 'Location',
            'timeline' => 'Timeline',
            'date_begin' => 'Date Begin'
        ],
        'breadcrumbs' => [
            'title' => 'Event',
            'all' => 'All',
            'event_index' => 'Event list',
            'new_event' => 'New event',
            'data_of_event' => 'Data of event',
            'add_event' => 'Add event',
            'edit_event' => 'Edit event',
            'delete_event' => 'Delete event'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Event created!',
            'update' => 'Event updated!',
            'destroy' => 'Event deleted!',
            'can\'t_destroy' => 'Can not delete because event is in used'
        ],
        'not_found' => 'Don\'t have any events!',
    ],
    'news_types' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'status' => 'Status',
            'action' => 'Action'
        ],
        'forms' => [
            'name_en' => 'English name',
            'name_vi' => 'Vietnamese name',
            'name_ja' => 'Japanese name',
            'slug' => 'Slug',
            'status' => 'Status',
            'active' => 'Active'
        ],
        'breadcrumbs' => [
            'title' => 'Event types ',
            'event_type_index' => 'News type list',
            'new_news_type' => 'New News type',
            'data_of_news_type' => 'Data of News type',
            'add_news_type' => 'Add News type',
            'edit_news_type' => 'Edit News type',
            'delete_news_type' => 'Delete News type'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'upgrate' => 'Upgrate',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'News type created!',
            'update' => 'News type updated!',
            'destroy' => 'News type deleted!',
            'can\'t_destroy' => 'Can not delete because News type is in used'
        ],
        'not_found' => 'Don\'t have any News types!',
    ],
    'news' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'text' => [
            'all' => 'All',
            'upload_text' => 'Drop file here or click to upload'
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'status' => 'Status',
            'action' => 'Action',
            'image' => 'Image',
        ],
        'forms' => [
            'name_en' => 'English name',
            'name_vi' => 'Vietnamese name',
            'status' => 'Status',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'short_description_en' => 'English Short Description',
            'short_description_vi' => 'Vietnamese Short Description',
            'image' => 'Image',
            'video' => 'Link Video',
            'active' => 'Active',
            'news_type' => 'Event Type',
            'location' => 'Location',
            'timeline' => 'Timeline',
            'date_begin' => 'Date Begin'
        ],
        'breadcrumbs' => [
            'title' => 'News',
            'all' => 'All',
            'news_index' => 'News list',
            'new_news' => 'New news',
            'data_of_news' => 'Data of news',
            'add_news' => 'Add news',
            'edit_news' => 'Edit news',
            'delete_news' => 'Delete news'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Event created!',
            'update' => 'Event updated!',
            'destroy' => 'Event deleted!',
            'can\'t_destroy' => 'Can not delete because news is in used'
        ],
        'not_found' => 'Don\'t have any events!',
    ],
    'services' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'text' => [
            'all' => 'All',
            'upload_text' => 'Drop file here or click to upload'
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'status' => 'Status',
            'action' => 'Action',
            'image' => 'Image',
        ],
        'forms' => [
            'name_en' => 'English name',
            'name_vi' => 'Vietnamese name',
            'status' => 'Status',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'short_description_en' => 'English Short Description',
            'short_description_vi' => 'Vietnamese Short Description',
            'image' => 'Image',
            'video' => 'Link Video',
            'active' => 'Active',
            'chosen_package' => 'Choose Treatment Package Type',
            'chosen_faq' => 'Choose FAQ to display',
            'chosen_service_feebacks' => 'Choose Customer Feedback to display',
            'chosen_promotion' => 'Choose Promotion to display',
            'image_before' => 'Image Before',
            'image_after' => 'Image After'
        ],
        'breadcrumbs' => [
            'title' => 'Treatment Package',
            'all' => 'All',
            'service_index' => 'Treatment Package list',
            'new_service' => 'New Treatment Package',
            'data_of_service' => 'Data of Treatment Package',
            'add_service' => 'Add Treatment Package',
            'edit_service' => 'Edit Treatment Package',
            'delete_service' => 'Delete Treatment Package'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Treatment Package created!',
            'update' => 'Treatment Package updated!',
            'destroy' => 'Treatment Package deleted!',
            'can\'t_destroy' => 'Can not delete because Treatment Package is in used'
        ],
        'not_found' => 'Don\'t have any Treatment Package!',
    ],
    'categories' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'status' => 'Status',
            'action' => 'Action'
        ],
        'forms' => [
            'name_en' => 'English name',
            'name_vi' => 'Vietnamese name',
            'name_ja' => 'Japanese name',
            'status' => 'Status',
            'active' => 'Active',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'description_ja' => 'Japanese Description',
        ],
        'breadcrumbs' => [
            'title' => 'Treatment Package Type',
            'category_index' => 'Treatment Package Type list',
            'new_category' => 'New Treatment Package Type',
            'data_of_category' => 'Data of Treatment Package Type',
            'add_category' => 'Add Treatment Package Type',
            'edit_category' => 'Edit Treatment Package Type',
            'delete_category' => 'Delete Treatment Package Type'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'upgrate' => 'Upgrate',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Treatment Package Type created!',
            'update' => 'Treatment Package Type updated!',
            'destroy' => 'Treatment Package Type deleted!',
            'can\'t_destroy' => 'Can not delete because Treatment Package Type is in used'
        ],
        'not_found' => 'Don\'t have any Treatment Package Type!',
    ],
    'category_meta' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'action' => 'Action'
        ],
        'forms' => [
            'name_en' => 'English name',
            'name_vi' => 'Vietnamese name',
            'active' => 'Active',
        ],
        'breadcrumbs' => [
            'title' => 'Treatment Package Type',
            'category_meta_index' => 'Treatment Package Type list',
            'new_category_meta' => 'New Treatment Package Type',
            'data_of_category_meta' => 'Data of Treatment Package Type',
            'add_category_meta' => 'Add Treatment Package Type',
            'edit_category_meta' => 'Edit Treatment Package Type',
            'delete_category_meta' => 'Delete Treatment Package Type'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'upgrate' => 'Upgrate',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Treatment Package Type created!',
            'update' => 'Treatment Package Type updated!',
            'destroy' => 'Treatment Package Type deleted!',
            'can\'t_destroy' => 'Can not delete because Treatment Package Type is in used'
        ],
        'not_found' => 'Don\'t have any Treatment Package Type!',
    ],
    'sub_categories' => [
        'search' => [
            'status' => 'Status',
            'category' => 'Category',
            'place_holder_text' => 'Search by name...',
            'choose' => 'Choose category'
        ],
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'categories' => 'Categories',
            'status' => 'Status',
            'action' => 'Action',
            'sequence' => 'Sequence',
        ],
        'forms' => [
            'categories' => 'Categories',
            'sub_sub_categories' => 'Sub Categories',
            'name_en' => 'English name',
            'name_vi' => 'Vietnamese name',
            'name_ja' => 'Japanese name',
            'status' => 'Status',
            'active' => 'Active',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'description_ja' => 'Japanese Description',
        ],
        'breadcrumbs' => [
            'title' => 'Sub categories',
            'category' => 'Category',
            'all' => 'All',
            'sub_category_index' => 'Sub categories list',
            'new_sub_category' => 'New sub category',
            'data_of_sub_category' => 'Data of sub category',
            'add_sub_category' => 'Add sub category',
            'edit_sub_category' => 'Edit sub category',
            'delete_sub_category' => 'Delete sub category'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'upgrate' => 'Upgrate',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Sub category created!',
            'update' => 'Sub category updated!',
            'destroy' => 'Sub category deleted!',
            'can\'t_destroy' => 'Can not delete because sub category is in used'
        ],
        'not_found' => 'Don\'t have any sub categories!',
    ],
    'promotions' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'text' => [
            'all' => 'All',
            'upload_text' => 'Drop file here or click to upload'
        ],
        'columns' => [
            'begin_date' => 'Begin Date',
            'end_date' => 'End Date',
            'name_vi' => 'Vietnamese Name',
            'status' => 'Status',
            'action' => 'Action',
            'image' => 'Image',
            'sequence' => 'Sequence',
        ],
        'forms' => [
            'name_en' => 'English name',
            'name_vi' => 'Vietnamese name',
            'status' => 'Status',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'short_description_en' => 'English Short Description',
            'short_description_vi' => 'Vietnamese Short Description',
            'begin_date' => 'Begin Date',
            'end_date' => 'End Date',
            'image' => 'Image',
            'active' => 'Active',
            'video' => 'Link Video',
            'enable_detail_page' => 'Enable detail page',
            'page_url' => 'Page url',
            'showinhomepage' => "Show in homepage"
        ],
        'breadcrumbs' => [
            'title' => 'Promotions',
            'promotion_index' => 'Promotion list',
            'new_promotion' => 'New promotion',
            'data_of_promotion' => 'Data of promotion',
            'add_promotion' => 'Add promotion',
            'edit_promotion' => 'Edit promotion',
            'delete_promotion' => 'Delete promotion'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Promotion created!',
            'update' => 'Promotion updated!',
            'destroy' => 'Promotion deleted!',
            'can\'t_destroy' => 'Can not delete because promotion is in used',
            'change_sequence' => 'Sequence has been changed',
            'change_sequence_error' => 'Something wrong, please try again later!'
        ],
        'not_found' => 'Don\'t have any promotions!',
    ],
    'service_feedback' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by name...'
        ],
        'text' => [
            'all' => 'All',
            'upload_text' => 'Drop file here or click to upload'
        ],
        'columns' => [
            'name_vi' => 'Vietnamese Name',
            'status' => 'Status',
            'action' => 'Action',
            'image' => 'Image',
            'description_vi' => 'Vietnamese Description',
        ],
        'forms' => [
            'name_en' => 'English name',
            'name_vi' => 'Vietnamese name',
            'status' => 'Status',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'image' => 'Image',
            'active' => 'Active',
            'video' => 'Link Video',
        ],
        'breadcrumbs' => [
            'title' => 'Customer Feedback',
            'promotion_index' => 'Customer Feedback list',
            'new_promotion' => 'New customer feedback',
            'data_of_promotion' => 'Data of customer feedback',
            'add_promotion' => 'Add customer feedback',
            'edit_promotion' => 'Edit customer feedback',
            'delete_promotion' => 'Delete customer feedback'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Customer feedback created!',
            'update' => 'Customer feedback updated!',
            'destroy' => 'Customer feedback deleted!',
            'can\'t_destroy' => 'Can not delete because customer feedback is in used',
            'change_sequence' => 'Sequence has been changed',
            'change_sequence_error' => 'Something wrong, please try again later!'
        ],
        'not_found' => 'Don\'t have any customer feedback!',
    ],
    'currencies' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Search by code...'
        ],
        'columns' => [
            'code' => 'Code',
            'symbol' => 'Symbol',
            'exchange_rate' => 'Exchange Rate',
            'status' => 'Status',
            'action' => 'Action',
        ],
        'forms' => [
            'code' => 'Code',
            'symbol' => 'Symbol',
            'exchange_rate' => 'Exchange Rate',
            'status' => 'Status',
            'active' => 'Active',
        ],
        'breadcrumbs' => [
            'title' => 'Currencies exchange rate',
            'currency_index' => 'Currency exchange rate list',
            'new_currency' => 'New currency',
            'data_of_currency' => 'Data of currency',
            'add_currency' => 'Add currency',
            'edit_currency' => 'Edit currency',
            'delete_currency' => 'Delete currency'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Create',
            'upgrate' => 'Upgrate',
            'cancel' => 'Cancel'
        ],
        'flash_messages' => [
            'new' => 'Currencies exchange rate created!',
            'update' => 'Currencies exchange rate updated!',
            'destroy' => 'Currencies exchange rate deleted!',
            'can\'t_destroy' => 'Can not delete because currencies exchange rate is in used'
        ],
        'not_found' => 'Don\'t have any currencies!',
    ],
    'configurations' => [
        'text' => [
            'all' => 'All',
            'upload_text' => 'Drop file here or click to upload'
        ],
        'forms' => [
            'social_network' => 'Social network',
            'cogfig_key' => 'Cogfig key',
            'config_logo' => 'Config logo',
            'url' => 'URL',
            'image' => 'Image',
            'status' => 'Status',
            'is_publish' => 'Public',
            'promotion_display' => 'Promotion display',
            'localization' => 'Localization',
            'on' => 'on',
            'facebook_message_url' => 'Facebook message url',
            'email_admin_received' => 'Email admin received',
            'contact_name_en' => 'Contact name(en)',
            'contact_name_vi' => 'Contact name(vi)',
            'contact_name_ja' => 'Contact name(ja)',
            'contact_address_en' => 'Contact address(en)',
            'contact_address_vi' => 'Contact address(vi)',
            'contact_address_ja' => 'Contact address(ja)',
            'contact_email' => 'Contact email',
            'contact_phone' => 'Contact phone',
            'sms_message' => 'Sms Message',
        ],
        'breadcrumbs' => [
            'title' => 'Config',
            'edit_configuration' => 'Edit configuration',
        ],
        'buttons' => [
            'upgrate' => 'Update',
            'reset' => 'Reset'
        ],
        'flash_messages' => [
            'update' => 'Config updated!',
        ],
    ],
    'roles' => [
        'title' => [
            'all' => 'All Roles',
            'members' => 'Members',
            'users' => 'Users',
            'galleries' => 'Galleries',
            'gallery_types' => 'Gallery Type',
            'items' => 'Items',
            'events' => 'Events',
            'event_types' => 'Event Types',
            'categories' => 'Categories',
            'sub_categories' => 'Sub Categories',
            'menus' => 'Menus',
            'sub_menus' => 'Sub Menus',
            'currencies' => 'Currencies',
            'contacts' => 'Contacts',
            'roles' => 'Roles',
            'configurations' => 'Configurations',
            'promotions' => 'Promotions',
            'delete' => 'Delete',
            'payment_methods' => 'Payment Method',
            'email_templates' => 'Email Template',
            'weekly_menus' => 'Weekly Menu',
            'abouts_us' => 'About Us',
            'images_list' => 'Image List'
        ],
        'checkbox_title' => [
            'users_view' =>  'View User Profile',
            'users_manage' =>  'Manage User Profile',
            'galleries_view' =>  'View All Galleries',
            'galleries_manage' =>  'Manage All Galleries',
            'gallery_types_view' =>  'View All Gallery Types',
            'gallery_types_manage' =>  'Manage All Gallery Types',
            'items_view' =>  'View All Items',
            'items_manage' =>  'Manage All Items',
            'events_view' =>  'View All Events',
            'events_manage' =>  'Manage All Events',
            'event_types_view' =>  'View All Event Types',
            'event_types_manage' =>  'Manage All Event Types',
            'categories_view' =>  'View All Categories',
            'categories_manage' =>  'Manage All Categories',
            'sub_categories_view' =>  'View All Sub Categories',
            'sub_categories_manage' =>  'Manage All Sub Categories',
            'menus_view' =>  'View All Menus',
            'menus_manage' =>  'Manage All Menus',
            'sub_menus_view' =>  'View All Sub Menus',
            'sub_menus_manage' =>  'Manage All Sub Menus',
            'currencies_view' =>  'View All Currencies',
            'currencies_manage' =>  'Manage All Currencies',
            'contacts_view' =>  'View All Contacts',
            'contacts_manage' =>  'Manage All Contacts',
            'roles_view' =>  'View All Roles',
            'roles_manage' =>  'Manage All Roles',
            'configurations_view' =>  'View All Configurations',
            'configurations_manage' =>  'Manage All Configurations',
            'promotions_view' =>  'View All Promotions',
            'promotions_manage' =>  'Manage All Promotions',
            'payment_methods_view' =>  'View All Payment',
            'payment_methods_manage' =>  'Manage All Payment',
            'email_templates_view' =>  'View All Email Template',
            'email_templates_manage' =>  'Manage All Email Template',
            'weekly_menus_view' =>  'View All Weekly Menus',
            'weekly_menus_manage' =>  'Manage All Weekly Menus',
            'abouts_us_view' =>  'View All Abouts Us',
            'abouts_us_manage' =>  'Manage All Abouts Us',
            'images_list_view' =>  'View All Images',
            'images_list_manage' =>  'Manage All Images',
        ],
        'breadcrumbs' => [
            'title' => 'Roles',
            'role_index' => 'Roles list',
            'role_create' => 'Add new role ',
            'role_update' => 'Edit role',
            'role_show' => 'Role Detail'
        ],
        'column' => [
            'role_name' => 'Role Name',
            'permission' => 'Permission',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'last_login' => 'Last Login',
            'action' => 'Action'
        ],
        'buttons' => [
            'form_create' => 'Create',
            'index_create' => 'Create New Role',
            'form_edit' => 'Update',
            'index_edit' => 'Edit Role',
            'delete' => 'Delete Role',
            'cancel' => 'Cancel',
            'add_user' => 'Add User'
        ],
        'modal' => [
            'title' => 'Add New User',
            'close' => 'Close',
            'add' => 'Add',
            'select' => 'Select User'
        ],
        'flash_messages' => [
            'new' => 'Role has been created!',
            'update' => 'Role has been updated!',
            'delete' => 'Role has been deleted!',
            'can\'t_delete' => 'Cannot delete because role is being used!',
            'add_user' => 'User has been add to role!',
            'delete_user' => 'User has been delete from role!'
        ],
    ],
    'payment_methods' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' =>'Search by name...'
        ],
        'status' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'createButton' => 'Add Payment Method',
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'active' => 'Status',
            'action' => 'Action'
        ],
        'breadcrumbs' => [
            'title' => 'Payment Methods',
            'payment_methods_index' => 'Payment Methods list',
            'payment_methods_create' => 'Add Payment Method',
            'payment_methods_update' => 'Edit Payment Method'
        ],
        'flash_message' => [
            'update' => 'Payment Method has been updated!',
            'new' => 'Payment Method has been created!',
            'destroy' => 'Payment Method has been deleted!',
            'can\'t_destroy' => 'Can not delete because Payment Method is in used!'
        ],
        'not_found' => 'Don\'t have any Payment Method!',
        'forms' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'description_ja' => 'Japanese Description',
            'status' => 'Status',
            'active' => 'Active'
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ]
    ],
    'email_templates' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' =>'Search by name...'
        ],
        'status' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'createButton' => 'Add Email Template',
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'active' => 'Status',
            'action' => 'Action'
        ],
        'breadcrumbs' => [
            'title' => 'Email Templates',
            'email_templates_index' => 'Email Templates list',
            'email_templates_create' => 'Add Email Template',
            'email_templates_update' => 'Edit Email Template'
        ],
        'flash_message' => [
            'update' => 'Email Template has been updated!',
            'new' => 'Email Template has been created!',
            'destroy' => 'Email Template has been deleted!',
            'can\'t_destroy' => 'Can not delete because Email Template is in used!'
        ],
        'not_found' => 'Don\'t have any Email Template!',
        'forms' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'description_ja' => 'Japanese Description',
            'status' => 'Status',
            'active' => 'Active'
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ]
    ],
    'weekly_menus' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' =>'Search by name...'
        ],
        'status' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'createButton' => 'Add Weekly Menu',
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'active' => 'Status',
            'action' => 'Action',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'description_ja' => 'Japanese Description',
            'image' => 'Image',
            'from_date' => 'From Date',
            'to_date' => 'To Date'
        ],
        'breadcrumbs' => [
            'title' => 'Weekly Menus',
            'weekly_menus_index' => 'Weekly Menus list',
            'weekly_menus_create' => 'Add Weekly Menu',
            'weekly_menus_update' => 'Edit Weekly Menu'
        ],
        'flash_message' => [
            'update' => 'Weekly Menu has been updated!',
            'new' => 'Weekly Menu has been created!',
            'destroy' => 'Weekly Menu has been deleted!',
            'can\'t_destroy' => 'Can not delete because Weekly Menu is in used!',
            'can\'t_create' => 'Can not create because menus has exist this week!',
            'can\'t_update' => 'Can not update because menus has exist this week!',
        ],
        'not_found' => 'Don\'t have any Weekly Menu!',
        'forms' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'description_ja' => 'Japanese Description',
            'status' => 'Status',
            'active' => 'Active'
        ],
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'text' => [
            'upload_text' => 'Drop file here or click to upload',
            'date_validate' => 'End date must be after begin date'
        ],
    ],
    'abouts_us' => [
        'search' => [
            'status' => 'Status',
        ],
        'status' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'createButton' => 'Add About Us',
        'columns' => [
            'name_en' => 'English Name',
            'name_vi' => 'Vietnamese Name',
            'name_ja' => 'Japanese Name',
            'active' => 'Status',
            'action' => 'Action',
            'description_en' => 'English Description',
            'description_vi' => 'Vietnamese Description',
            'description_ja' => 'Japanese Description',
            'short_description_en' => 'Short English Description',
            'short_description_vi' => 'Short Vietnamese Description',
            'short_description_ja' => 'Short Japanese Description',
            'image' => 'Image',
        ],
        'breadcrumbs' => [
            'title' => 'About us',
            'abouts_us_index' => 'About us list',
            'abouts_us_create' => 'Add About Us',
            'abouts_us_update' => 'Edit About Us'
        ],
        'flash_message' => [
            'update' => 'About Us has been updated!',
            'new' => 'About Us has been created!',
            'destroy' => 'About Us has been deleted!',
        ],
        'not_found' => 'Don\'t have any about us!',
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'text' => [
            'upload_text' => 'Drop file here or click to upload',
        ],
    ],
    'image_list' => [
        'createButton' => 'Add Image',
        'columns' => [
            'action' => 'Action',
            'image' => 'Image',
        ],
        'breadcrumbs' => [
            'title' => 'Image List',
            'image_list_index' => 'Image List',
            'image_list_create' => 'Add Image',
            'image_list_update' => 'Edit Image'
        ],
        'flash_message' => [
            'update' => 'Image has been updated!',
            'new' => 'Image has been created!',
            'destroy' => 'Image has been deleted!',
            'save_img' => 'Your image has been saved!',
            'upload_img' => 'Your image has been upload!',
            'update_img' => 'Your image has been updated!',
            'save_thumb_img' => 'Your thumb image has been saved!',
            'upload_thumb_img' => 'Your thumb image has been upload!',
            'update_thumb_img' => 'Your thumb image has been updated!'
        ],
        'not_found' => 'Don\'t have any images!',
        'buttons' => [
            'create' => 'Create',
            'update' => 'Update',
            'cancel' => 'Cancel'
        ],
        'text' => [
            'upload_text' => 'Drop file here or click to upload',
        ],
    ],
    'orders' => [
        'search' => [
            'date' => 'Date',
            'place_holder_text' => 'Search by email,phone...',
            'date_place_holder_text' => 'Select date'
        ],
        'status' => [
            'done' =>'Done',
            'pending' => 'Pending'
        ],
        'columns' => [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'total' => 'Total Amount',
            'note' => 'Note',
            'created_date' => 'Created Date',
            'action' => 'Action',
            'datetime_reservation' => 'Reservation Date',
            'address' => 'Address',
            'pax' => 'Pax',
            'status' => 'STATUS',
            'data' => 'DATA',
            'invoice_info' => 'INVOICE INFO',
            'notes' => 'NOTE',
            'item' => 'ITEM',
            'unit_price' => 'UNIT PRICE',
            'quantity' => 'QUANTITY',
            'total_amount_item' => 'TOTAL',
            'total_amount_invoice' =>'TOTAL AMOUNT',
            'gender' => 'Gender',
            'delivery_address' => 'Delivery Address',
            'district' => 'District',
            'datetime_delivery' => 'Datetime delivery',
            'payment_method' => 'Payment method'
        ],
        'breadcrumbs' => [
            'title_booking' => 'Booking',
            'title_order' => 'Orders',
            'booking_index' => 'Booking list',
            'order_index' => 'Orders list',
            'order_update' => 'Edit Order',
            'booking_update' => 'Edit Booking',
            'booking_view' => 'View Booking Detail',
            'order_view' => 'View Order Detail',
        ],
        'flash_message' => [
            'update_booking' => 'Booking has been updated!',
            'update_order' => 'Order has been updated!',
        ],
        'not_found_booking' => 'Don\'t have any booking!',
        'not_found_order' => 'Don\'t have any order!',
    ],
    'media_modal' => [
        'title' => 'Image Management',
        'button' => [
            'upload' => 'Upload',
            'save' => 'Save',
            'close' => 'Close'
        ],
        'tab' => [
            'library' => 'Library',
            'upload' => 'Upload'
        ],
        'text' => [
            'upload_text' => 'Upload image',
            'upload_img' => 'Upload your image',
            'choose_img' => 'Choose your image',
            'img_name' => 'Image Name',
            'img_size' => 'Image Size',
            'upload_thumb_img' => 'Upload thumb image',
            'choose_thumb_img' => 'Choose your thumb image',
            'thumb_img_name' => 'Thumb Image Name',
            'thumb_img_size' => 'Thumb Image Size',
            'img_before' => 'Image Before',
            'img_after' => 'Image After',
        ]
    ]
];
