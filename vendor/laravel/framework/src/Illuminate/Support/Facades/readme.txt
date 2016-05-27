Facade 作为在 IoC 容器里面的基础类的静态代理

通过facade.php 基类中的静态魔术方法，__callstatic方法，将静态调用方法，如（Rount::get()）,指向到对应的get方法

controller 中使用的静态方法，
例解答：
use Request;	//这个request 的位置为 静态代理（facade接口）的实现，Illuminate\Support\Facades\Request

function test(){
	Request::input();
}
