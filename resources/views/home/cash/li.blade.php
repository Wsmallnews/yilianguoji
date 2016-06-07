                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>所属用户</th>
                                            <th>金额</th>
                                            <th>状态</th>
                                            <th>驳回原因</th>
                                            <th>提现时间</th>
                                            <th>处理时间</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cash_list as $list)
                                        <tr class="gradeC" cash_id="{{$list->id}}">
                                            <td>{{$list->id}}</td>
                                            <td>{{$list->user->name}}</td>
                                            <td>{{$list->money}}</td>
                                            <td>@if($list->status == 0)未处理 @elseif($list->status == 1) 提现成功 @elseif($list->status == -1) 提现驳回 @endif</td>
                                            <td>{{$list->fail_msg}}</td>
                                            <td>{{$list->created_at}}</td>
                                            <td>{{$list->updated_at}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <nav id="pagination">
                                    {!!$cash_list->render()!!}
                                </nav>
