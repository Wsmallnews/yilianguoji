                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>用户id</th>
                                            <th>所属用户</th>
                                            <th>用户名</th>
                                            <th>用户昵称</th>
                                            <th>邀请码</th>
                                            <th>注册时间</th>
                                            <th>激活状态</th>
                                            <th>激活时间</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user_list as $list)
                                        <tr class="gradeC" user_id="{{$list->id}}">
                                            <td>{{$list->id}}</td>
                                            <td>{{$list->id}}</td>
                                            <td>{{$list->name}}</td>
                                            <td>{{$list->nick_name}}</td>
                                            <td>{{$list->invi_code}}</td>
                                            <td>{{$list->created_at}}</td>
                                            <td>@if($list->status)已激活 @else 未激活 <button type="button" class="active_btn" >激活</button>@endif</td>
                                            <td>{{$list->invi_at}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <nav id="pagination">
                                    {!!$user_list->render()!!}
                                </nav>
