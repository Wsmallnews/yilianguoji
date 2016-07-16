                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>用户id</th>
                                            <th>用户名</th>
                                            <th>所属用户</th>
                                            <th>用户等级</th>
                                            <th>邮箱</th>
                                            <th>手机号</th>
                                            <th>注册时间</th>
                                            <th>激活状态</th>
                                            <th>激活时间</th>
                                            @if($l_user->super_man && Route::currentRouteName() == 'userListAdmin')
                                            <th>冻结</th>
                                            <th>操作</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user_list as $list)
                                        <tr class="gradeC" user_id="{{$list->id}}">
                                            <td>{{$list->id}}</td>
                                            <td class="user_name">{{$list->name}}</td>
                                            <td>@if($list->parent){{$list->parent->name}}@else<span style="color:#fd6f0a">顶级会员</span>@endif</td>
                                            <td>{{$list->rank}}</td>
                                            <td>{{$list->email}}</td>
                                            <td>{{$list->phone}}</td>
                                            <td>{{$list->created_at}}</td>
                                            <td>@if($list->status)已激活 @else 未激活 <button type="button" class="btn btn-primary active_btn" >激活</button>@endif</td>
                                            <td>{{$list->invi_at}}</td>
                                            @if($l_user->super_man && Route::currentRouteName() == 'userListAdmin')
                                            <td>@if($list->trashed())<button type="button" class="btn btn-default freeze_btn" btn_type="open">解冻</button>  <button type="button" class="btn btn-danger freeze_btn" btn_type="del">删除</button>@else<button type="button" class="btn btn-warning freeze_btn" btn_type="close">冻结</button>@endif</td>
                                            <td><a href="{{URL::to('home/userEdit',array('id' => $list->id))}}" class="btn btn-info edit_user_btn" >修改资料</a>  <button type="button" class="btn btn-warning reset_user_btn" >重置密码</button></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <nav id="pagination">
                                    {!!$user_list->render()!!}
                                </nav>
