                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>所属用户</th>
                                            <th>金额</th>
                                            <th>添加时间</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($recharge_list as $list)
                                        <tr class="gradeC" cash_id="{{$list->id}}">
                                            <td>{{$list->id}}</td>
                                            <td>{{$list['users']['name']}}</td>
                                            <td>{{$list->money}}</td>
                                            <td>{{$list->created_at}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <nav id="pagination">
                                    {!!$recharge_list->render()!!}
                                </nav>
