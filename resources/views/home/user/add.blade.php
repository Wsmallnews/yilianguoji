<!DOCTYPE html>
<html>
<head>
    @include('home.includes.load')
    <link href="{{ asset('/plus/bootstrap/dist/css/bootstrapValidator.min.css') }}" rel="stylesheet" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>添加用户  - {{$l_web['web_name']}}</title>
    
</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        
        @include('home.includes.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">添加会员</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="col-lg-12 row">
                <form id="defaultForms" method="post" class="form-horizontal" action="{{url('home/userDoAdd')}}">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">用户名</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="name" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">昵称</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="nick_name" value="{{ old('nick_name') }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">邮箱</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">密码</label>
                        <div class="col-lg-5">
                            <input type="password" class="form-control" name="password" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">确认密码</label>
                        <div class="col-lg-5">
                            <input type="password" class="form-control" name="confirmPassword" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-3 control-label">手机</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">性别</label>
                        <div class="col-lg-5">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" id="inlineRadio1" value="male" @if(old('gender') == 'male') checked @endif /> 男
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" id="inlineRadio2" value="female" @if(old('gender') == 'female') checked @endif /> 女
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" id="inlineRadio3" value="other" @if(old('gender') == 'other' || old('gender') === null) checked @endif /> 其他
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">生日</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="birth" value="{{ old('birth') }}" /> 0000-00-00
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-3 control-label">真实姓名</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="real_name" value="{{ old('real_name') }}" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-3 control-label">身份证号</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="cert_no" value="{{ old('cert_no') }}" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-3 control-label">账户类型</label>
                        <div class="col-lg-5">
                            <select name="card_type" class="form-control">
                                <option value="1" @if(old('card_type') == 1 ) selected @endif>支付宝</option>
                                <option value="2" @if(old('card_type') == 2 ) selected @endif>银行卡</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-3 control-label">银行账户</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="card_no" value="{{ old('card_no') }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-info" id="validateBtn">注册</button>
                            <button type="button" class="btn btn-info" id="resetBtn">取消</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    @include('home.includes.loadjs')
    <script src="{{ asset('/plus/bootstrap/dist/js/bootstrapValidator.min.js') }}"></script>

    <script>

    @if($errors->any())
        alert("{{$errors->first()}}");
    @endif
    
    $('#defaultForm').bootstrapValidator({
//      live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
    		nick_name: {
    			validators: {
    				notEmpty: {
    					message: '用户昵称不能为空'
    				}
    			}
    		},
//     		email: {
//         		validators: {
//                     notEmpty: {
//                         message: '邮箱不能为空'
//                     },
//                     emailAddress: {
//                         message: '邮箱格式不正确'
//                     }
//                 }
//     		},
//     		password: {
//         		validators: {
//             		notEmpty: {
//             		    message: '密码不能为空'
//             		},
//             		identical: {
//                 		field: 'confirmPassword',
//                 		message: '两次输入密码不一致'
//             		},
//             		different: {
//                 		field: 'nick_name',
//                 		message: '密码不能和昵称相同'
//             		}
//         		}
//     		},
//     		confirmPassword: {
//         		validators: {
//             		notEmpty: {
//             		    message: '确认密码不能为空'
//           			},
//             		identical: {
//                 		field: 'password',
//                 		message: '两次输入密码不一致'
//             		},
//             		different: {
//             			field: 'nick_name',
//                 		message: '密码不能和昵称相同'
//             		}
//         		}
//     		},
//     		phone: {
//         		message: '手机号不正确',
//         		validators: {
//             		notEmpty: {
//           			    message: '手机号不能为空'
//             		},
//             		regexp: {
//                 		regexp: /^1\d{10}$/,
//                 		message: '手机号格式不正确'
//             		}
// //             		,
// //             		callback: {
// //                 		message: '手机号已存在',
// //                 		callback: function(value) {
// //                     		console.log(value);
// //                     		var phone = $('#defaultForm input[name=phone]').val();
// //                     		var length = parseInt(phone.length);
                    		
// //                     		if(length == 11){
// //                         		return true;
// // //                     		    l.ajax({
// // //                         		    url:"{{url('home/doLogin')}}",
// // //                         		    data:{phone:phone},
// // //                         		    success:function(r){
// // //                             		    if(r.status){
// // //                                 		    return true;
// // //                                 		}
// // //                                 		return false;
// // //                             		}
// // //                         		});
// //                         	}
                    		
// //                 		}
// //             		}
//         		}
//     		},
//     		gender: {
//         		validators: {
//             		notEmpty: {
//           			    message: '性别必须选择'
//             		}
//         		}
//     		},
//     		birth: {
//         		validators: {
//         			notEmpty: {
//           			    message: '生日不能为空'
//             		},
//             		date: {
//                 		format: 'YYYY-MM-DD',
//                 		message: '生日格式不正确'
//             		}
//         		}
//     		},
//     		real_name: {
//     			validators: {
//     				notEmpty: {
//     					message: '真是姓名不能为空'
//     				}
//     			}
//     		},
//     		cert_no: {
//     			validators: {
//     				notEmpty: {
//     					message: '身份证号不能为空'
//     				}
//     			}
//     		},
//     		card_type: {
//     			validators: {
//     				notEmpty: {
//     					message: '账户类型必须选择'
//     				}
//     			}
//     		},
//     		card_no: {
//     			validators: {
//     				notEmpty: {
//     					message: '银行账户不能为空'
//     				}
//     			}
//     		}
    	}
    }).on('success.form.bv', function(e) {
    	$("#defaultForm").submit();
        // alert('success');
        // Prevent form submission
        // e.preventDefault();

        // Get the form instance
        // var $form = $(e.target);

        // Get the BootstrapValidator instance
        // var bv = $form.data('bootstrapValidator');


        // Use Ajax to submit form data
//         $.post($form.attr('action'), $form.serialize(), function(result) {
//             console.log(result);
//         }, 'json');
    });

    // Validate the form manually
//     $('#validateBtn').click(function() {
//       $('#defaultForm').bootstrapValidator('validate');
//     });
    
//     $('#resetBtn').click(function() {
//       $('#defaultForm').data('bootstrapValidator').resetForm(true);
//     });

    </script>
    
</body>

</html>
