<?php

declare(strict_types=1);

return [
    'vote' => 'đánh giá',
    'votes' => 'đánh giá',
    'vote.id' => 'ID',
    'vote.score' => 'điểm',
    'vote.description' => 'mô tả',
    'vote.created_at' => 'tạo lúc',
    'vote.updated_at' => 'cập nhật lúc',
    'vote.owner_id' => 'người sở hữu',
    'vote.owner.name' => 'tên người sở hữu',
    'vote.hostel_id' => 'nhà trọ',
    'vote.hostel.title' => 'tên nhà trọ',

    'visit' => 'lượt truy cập',
    'visits' => 'lượt truy cập',
    'visit.id' => 'ID',
    'visit.created_at' => 'tạo lúc',
    'visit.updated_at' => 'cập nhật lúc',
    'visit.languages' => 'các ngôn ngữ',
    'visit.device' => 'thiết bị',
    'visit.platform' => 'nền tảng',
    'visit.browser' => 'trình duyệt',
    'visit.ip' => 'IP',
    'visit.visitable.title' => 'tên nhà trọ',
    'visit.visitor.email' => 'e-mail người truy cập',

    'user' => 'người dùng',
    'users' => 'người dùng',
    'user.id' => 'ID',
    'user.created_at' => 'tạo lúc',
    'user.updated_at' => 'cập nhật lúc',
    'user.name' => 'tên',
    'user.email' => 'e-mail',
    'user.email_verified_at' => 'xác thực e-mail lúc',
    'user.password' => 'mật khẩu',
    'user.two_factor_secret' => 'khoá xác minh 2 bước',
    'user.two_factor_recovery_codes' => 'các mã phục hồi xác minh 2 bước',
    'user.two_factor_secret' => 'khoa xác minh 2 bước',
    'user.two_factor_confirmed_at' => 'xác nhận xác minh 2 bước lúc',
    'user.phone_number' => 'số điện thoại',
    'user.id_number' => 'cmnd/cccd',

    'role' => 'vai trò',
    'roles' => 'vai trò',
    'role.id' => 'ID',
    'role.created_at' => 'tạo lúc',
    'role.updated_at' => 'cập nhật lúc',
    'role.name' => 'tên',
    'role.guard_name' => 'tên cổng bảo vệ',
    'role.permissions' => 'các quyền',

    'permission' => 'quyền hạn',
    'permissions' => 'quyền hạn',
    'permission.id' => 'ID',
    'permission.created_at' => 'tạo lúc',
    'permission.updated_at' => 'cập nhật lúc',
    'permission.name' => 'tên',
    'permission.guard_name' => 'tên cổng bảo vệ',

    'hostel' => 'nhà trọ',
    'hostels' => 'nhà trọ',
    'hostel.id' => 'ID',
    'hostel.created_at' => 'tạo lúc',
    'hostel.updated_at' => 'cập nhật lúc',
    'hostel.title' => 'tiêu đề',
    'hostel.slug' => 'slug',
    'hostel.description' => 'mô tả',
    'hostel.found_at' => 'tìm được người thuê lúc',
    'hostel.address' => 'địa chỉ',
    'hostel.latitude' => 'vĩ độ',
    'hostel.longitude' => 'kinh độ',
    'hostel.coordinates' => 'tọa độ',
    'hostel.size' => 'kích cỡ',
    'hostel.monthly_price' => 'giá hàng tháng',
    'hostel.categories' => 'các danh mục',
    'hostel.amenities' => 'các tiện nghi',
    'hostel.default' => 'các ảnh',
    'hostel.votes_score' => 'đánh giá',
    'hostel.votes_avg_score' => 'đánh giá trung bình',
    'hostel.allowable_number_of_people' => 'số người ở tối đa',
    'hostel.owner_id' => 'người sở hữu',

    'subscriber' => 'Người đăng ký',
    'subscribers' => 'Người đăng ký',
    'subscribers.name' => 'Tên',
    'subscribers.phone_number' => 'Số điện thoại',

    'comment' => 'bình luận',
    'comments' => 'bình luận',
    'comment.id' => 'ID',
    'comment.created_at' => 'tạo lúc',
    'comment.updated_at' => 'cập nhật lúc',
    'comment.content' => 'nội dung',
    'comment.owner_id' => 'người sở hữu',
    'comment.owner.name' => 'tên người sở hữu',
    'comment.hostel_id' => 'nhà trọ',

    'category' => 'danh mục',
    'categories' => 'danh mục',
    'category.id' => 'ID',
    'category.created_at' => 'tạo lúc',
    'category.updated_at' => 'cập nhật lúc',
    'category.name' => 'tên',
    'category.description' => 'mô tả',

    'amenity' => 'tiện ích',
    'amenities' => 'tiện ích',
    'amenity.id' => 'ID',
    'amenity.created_at' => 'tạo lúc',
    'amenity.updated_at' => 'cập nhật lúc',
    'amenity.name' => 'tên',
    'amenity.description' => 'mô tả',
];
