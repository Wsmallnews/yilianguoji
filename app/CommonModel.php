<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class CommonModel extends Model {
	// 如果数据库表的名称不是Topics ，则可以使用下面的方法，进行声明
	// protected $table = 'Topics';
	
	// Eloquent 也会假设每个数据库表都有一个字段名称为 id 的主键。
	// 可以在类里定义 primaryKey 属性来重写。
	// protected $primaryKey = 'o_id';

	// 可以定义 connection 属性，指定模型连接到指定的数据库连接。
	// protected $connection = '';
	
	// 在默认情况下，在数据库表里需要有 updated_at 和 created_at 两个字段。
	// 如果不想设定或自动更新这两个字段，则将类里的 $timestamps 属性设为 false即可。
	// protected $timestamps = false;
	
	// fillable 属性指定了哪些字段支持批量赋值 。可以设定在类的属性里或是实例化后设定。
	// protected $fillable = ['first_name', 'last_name', 'email'];

	// Guarded 属性指定了哪些字段不支持批量赋值 。fillable ，为白名单，guarded 为黑名单
	// protected $Guarded  = ['id', 'password'];
	

	// 可以使用 guard 属性阻止所有属性被批量赋值：
	// protected $guarded = ['*'];

	// 通常 Eloquent 模型主键值会自动递增。但是您若想自定义主键，将 incrementing 属性设成 false 。
	// protected $incrementing = false;

	// 模型使用软删除功能，只要在模型类里加入下面语句，数据库添加 deleted_at字段
	// protected $softDelete  = true;
	
	// 有时您可能想要限制能出现在数组或 JSON 格式的属性数据，比如密码字段。只要在模型里增加 hidden 属性即可
    // protected $hidden = ['password'];

}