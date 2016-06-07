                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>所属用户</th>
                                            <th>记录类型</th>
                                            <th>金额</th>
                                            <th>状态</th>
                                            <th>添加时间</th>
                                            <th>修改时间</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($wallet_list as $list)
                                        <tr class="gradeC" cash_id="{{$list->id}}">
                                            <td>{{$list->id}}</td>
                                            <td>{{$list->user->name}}</td>
                                            <td>{{$list->type}}</td>
                                            <td>{{$list->money}}</td>
                                            <td>@if($list->status == 0)未完成 @elseif($list->status == 1) 已完成 @endif</td>
                                            <td>{{$list->created_at}}</td>
                                            <td>{{$list->updated_at}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <nav id="pagination">
                                    {!!$wallet_list->render()!!}
                                </nav>
