<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong cơ sở dữ liệu (nếu không theo quy ước của Laravel)
     * Laravel mặc định sử dụng số nhiều của tên class cho tên bảng, như ở đây sẽ là 'admins'.
     * Nếu bảng của bạn tên là 'admin', bạn cần chỉ định nó.
     */
    protected $table = 'admin';

    /**
     * Các thuộc tính có thể gán hàng loạt.
     * Laravel bảo vệ các thuộc tính khỏi việc gán hàng loạt một cách không an toàn.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Các thuộc tính bị ẩn khi đối tượng được chuyển đổi thành mảng hoặc JSON.
     * Điều này hữu ích khi bạn trả về dữ liệu qua API và không muốn hiển thị thuộc tính như 'password'.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Thiết lập auto hash password khi tạo hoặc cập nhật.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
