<?php

return [
    'confirm' => [
        'delete' => [
            'text' => 'Bạn có chắc chắn muốn xóa dữ liệu?',
            'confirm_button' => 'Có',
            'cancel_button' => 'Hủy Bỏ'
        ]
    ],
    'buttons' => [
        'create' => 'Tạo mới',
        'update' => 'Cập nhật',
        'cancel' => 'Huỷ',
        'upload' => 'Chọn Ảnh',
        'save_change' => 'Lưu Thay Đổi',
        'back' => 'Quay lại',
    ],
    'tooltip_title' => [
        'edit' => 'Chỉnh Sửa ',
        'delete' => 'Xóa',
        'duplicate' => 'Sao chép',
        'change_sequence' => 'Kéo thả để thay đổi thứ tự'
    ],
    'layouts' => [
        'header' => [
            'logout' => 'Đăng Xuất',
            'my_profile' => 'Hồ sơ của tôi'
        ],
        'aside_left' => [
            'group' => [
                'reservations' => 'Đặt Chỗ',
                'contents' => 'Nội Dung',
                'contacts_users' => 'Liên Hệ & Người Dùng',
                'settings' => 'Cấu Hình',
                'order' => 'Đơn Hàng'
            ],
            'section' => [
                'events' => 'Sự Kiện',
                'galleries' => 'Thư Viện',
                'sequence' => 'Đổi Thứ Tự',
                'news_events' => 'Tin Tức Sự Kiện'
            ],
            'menu' => [
                'reservations' => 'Đặt Chỗ',
                'items' => 'Món Ăn',
                'categories' => 'Loại gói trị liệu',
                'sub_categories' => 'Sub Categories',
                'famous_people' => 'Người nổi tiếng',
                'events' => 'Sự kiện',
                'event_types' => 'Loại Sự kiện',
                'news' => 'Tin tức',
                'news_types' => 'Loại tin tức',
                'services' => 'Gói Trị Liệu',
                'gallery_types' => 'Loại Thư Viện',
                'galleries' => 'Thư Viện',
                'contacts' => 'Liên Hệ',
                'users' => 'Người Dùng',
                'currencies' => 'Tiền Tệ',
                'payment_method' => 'Phương thức thanh toán',
                'menus' => 'Menus',
                'sub_menus' => 'Menus Con',
                'promotions' => 'Ưu đãi',
                'configurations' => 'Cài Đặt',
                'menus_sequence' => 'Menu',
                'sub_menus_sequence' => 'Menu Con',
                'categories_sequence' => 'Loại gói trị liệu',
                'sub_categories_sequence' => 'Sub Categories',
                'promotions_sequence' => 'Ưu đãi',
                'items_sequence' => 'Món Ăn',
                'roles' => 'Phân Quyền',
                'email_template' => 'Nội dung email',
                'weekly_menus' => 'Hình thực đơn theo tuần',
                'abouts_us' => 'Giới Thiệu',
                'image_list' => 'Lưu trữ ảnh',
                'booking' => 'Đặt bàn',
                'order' => 'Đặt món',
                'faqs' => 'Hỏi & Trả lời',
                'service_feedbacks' => 'Phản Hồi khách hàng',
                'category_meta'=> 'Danh mục'
            ],
        ],
        'breadcrumbs' => [
            'change_sequence' => 'Thay đổi thứ tự'
        ]
    ],
    'users' => [
        'search' => [
            'status' => 'Trạng thái',
            'role' => 'Quyền',
            'place_holder_text' => 'Tìm theo tên và email...'
        ],
        'title' => [
            "details" => 'Thông tin cá nhân',
            "role" => 'Quyền hạn',
            'update_profile' => 'Cập nhật hồ sơ',
            'message' => 'Tin nhắn',
            'settings' => 'Cài đặt',
            'change_password' => 'Thay đổi mật khẩu',
        ],
        'columns' => [
            'full_name' => 'Họ Tên',
            'email' => 'Email',
            'phone' => 'Số Điện Thoại',
            'dob' => 'Ngày Sinh',
            'address' => 'Địa Chỉ',
            'role' => 'Quyền',
            'locked' => 'Khóa',
            'status' => 'Trạng Thái',
            'action' => 'Tùy Chọn',
            'current_password' => 'Mật khẩu hiện tại',
            'new_password' => 'Mật khẩu mới',
            'confirm_new_password' => 'Nhập lại mật khẩu mới',
        ],
        'breadcrumbs' => [
            'title' => 'Người dùng',
            'user_index' => 'Danh sách người dùng',
            'my_profile' => 'Hồ sơ của tôi'
        ],
        'statuses' => [
            'all' => 'Tất Cả',
            'locked' => 'Khóa',
            'active' => 'Hoạt Động'
        ],
        'roles' => [
            'all' => 'Tất Cả',
            'select_role' => 'Chọn Quyền',
            'user' => 'Người Dùng',
            'admin' => 'Quản Trị'
        ],
        'not_found' => 'Không tìm thấy người dùng!'
    ],
    'items' => [
        'search' => [
            'category' => 'Loại món ăn',
            'sub_category' => 'Loại món ăn phụ',
            'place_holder_text' => 'Tìm theo tên món ăn...'
        ],
        'text' => [
            'all' => 'Tất cả',
            'category' => 'Chọn loại món ăn',
            'sub_category' => 'Chọn loại món ăn phụ',
            'upload_text' => 'Kéo thả hình ảnh hoặc bấm để đăng ảnh',
            'sub_item_name' => 'Tên món ăn'
        ],
        'createButton' => 'Tạo Mới Món Ăn',
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt ',
            'name_ja' => 'Tên Tiếng Nhật',
            'price' => 'Giá Cả',
            'discount_price' => 'Giảm Giá',
            'item_type' => 'Loại Thực Đơn',
            'image' => 'Hình Ảnh',
            'description_en' => 'Mô Tả Tiếng Anh',
            'description_vi' => 'Mô Tả Tiếng Việt',
            'description_ja' => 'Mô Tả Tiếng Nhật',
            'active' => 'Tình Trạng',
            'sub_category' => 'Sub Categories',
            'sub_sub_category' => 'Sub Sub Categories',
            'category' => 'Categories',
            'action' => 'Tùy Chọn',
            'sequence' => 'Trình Tự',
            'normal_item' => 'Gọi Món',
            'set_item' => 'Tiệc',
            'weekly_item' => 'Theo Tuần',
            'begin_date' => 'Ngày Bắt Đầu',
            'end_date' => 'Ngày kết thúc',
            'thumb_image' => 'Hình thumb'
        ],
        'breadcrumbs' => [
            'title' => 'Món ăn',
            'item_index' => 'Danh sách món ăn',
            'item_create' => 'Tạo mới món ăn',
            'item_update' => 'Chỉnh sửa món ăn',
        ],
        'not_found' => 'Không tìm thấy món ăn!',
        'flash_message' => [
            'new' => 'Đã thêm món ăn!',
            'update' => 'Đã cập nhật món ăn!',
            'destroy' => 'Đã xóa món ăn!',
        ],
    ],
    'contacts' => [
        'search' => [
            'date' => 'Ngày',
            'place_holder_text' => 'Tìm theo email...',
            'date_place_holder_text' => 'Chọn ngày'
        ],
        'columns' => [
            'name' => 'Họ Tên',
            'phone' => 'Số Điện Thoại',
            'email' => 'Email',
            'content' => 'Nội Dung',
            'note' => 'Ghi Chú',
            'created_date' => 'Ngày Tạo',
            'action' => 'Tùy Chọn'
        ],
        'breadcrumbs' => [
            'title' => 'Liên hệ',
            'contact_index' => 'Danh sách liên hệ',
            'contact_update' => 'Chỉnh sửa liên hệ',
            'contact_detail' => 'Chi tiết liên hệ',
        ],
        'flash_message' => [
            'update' => 'Đã cập nhật liên hệ!',
        ],
        'not_found' => 'Không tìm thấy liên hệ!'
    ],
    'gallery_types' => [
        'search' => [
            'status' => 'Tình trạng'
        ],
        'status' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Ngưng hoạt động',
        ],
        'createButton' => 'Tạo Mới Loại Thư Viện',
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'active' => 'Tình Trạng',
            'action' => 'Tùy Chọn'
        ],
        'breadcrumbs' => [
            'title' => 'Loại thư viện',
            'gallery_type_index' => 'Danh sách loại thư viện',
            'gallery_type_create' => 'Tạo mới loại thư viện',
            'gallery_type_update' => 'Chỉnh sửa loại thư viện'
        ],
        'flash_message' => [
            'update' => 'Đã cập nhật loại thư viện!',
            'new' => 'Đã thêm loại thư việnh!',
            'destroy' => 'Đã xóa loại thư viện!',
            'can\'t_destroy' => 'Không thể xóa vì loại thư viện đang được sử dụng!'
        ],
        'not_found' => 'Không tìm thấy loại thư viện!'
    ],
    'galleries' => [
        'search' => [
            'gallery_type' => 'Loại thư viện'
        ],
        'createButton' => 'Tạo Mới Thư Viện',
        'text' => [
            'all' => 'Tất cả',
            'upload_text' => 'Kéo thả hình ảnh hoặc bấm để đăng ảnh'
        ],
        'status' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Ngưng hoạt động',
        ],
        'columns' => [
            'image' => 'Hình Ảnh',
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'gallery_type' => 'Loại Thư Viện',
            'active' => 'Tình Trạng',
            'action' => 'Tùy Chọn'
        ],
        'breadcrumbs' => [
            'title' => 'Thư viện',
            'gallery_index' => 'Danh sách thư viện',
            'gallery_create' => 'Tạo mới thư viện',
            'gallery_update' => 'Chỉnh sửa thư viện',
        ],
        'flash_message' => [
            'update' => 'Đã cập nhật thư viện!',
            'new' => 'Đã thêm thư viện!',
            'destroy' => 'Đã xóa thư viện!',
            'not_allowed' => 'Bạn chỉ được upload 14 ảnh!'
        ],
        'not_found' => 'Không tìm thấy thư viện!'
    ],
    'menus' => [
        'search' => [
            'status' => 'Trạng thái',
        ],
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'url' => 'URL',
            'sequence' => 'Trình Tự',
            'status' => 'Trạng Thái',
            'action' => 'Thao Tác',
        ],
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'url' => 'URL',
            'status' => 'Trạng thái',
            'active' => 'Hoạt động'
        ],
        'breadcrumbs' => [
            'title' => 'Menus',
            'menu_index' => 'Danh sách menu',
            'new_menu' => 'Menu mới',
            'data_of_menu' => 'Dữ liệu menu',
            'add_menu' => 'Thêm menu',
            'edit_menu' => 'Chỉnh sửa menu',
            'delete_menu' => 'Xóa menu'
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'upgrate' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm menu!',
            'update' => 'Đã cập nhật menu!',
            'destroy' => 'Đã xóa menu!',
            'can\'t_destroy' => 'Không thể xóa vì menu đang được sử dụng'
        ],
        'not_found' => 'Không tìm thấy menu!'
    ],
    'sub_menus' => [
        'search' => [
            'status' => 'Trạng thái',
            'menu' => 'Loại menu',
            'choose' => 'Chọn loại menu',
        ],
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'url' => 'URL',
            'sequence' => 'Trình Tự',
            'menu_types' => 'Loại Menu',
            'status' => 'Trạng Thái',
            'action' => 'Thao Tác'
        ],
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'url' => 'URL',
            'menu_types' => 'Loại menu',
            'status' => 'Trạng thái',
            'active' => 'Hoạt động'
        ],
        'breadcrumbs' => [
            'title' => 'Menu con',
            'sub_menu_index' => 'Danh sách menu con',
            'new_sub_menu' => 'Menu con mới',
            'data_of_sub_menu' => 'Dữ liệu menu con',
            'add_sub_menu' => 'Thêm menu con',
            'edit_sub_menu' => 'Chỉnh sửa menu con',
            'delete_sub_menu' => 'Xóa menu con'
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'upgrate' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm menu con!',
            'update' => 'Đã cập nhật menu con!',
            'destroy' => 'Đã xóa menu con!',
            'can\'t_destroy' => 'Không thể xóa vì menu con đang được sử dụng'
        ],
        'not_found' => 'Không tìm thấy menu con!'
    ],
    'event_types' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'status' => 'Trạng Thái',
            'action' => 'Thao Tác'
        ],
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'slug' => 'Slug',
            'status' => 'Trạng thái',
            'active' => 'Hoạt động'
        ],
        'breadcrumbs' => [
            'title' => 'Loại sự kiện',
            'event_type_index' => 'Danh sách loại sự kiện',
            'new_event_type' => 'Loại sự kiện mới',
            'data_of_event_type' => 'Dữ liệu loại sự kiện',
            'add_event_type' => 'Thêm loại sự kiện',
            'edit_event_type' => 'Chỉnh sửa loại sự kiện',
            'delete_event_type' => 'Xóa loại sự kiện'
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'upgrate' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm loại sự kiện!',
            'update' => 'Đã cập nhật loại sự kiện!',
            'destroy' => 'Đã xóa loại sự kiện!',
            'can\'t_destroy' => 'Không thể xóa vì loại sự kiện đang được sử dụng'
        ],
        'not_found' => 'Không tìm thấy loại sự kiện!',
    ],
    'events' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'text' => [
            'all' => 'Tất cả',
            'upload_text' => 'Kéo thả hình ảnh hoặc bấm để đăng ảnh'
        ],
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'status' => 'Trạng Thái',
            'action' => 'Thao Tác',
            'image' => 'Hình Ảnh',
        ],
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'status' => 'Trạng thái',
            'description_en' => 'Mô tả Tiếng Anh',
            'description_vi' => 'Mô tả Tiếng Việt',
            'short_description_en' => 'Mô tả ngắn Tiếng Anh',
            'short_description_vi' => 'Mô tả ngắn Tiếng Việt',
            'image' => 'Hình ảnh',
            'video' => 'Đường dẫn Video',
            'active' => 'Hoạt động',
            'event_type' => 'Loại sự kiện',
            'location' => 'Địa điểm',
            'timeline' => 'Thời gian diễn ra',
            'date_begin' => 'Ngày bắt đầu'
        ],
        'breadcrumbs' => [
            'title' => 'Sự kiện',
            'all' => 'Tất cả',
            'event_index' => 'Danh sách sự kiện',
            'new_event' => 'Sự kiện mới',
            'data_of_event' => 'Dữ liệu sự kiện',
            'add_event' => 'Thêm sự kiện',
            'edit_event' => 'Chỉnh sửa sự kiện',
            'delete_event' => 'Xóa sự kiện'
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'update' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm sự kiện!',
            'update' => 'Đã cập nhật sự kiện!',
            'destroy' => 'Đã xóa sự kiện!',
            'can\'t_destroy' => 'Không thể xóa vì sự kiện đang được sử dụng'
        ],
        'not_found' => 'Không tìm thấy sự kiện!',
    ],
    'news_types' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'status' => 'Trạng Thái',
            'action' => 'Thao Tác'
        ],
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'slug' => 'Slug',
            'status' => 'Trạng thái',
            'active' => 'Hoạt động'
        ],
        'breadcrumbs' => [
            'title' => 'Loại tin tức',
            'news_type_index' => 'Danh sách loại tin tức',
            'new_news_type' => 'Loại tin tức mới',
            'data_of_news_type' => 'Dữ liệu loại tin tức',
            'add_news_type' => 'Thêm loại tin tức',
            'edit_news_type' => 'Chỉnh sửa loại tin tức',
            'delete_news_type' => 'Xóa loại tin tức'
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'upgrate' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm loại tin tức!',
            'update' => 'Đã cập nhật loại tin tức!',
            'destroy' => 'Đã xóa loại tin tức!',
            'can\'t_destroy' => 'Không thể xóa vì loại tin tức đang được sử dụng'
        ],
        'not_found' => 'Không tìm thấy loại tin tức!',
    ],
    'news' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'text' => [
            'all' => 'Tất cả',
            'upload_text' => 'Kéo thả hình ảnh hoặc bấm để đăng ảnh'
        ],
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'status' => 'Trạng Thái',
            'action' => 'Thao Tác',
            'image' => 'Hình Ảnh',
        ],
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'status' => 'Trạng thái',
            'description_en' => 'Mô tả Tiếng Anh',
            'description_vi' => 'Mô tả Tiếng Việt',
            'short_description_en' => 'Mô tả ngắn Tiếng Anh',
            'short_description_vi' => 'Mô tả ngắn Tiếng Việt',
            'image' => 'Hình ảnh',
            'video' => 'Đường dẫn Video',
            'active' => 'Hoạt động',
            'news_type' => 'Loại tin tức',
            'location' => 'Địa điểm',
            'timeline' => 'Thời gian diễn ra',
            'date_begin' => 'Ngày bắt đầu'
        ],
        'breadcrumbs' => [
            'title' => 'Tin tức',
            'all' => 'Tất cả',
            'news_index' => 'Danh sách tin tức',
            'new_news' => 'Tin tức mới',
            'data_of_news' => 'Dữ liệu tin tức',
            'add_news' => 'Thêm tin tức',
            'edit_news' => 'Chỉnh sửa tin tức',
            'delete_news' => 'Xóa tin tức'
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'update' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm tin tức!',
            'update' => 'Đã cập nhật tin tức!',
            'destroy' => 'Đã xóa tin tức!',
            'can\'t_destroy' => 'Không thể xóa vì tin tức đang được sử dụng'
        ],
        'not_found' => 'Không tìm thấy tin tức!',
    ],
    'services' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'text' => [
            'all' => 'Tất cả',
            'upload_text' => 'Kéo thả hình ảnh hoặc bấm để đăng ảnh'
        ],
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'status' => 'Trạng Thái',
            'action' => 'Thao Tác',
            'image' => 'Hình Ảnh',
        ],
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'status' => 'Trạng thái',
            'description_en' => 'Mô tả Tiếng Anh',
            'description_vi' => 'Mô tả Tiếng Việt',
            'short_description_en' => 'Mô tả ngắn Tiếng Anh',
            'short_description_vi' => 'Mô tả ngắn Tiếng Việt',
            'image' => 'Hình ảnh',
            'video' => 'Đường dẫn Video',
            'active' => 'Hoạt động',
            'chosen_package' => 'Chọn loại gói trị liệu',
            'chosen_faq' => 'Chọn câu hỏi & trả lời',
            'chosen_service_feebacks' => 'Chọn hiển thị feedback khách hàng',
            'chosen_promotion' => 'Chọn hiển thị ưu đãi',
            'image_before' => 'Hình trước khi sử dụng',
            'image_after' => 'Hình sau khi sử dụng'
        ],
        'breadcrumbs' => [
            'title' => 'Gói Trị Liệu',
            'all' => 'Tất cả',
            'service_index' => 'Danh sách Gói Trị Liệu',
            'new_service' => 'Gói Trị Liệu mới',
            'data_of_service' => 'Dữ liệu Gói Trị Liệu',
            'add_service' => 'Thêm Gói Trị Liệu',
            'edit_service' => 'Chỉnh sửa Gói Trị Liệu',
            'delete_service' => 'Xóa Gói Trị Liệu'
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'update' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm Gói Trị Liệu!',
            'update' => 'Đã cập nhật Gói Trị Liệu!',
            'destroy' => 'Đã xóa Gói Trị Liệu!',
            'can\'t_destroy' => 'Không thể xóa vì Gói Trị Liệu đang được sử dụng'
        ],
        'not_found' => 'Không tìm thấy Gói Trị Liệu!',
    ],
    'categories' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'status' => 'Trạng Thái',
            'action' => 'Thao Tác'
        ],
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'status' => 'Trạng thái',
            'active' => 'Hoạt động',
            'description_en' => 'Mô tả Tiếng Anh',
            'description_vi' => 'Mô tả Tiếng Việt',
            'description_ja' => 'Mô tả Tiếng Nhật'
        ],
        'breadcrumbs' => [
            'title' => 'Danh mục',
            'category_index' => 'Danh sách Loại gói trị liệu',
            'new_category' => 'Loại gói trị liệu mới',
            'data_of_category' => 'Dữ liệu loại gói trị liệu',
            'add_category' => 'Thêm loại gói trị liệu',
            'edit_category' => 'Chỉnh sửa loại gói trị liệu',
            'delete_category' => 'Xóa loiaj gói trị liệu'
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'upgrate' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm loại gói trị liệu!',
            'update' => 'Đã cập nhật loại gói trị liệu!',
            'destroy' => 'Đã xóa loại gói trị liệu!',
            'can\'t_destroy' => 'Không thể xóa vì loại gói trị liệu đang được sử dụng'
        ],
        'not_found' => 'Không tìm thấy danh mục!',
    ],
    'category_meta' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'action' => 'Thao Tác'
        ],
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'active' => 'Hoạt động',
        ],
        'breadcrumbs' => [
            'title' => 'Danh mục',
            'category_meta_index' => 'Danh sách danh mục trị liệu',
            'new_category_meta' => 'danh mục trị liệu mới',
            'data_of_category_meta' => 'Dữ liệu danh mục trị liệu',
            'add_category_meta' => 'Thêm danh mục trị liệu',
            'edit_category_meta' => 'Chỉnh sửa danh mục trị liệu',
            'delete_category_meta' => 'Xóa danh mục trị liệu'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'upgrate' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm danh mục trị liệu!',
            'update' => 'Đã cập nhật danh mục trị liệu!',
            'destroy' => 'Đã xóa danh mục trị liệu!',
            'can\'t_destroy' => 'Không thể xóa vì danh mục trị liệu đang được sử dụng'
        ],
        'not_found' => 'Không tìm thấy danh mục!',
    ],
    'sub_categories' => [
        'search' => [
            'status' => 'Trạng thái',
            'category' => 'Danh mục',
            'place_holder_text' => 'Tìm theo tên...',
            'choose' => 'Chọn category'
        ],
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'categories' => 'Categories',
            'status' => 'Trạng Thái',
            'action' => 'Thao Tác',
            'sequence' => 'Trình Tự',
        ],
        'forms' => [
            'categories' => 'Categories',
            'sub_sub_categories' => 'Sub Categories',
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'status' => 'Trạng thái',
            'active' => 'Hoạt động',
            'description_en' => 'Mô tả Tiếng Anh',
            'description_vi' => 'Mô tả Tiếng Việt',
            'description_ja' => 'Mô tả Tiếng Nhật'
        ],
        'breadcrumbs' => [
            'title' => 'Sub categories',
            'category' => 'Category',
            'all' => 'Tất Cả',
            'sub_category_index' => 'Danh sách sub categories',
            'new_sub_category' => 'Sub category mới',
            'data_of_sub_category' => 'Dữ liệu sub category',
            'add_sub_category' => 'Thêm sub category',
            'edit_sub_category' => 'Chỉnh sửa sub category',
            'delete_sub_category' => 'Xóa sub category'
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'upgrate' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm sub category!',
            'update' => 'Đã cập nhật sub category!',
            'destroy' => 'Đã xóa sub category!',
            'can\'t_destroy' => 'Không thể xóa vì sub category đang được sử dụng'
        ],
        'not_found' => 'Không tìm thấy sub category!',
    ],

    'famous_people' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...',
        ],
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'description_vi' => 'Mô Tả Tiếng Việt',
            'description_en' => 'Mô Tả Tiếng Anh',
            'image' => 'Hình ảnh',
            'status' => 'Trạng Thái',
            'action' => 'Thao Tác',
        ],
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'status' => 'Trạng thái',
            'active' => 'Hoạt động',
            'link_video' => 'Đường dẫn Video',
            'description_en' => 'Mô tả Tiếng Anh',
            'description_vi' => 'Mô tả Tiếng Việt',
        ],
        'breadcrumbs' => [
            'title' => 'Famous People',
            'all' => 'Tất Cả',
            'famous_people_index' => 'Danh sách famous people',
            'new_famous_people' => 'Famous people mới',
            'data_of_famous_people' => 'Dữ liệu famous people',
            'add_famous_people' => 'Thêm famous people',
            'edit_famous_people' => 'Chỉnh sửa famous people',
            'delete_famous_people' => 'Xóa famous people'
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'update' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm famous people!',
            'update' => 'Đã cập nhật famous people!',
            'destroy' => 'Đã xóa famous people!',
            'can\'t_destroy' => 'Không thể xóa vì famous people đang được sử dụng'
        ],
        'not_found' => 'Không tìm thấy famous people!',
    ],
    'faq' => [
        'search' => [
            'status' => 'Status',
            'place_holder_text' => 'Tìm kiếm theo...'
        ],
        'columns' => [
            'question_en' => 'Câu hỏi tiếng anh',
            'question_vi' => 'Câu hỏi tiếng việt',
            'anwser_en' => 'Câu trả lời tiếng anh',
            'anwser_vi' => 'Câu trả lời tiếng việt',
            'image' => 'Image',
            'status' => 'Status',
            'action' => 'Action'
        ],
        'forms' => [
            'question_en' => 'Câu hỏi tiếng anh',
            'question_vi' => 'Câu hỏi tiếng việt',
            'anwser_en' => 'Câu trả lời tiếng anh',
            'anwser_vi' => 'Câu trả lời tiếng việt',
            'status' => 'Status',
            'active' => 'Active',
        ],
        'breadcrumbs' => [
            'title' => 'FAQ',
            'all' => 'Tất Cả',
            'faq_index' => 'FAQ list',
            'new_faq' => 'Thêm mới FAQ',
            'data_of_faq' => 'Dư liệu FAQ',
            'add_faq' => 'Thêm mới FAQ',
            'edit_faq' => 'Sửa FAQ',
            'delete_faq' => 'Xóa FAQ'
        ],
        'statuses' => [
            'all' => 'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'buttons' => [
            'create' => 'Tạo',
            'update' => 'Cập nhật',
            'cancel' => 'Hủy bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm faq!',
            'update' => 'Đã cập nhật faq!',
            'destroy' => 'Đã xóa faq!',
            'can\'t_destroy' => 'Không thể xóa vì faq đang được sử dụng'
        ],
        'not_found' => 'Không tìm thấy faq!',
    ],
    'promotions' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'text' => [
            'all' => 'Tất cả',
            'upload_text' => 'Kéo thả hình ảnh hoặc bấm để đăng ảnh'
        ],
        'columns' => [
            'begin_date' => 'Ngày Bắt Đầu',
            'end_date' => 'Ngày Kết Thúc',
            'name_vi' => 'Tên Tiếng Việt',
            'status' => 'Trạng Thái',
            'action' => 'Thao Tác',
            'image' => 'Hình Ảnh',
            'sequence' => 'Trình Tự',
        ],
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'status' => 'Trạng thái',
            'description_en' => 'Mô tả Tiếng Anh',
            'description_vi' => 'Mô tả Tiếng Việt',
            'short_description_en' => 'Mô tả ngắn Tiếng Anh',
            'short_description_vi' => 'Mô tả ngắn Tiếng Việt',
            'begin_date' => 'Ngày bắt đầu',
            'end_date' => 'Ngày kết thúc',
            'image' => 'Hình ảnh',
            'active' => 'Hoạt động',
            'video' => 'Đường dẫn Video',
            'enable_detail_page' => 'Trang chi tiết',
            'page_url' => 'Url trang chi tiết',
            'showinhomepage' => "Hiển thị trên trang chủ"
        ],
        'breadcrumbs' => [
            'title' => 'Khuyến mãi',
            'promotion_index' => 'Danh sách khuyến mãi',
            'new_promotion' => 'Khuyến mãi mới',
            'data_of_promotion' => 'Dữ liệu khuyến mãi',
            'add_promotion' => 'Thêm khuyến mãi',
            'edit_promotion' => 'Chỉnh sửa khuyến mãi',
            'delete_promotion' => 'Xóa khuyến mãi'
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'update' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm khuyến mãi!',
            'update' => 'Đã cập nhật khuyến mãi!',
            'destroy' => 'Đã xóa khuyến mãi!',
            'can\'t_destroy' => 'Không thể xóa vì khuyến mãi đang được sử dụng',
            'change_sequence' => 'Thứ tự đã được thay đổi',
            'change_sequence_error' => 'Có lỗi, vui lòng thử lại sau!'
        ],
        'not_found' => 'Không tìm thấy khuyến mãi!',
    ],
    'service_feedback' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'text' => [
            'all' => 'Tất cả',
            'upload_text' => 'Kéo thả hình ảnh hoặc bấm để đăng ảnh'
        ],
        'columns' => [
            'name_vi' => 'Tên Tiếng Việt',
            'status' => 'Trạng Thái',
            'action' => 'Thao Tác',
            'image' => 'Hình Ảnh',
            'description_vi' => 'Mô tả tiếng việt',
        ],
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'status' => 'Trạng thái',
            'description_en' => 'Mô tả Tiếng Anh',
            'description_vi' => 'Mô tả Tiếng Việt',
            'image' => 'Hình ảnh',
            'active' => 'Hoạt động',
            'video' => 'Đường dẫn Video',
        ],
        'breadcrumbs' => [
            'title' => 'Phản hồi khách hàng',
            'service_feedback_index' => 'Danh sách phản hồi khách hàng',
            'new_service_feedback' => 'Phản hồi khách hàng mới',
            'data_of_service_feedback' => 'Dữ liệu phản hồi khách hàng',
            'add_service_feedback' => 'Thêm phản hồi khách hàng',
            'edit_service_feedback' => 'Chỉnh sửa phản hồi khách hàng',
            'delete_service_feedback' => 'Xóa phản hồi khách hàng'
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'update' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm phản hồi khách hàng!',
            'update' => 'Đã cập nhật phản hồi khách hàng!',
            'destroy' => 'Đã xóa phản hồi khách hàng!',
            'can\'t_destroy' => 'Không thể xóa vì phản hồi khách hàng đang được sử dụng',
            'change_sequence' => 'Thứ tự đã được thay đổi',
            'change_sequence_error' => 'Có lỗi, vui lòng thử lại sau!'
        ],
        'not_found' => 'Không tìm thấy phản hồi khách hàng!',
    ],
    'currencies' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo mã...'
        ],
        'columns' => [
            'code' => 'Mã',
            'symbol' => 'Ký Hiệu',
            'exchange_rate' => 'Tỷ Giá',
            'status' => 'Trạng Thái',
            'action' => 'Thao Tác',
        ],
        'forms' => [
            'code' => 'Mã',
            'symbol' => 'Ký hiệu',
            'exchange_rate' => 'Tỷ giá',
            'status' => 'Trạng thái',
            'active' => 'Hoạt động',
        ],
        'breadcrumbs' => [
            'title' => 'Tỷ giá tiền tệ',
            'currency_index' => 'Danh sách tỷ giá tiền tệ',
            'new_currency' => 'Tỷ giá tiền tệ mới',
            'data_of_currency' => 'Dữ liệu tỷ giá tiền tệ',
            'add_currency' => 'Thêm tỷ giá tiền tệ',
            'edit_currency' => 'Chỉnh sửa tỷ giá tiền tệ',
            'delete_currency' => 'Xóa tỷ giá tiền tệ'
        ],
        'statuses' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'upgrate' => 'Cập Nhật',
            'cancel' => 'Hủy Bỏ'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm tỷ giá tiền tệ!',
            'update' => 'Đã cập nhật tỷ giá tiền tệ!',
            'destroy' => 'Đã xóa tỷ giá tiền tệ!',
            'can\'t_destroy' => 'Không thể xóa vì tỷ giá tiền tệ đang được sử dụng'
        ],
        'not_found' => 'Không tìm thấy tỷ giá tiền tệ!',
    ],
    'configurations' => [
        'text' => [
            'all' => 'Tất cả',
            'upload_text' => 'Kéo thả hình ảnh hoặc bấm để đăng ảnh'
        ],
        'forms' => [
            'social_network' => 'Mạng xã hội',
            'cogfig_key' => 'Config key',
            'config_logo' => 'Logo config',
            'url' => 'URL',
            'image' => 'Hình ành',
            'status' => 'Trạng thái',
            'is_publish' => 'Công khai',
            'promotion_display' => 'Hiển thị khuyến mãi',
            'localization' => 'Localization',
            'on' => 'on',
            'facebook_message_url' => 'Facebook message url',
            'email_admin_received' => 'Email admin nhận',
            'contact_name_en' => 'Tên liên lạc(en)',
            'contact_name_vi' => 'Tên liên lạc(vi)',
            'contact_name_ja' => 'Tên liên lạc(ja)',
            'contact_address_en' => 'Địa chỉ liên lạc(en)',
            'contact_address_vi' => 'Địa chỉ liên lạc(vi)',
            'contact_address_ja' => 'Địa chỉ liên lạc(ja)',
            'contact_email' => 'Email liên lạc',
            'contact_phone' => 'Điện thoại liên lạc',
            'sms_message' => 'Nội dung tin nhắn',
        ],
        'breadcrumbs' => [
            'title' => 'Cấu hình',
            'edit_configuration' => 'Chỉnh sửa cấu hình',
        ],
        'buttons' => [
            'upgrate' => 'Cập Nhật',
            'reset' => 'Nhập lại'
        ],
        'flash_messages' => [
            'update' => 'Đã cập nhật configuration!',
        ],
    ],
    'roles' => [
        'title' => [
            'all' => 'Tất Cả Quyền',
            'members' => 'Thành Viên',
            'users' => 'Người Dùng',
            'galleries' => 'Thư Viện',
            'gallery_types' => 'Loại Thư Viện',
            'items' => 'Món Ăn',
            'events' => 'Sự Kiện',
            'event_types' => 'Loại Sự Kiên',
            'categories' => 'Danh Mục',
            'sub_categories' => 'Sub Categories',
            'menus' => 'Menu',
            'sub_menus' => 'Menu Con',
            'currencies' => 'Tiền Tệ',
            'contacts' => 'Liên Hệ',
            'roles' => 'Phân Quyền',
            'configurations' => 'Cài Đặt',
            'promotions' => 'Khuyến Mãi',
            'delete' => 'Xóa',
            'payment_methods' => 'Thanh toán',
            'email_templates' => 'Định dạng email',
            'weekly_menus' => 'Thực đơn theo tuần',
            'abouts_us' => 'Giới Thiệu',
            'images_list' => 'Hình ảnh'
        ],
        'checkbox_title' => [
            'users_view' => 'Xem Tất Cả Hồ Sơ Người Dùng',
            'users_manage' => 'Quản Lý Tất Cả Hồ Sơ Người Dùng',
            'galleries_view' => 'Xem Tất Cả Thư Viện',
            'galleries_manage' => 'Quản Lý Tất Cả Thư Viện',
            'gallery_types_view' => 'Xem Tất Cả Loại Thư Viện',
            'gallery_types_manage' => 'Quản Lý Tất Cả Loại Thư Viện',
            'items_view' => 'Xem Tất Cả Món Ăn',
            'items_manage' => 'Quản Lý Tất Cả Món Ăn',
            'events_view' => 'Xem Tất Cả Sự Kiện',
            'events_manage' => 'Quản Lý Tất Cả Sự Kiện',
            'event_types_view' => 'Xem Tất Cả Loại Sự Kiện',
            'event_types_manage' => 'Quản Lý Tất Cả Loại Sự Kiện',
            'categories_view' => 'Xem Tất Cả Categories',
            'categories_manage' => 'Quản Lý Tất Cả Categories',
            'sub_categories_view' => 'Xem Tất Cả Sub Categories',
            'sub_categories_manage' => 'Quản Lý Tất Cả Sub Categories',
            'menus_view' => 'Xem Tất Cả Menu',
            'menus_manage' => 'Quản Lý Tất Cả Menus',
            'sub_menus_view' => 'Xem Tất Cả Menus Con',
            'sub_menus_manage' => 'Quản Lý Tất Cả Menus Con',
            'currencies_view' => 'Xem Tất Cả Tiền Tệ',
            'currencies_manage' => 'Quản Lý Tất Cả Tiền Tệ',
            'contacts_view' => 'Xem Tất Cả Liên Hệ',
            'contacts_manage' => 'Quản Lý Tất Cả Liên Hệ',
            'roles_view' => 'Xem Tất Cả Phân Quyền',
            'roles_manage' => 'Quản Lý Tất Cả Phân Quyền',
            'configurations_view' => 'Xem Tất Cả Cài Đặt',
            'configurations_manage' => 'Quản Lý Tất Cả Cài Đặt',
            'promotions_view' => 'Xem Tất Cả Khuyến Mãi',
            'promotions_manage' => 'Quản Lý Tất Cả Khuyến Mãi',
            'payment_methods_view' => 'Xem Tất Cả Loại Thanh Toán',
            'payment_methods_manage' => 'Quản Lý Tất Cả Loại Thanh Toán',
            'email_templates_view' => 'Xem Tất Cả Định Dạng Email',
            'email_templates_manage' => 'Quản Lý Tất Cả Định Dạng Email',
            'weekly_menus_view' => 'Xem Tất Cả Thực Đơn Tuần',
            'weekly_menus_manage' => 'Quản Lý Tất Cả Thực Đơn Tuần',
            'abouts_us_view' => 'Giới thiệu',
            'abouts_us_manage' => 'Quản Lý Giới thiệu',
            'images_list_view' => 'Xem Tất Cả Hình Ảnh',
            'images_list_manage' => 'Quản Lý Tất Cả Hình Ảnh',
        ],
        'breadcrumbs' => [
            'title' => 'Phân quyền',
            'role_index' => 'Danh sách phân quyền',
            'role_create' => 'Tạo mới phân quyền',
            'role_update' => 'Chỉnh sửa phân quyền',
            'role_show' => 'Chi tiết phân quyền'
        ],
        'column' => [
            'role_name' => 'Tên Phân Quyền',
            'permission' => 'Phân quyền',
            'full_name' => 'Họ và Tên',
            'email' => 'Email',
            'last_login' => 'Lần Đăng Nhập Cuối',
            'action' => 'Tùy Chọn'
        ],
        'buttons' => [
            'form_create' => 'Tạo Mới',
            'index_create' => 'Tạo Phân Quyền Mới',
            'form_edit' => 'Cập Nhật',
            'index_edit' => 'Chỉnh Sửa Phân Quyền',
            'delete' => 'Xóa Phân Quyền',
            'cancel' => 'Hủy',
            'add_user' => 'Thêm Người Dùng'
        ],
        'modal' => [
            'title' => 'Thêm Mới Người Dùng',
            'close' => 'Đóng',
            'add' => 'Thêm',
            'select' => 'Chọn Người Dùng'
        ],
        'flash_messages' => [
            'new' => 'Đã thêm phân quyền!',
            'update' => 'Đã cập nhật phân quyền!',
            'delete' => 'Đã xóa phân quyền!',
            'can\'t_delete' => 'Không thể xóa vì phân quyền đang được sử dụng!',
            'add_user' => 'Đã thêm người dùng vào phân quyền!',
            'delete_user' => 'Đã xóa người dùng ra khỏi phân quyền!'
        ],
    ],
    'payment_methods' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'status' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động',
        ],
        'createButton' => 'Thêm phương thức thanh toán',
        'columns' => [
            'name_en' => 'Tên tiếng Anh',
            'name_vi' => 'Tên tiếng Việt',
            'name_ja' => 'Tên tiếng Nhật',
            'active' => 'Trạng thái',
            'action' => 'Tùy chọn'
        ],
        'breadcrumbs' => [
            'title' => 'Phương thức thanh toán',
            'payment_methods_index' => 'Danh sách phương thức thanh toán',
            'payment_methods_create' => 'Thêm phương thức thanh toán',
            'payment_methods_update' => 'Sửa phương thức thanh toán'
        ],
        'flash_message' => [
            'update' => 'Phương thức thanh toán đã được cập nhật!',
            'new' => 'Phương thức thanh toán đã được tạo!',
            'destroy' => 'Phương thức thanh toán đã được xóa!',
            'can\'t_destroy' => 'Không thể xóa phương thức thanh toán!'
        ],
        'not_found' => 'Không tìm thấy dữ liệu!',
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'description_en' => 'Mô tả tiếng Anh',
            'description_vi' => 'Mô tả tiếng Việt',
            'description_ja' => 'Mô tả tiếng Nhật',
            'status' => 'Trạng thái',
            'active' => 'Đang Hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo mới',
            'update' => 'Cập nhật',
            'cancel' => 'Hủy'
        ]
    ],
    'email_templates' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'status' => [
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động',
        ],
        'createButton' => 'Thêm định dạng email',
        'columns' => [
            'name_en' => 'Tên tiếng Anh',
            'name_vi' => 'Tên tiếng Việt',
            'name_ja' => 'Tên tiếng Nhật',
            'active' => 'Trạng thái',
            'action' => 'Tùy chọn'
        ],
        'breadcrumbs' => [
            'title' => 'Định dạng email',
            'email_templates_index' => 'Danh sách định dạng email',
            'email_templates_create' => 'Thêm định dạng email',
            'email_templates_update' => 'Sửa định dạng email'
        ],
        'flash_message' => [
            'update' => 'Định dạng email đã được cập nhật!',
            'new' => 'Định dạng email đã được tạo!',
            'destroy' => 'Định dạng email đã được xóa!',
            'can\'t_destroy' => 'Không thể xóa định dạng email!'
        ],
        'not_found' => 'Không tìm thấy dữ liệu!',
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'description_en' => 'Mô tả tiếng Anh',
            'description_vi' => 'Mô tả tiếng Việt',
            'description_ja' => 'Mô tả tiếng Nhật',
            'status' => 'Trạng thái',
            'active' => 'Đang Hoạt động'
        ],
        'buttons' => [
            'create' => 'Tạo mới',
            'update' => 'Cập nhật',
            'cancel' => 'Hủy'
        ]
    ],
    'weekly_menus' => [
        'search' => [
            'status' => 'Trạng thái',
            'place_holder_text' => 'Tìm theo tên...'
        ],
        'status' => [
            'all' => 'Tất Cả ',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động',
        ],
        'createButton' => 'Thêm Thực Đơn Tuần',
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'description_en' => 'Mô Tả Tiếng Anh',
            'description_vi' => 'Mô Tả Tiếng Việt',
            'description_ja' => 'Mô Tả Tiếng Nhật',
            'active' => 'Trạng Thái',
            'action' => 'Tùy Chọn',
            'image' => 'Hình',
            'from_date' => 'Từ Ngày',
            'to_date' => 'Đến Ngày'
        ],
        'breadcrumbs' => [
            'title' => 'Thực đơn tuần',
            'weekly_menus_index' => 'Danh sách thực đơn tuần',
            'weekly_menus_create' => 'Thêm thực đơn tuần',
            'weekly_menus_update' => 'Chỉnh sửa thực đơn tuần'
        ],
        'flash_message' => [
            'update' => 'Thực đơn tuần đã được cập nhật!',
            'new' => 'Thực đơn tuần đã được tạo!',
            'destroy' => 'Thực đơn tuần đã được xóa!',
            'can\'t_destroy' => 'Không thể xóa vì thực đơn tuần đang được sử dụng!',
            'can\'t_create' => 'Không thể thêm vì thực đơn đã tồn tại trong tuần!',
            'can\'t_update' => 'Không thể cập nhật vì thực đơn đã tồn tại trong tuần!',
        ],
        'not_found' => 'Không tìm thấy thực đơn tuần!',
        'forms' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'description_en' => 'Mô Tả Tiếng Anh',
            'description_vi' => 'Mô Tả Tiếng Việt',
            'description_ja' => 'Mô Tả Tiếng Nhật',
            'active' => 'Trạng Thái',
            'action' => 'Tùy Chọn',
        ],
        'buttons' => [
            'create' => 'Tạo Mới',
            'update' => 'Cập Nhật',
            'cancel' => 'Hủy'
        ],
        'text' => [
            'upload_text' => 'Kéo thả hoặc click để đăng hình',
            'date_validate' => 'Ngày kết thúc phải sau ngày bắt đầu'
        ],
    ],
    'abouts_us' => [
        'search' => [
            'status' => 'Trạng thái',
        ],
        'status' => [
            'all' => 'Tất Cả ',
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động',
        ],
        'createButton' => 'Thêm Giới Thiệu',
        'columns' => [
            'name_en' => 'Tên Tiếng Anh',
            'name_vi' => 'Tên Tiếng Việt',
            'name_ja' => 'Tên Tiếng Nhật',
            'description_en' => 'Mô Tả Tiếng Anh',
            'description_vi' => 'Mô Tả Tiếng Việt',
            'description_ja' => 'Mô Tả Tiếng Nhật',
            'short_description_en' => 'Mô Tả Ngắn Tiếng Anh',
            'short_description_vi' => 'Mô Tả Ngắn Tiếng Việt',
            'short_description_ja' => 'Mô Tả Ngắn Tiếng Nhật',
            'active' => 'Trạng Thái',
            'action' => 'Tùy Chọn',
            'image' => 'Hình',
        ],
        'breadcrumbs' => [
            'title' => 'Giới Thiệu',
            'abouts_us_index' => 'Danh sách Giới Thiệu',
            'abouts_us_create' => 'Thêm Giới Thiệu',
            'abouts_us_update' => 'Chỉnh sửa Giới Thiệu'
        ],
        'flash_message' => [
            'update' => 'Giới Thiệu đã được cập nhật!',
            'new' => 'Giới Thiệu đã được tạo!',
            'destroy' => 'Giới Thiệu đã được xóa!',
        ],
        'not_found' => 'Không tìm thấy Giới Thiệu!',
        'buttons' => [
            'create' => 'Tạo Mới',
            'update' => 'Cập Nhật',
            'cancel' => 'Hủy'
        ],
        'text' => [
            'upload_text' => 'Kéo thả hoặc click để đăng hình',
        ],
    ],
    'image_list' => [
        'createButton' => 'Thêm hình ảnh',
        'columns' => [
            'action' => 'Tùy Chọn',
            'image' => 'Hình Ảnh',
        ],
        'breadcrumbs' => [
            'title' => 'Hình Ảnh',
            'image_list_index' => 'Danh sách hình ảnh',
            'image_list_create' => 'Thêm hình ảnh',
            'image_list_update' => 'Chỉnh sửa hình ảnh'
        ],
        'flash_message' => [
            'update' => 'Hình ảnh đã được cập nhật!',
            'new' => 'Hình ảnh đã được tạo!',
            'destroy' => 'Hình ảnh đã được xóa!',
            'save_img' => 'Hình của bạn đã được lưu lại!',
            'upload_img' => 'Hình của bạn đã được upload!',
            'update_img' => 'Hình của bạn đã được cập nhật!',
            'save_thumb_img' => 'Ảnh thumb của bạn đã được lưu lại!',
            'upload_thumb_img' => 'Ảnh thumb của bạn đã được upload!',
            'update_thumb_img' => 'Ảnh thumb của bạn đã được cập nhật!'
        ],
        'not_found' => 'Không tìm thấy hình ảnh!',
        'buttons' => [
            'create' => 'Tạo Mới',
            'update' => 'Cập Nhật',
            'cancel' => 'Hủy'
        ],
        'text' => [
            'upload_text' => 'Kéo thả hoặc click để đăng hình',
        ],
    ],
    'orders' => [
        'search' => [
            'date' => 'Ngày',
            'place_holder_text' => 'Tìm kiếm theo email, số điện thoại..',
            'date_place_holder_text' => 'Chọn ngày'
        ],
        'status' => [
            'done' =>'Hoàn thành',
            'pending' => 'Mới'
        ],
        'columns' => [
            'name' => 'Tên',
            'email' => 'Email',
            'phone' => 'Điện thoại',
            'total' => 'Tổng Tiền',
            'note' => 'Ghi chú',
            'created_date' => 'Ngày tạo',
            'action' => 'Tùy chọn',
            'datetime_reservation' => 'Ngày đặt bàn',
            'address' => 'Địa chỉ',
            'pax' => 'Số khách',
            'status' => 'TRẠNG THÁI',
            'data' => 'NGÀY',
            'invoice_info' => 'THÔNG TIN ĐƠN HÀNG',
            'notes' => 'GHI CHÚ',
            'item' => 'MÓN',
            'unit_price' => 'ĐƠN GIÁ',
            'quantity' => 'SỐ LƯỢNG',
            'total_amount_item' => 'THÀNH TIỀN',
            'total_amount_invoice' =>'TỔNG TIỀN',
            'gender' => 'Giới tính',
            'delivery_address' => 'Địa chỉ nhận hàng',
            'district' => 'Quận',
            'datetime_delivery' => 'Thời gian nhận hàng',
            'payment_method' => 'Hình thức thanh toán'
        ],
        'breadcrumbs' => [
            'title_booking' => 'Đặt bàn',
            'title_order' => 'Đơn hàng',
            'booking_index' => 'Danh sách đặt bàn',
            'order_index' => 'Danh sách đơn hàng',
            'order_update' => 'Chỉnh sửa đơn hàng',
            'booking_update' => 'Chỉnh sửa đặt bàn',
            'booking_view' => 'Xem chi tiết đặt bàn',
            'order_view' => 'Xem chi tiết đơn hàng',
        ],
        'flash_message' => [
            'update_booking' => 'Thông tin đặt bàn đã được cập nhật!',
            'update_order' => 'Đơn hàng đã được cập nhật!',
        ],
        'not_found_order' => 'Không tìm thấy đơn hàng!',
        'not_found_booking' => 'Không tìm thấy thông tin đặt bàn!',
    ],
    'media_modal' => [
        'title' => 'Quản Lý Hình Ảnh',
        'button' => [
            'upload' => 'Upload',
            'save' => 'Lưu',
            'close' => 'Đóng'
        ],
        'tab' => [
            'library' => 'Thư viện',
            'upload' => 'Đăng tải'
        ],
        'text' => [
            'upload_text' => 'Đăng tải ảnh',
            'upload_img' => 'Đăng tải hình ảnh của bạn',
            'choose_img' => 'Chọn hình ảnh của bạn',
            'img_name' => 'Tên Ảnh',
            'img_size' => 'Kích Thước Ảnh',
            'upload_thumb_img' => 'Đăng tải ảnh thumb của bạn',
            'choose_thumb_img' => 'Chọn ảnh thumb của bạn',
            'thumb_img_name' => 'Tên Ảnh Thumb',
            'thumb_img_size' => 'Kích Thước Ảnh Thumb',
            'img_before' => 'Ảnh lúc trước',
            'img_after' => 'Ảnh lúc sau',
        ]
    ]
];
