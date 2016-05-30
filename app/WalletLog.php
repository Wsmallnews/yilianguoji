<?php
namespace App;

class WalletLog extends CommonModel{

	protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('u_id','type_id','type','money','status');

}
