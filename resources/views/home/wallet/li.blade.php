                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>用户名</th>
                                            <th>余额</th>
                                            <th>锁定余额</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($wallet_list as $list)
                                        <tr class="gradeC" wallet_id="{{$list->id}}">
                                            <td>{{$list->id}}</td>
                                            <td class="user_name">@if($list->id == 0)系统账号@else<a href="{{URL::to('home/adminWalletLogList',array('id' => $list->id))}}">{{$list['users']['name']}}</a>@endif</td>
                                            <td>{{$list->money}}</td>
                                            <td>{{$list->money_lock}}</td>
                                            <td><button type="button" class="btn btn-success oper_btn" status="1">充值</button></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <nav id="pagination">
                                    {!!$wallet_list->render()!!}
                                </nav>
