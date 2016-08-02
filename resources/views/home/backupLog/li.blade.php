                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>日期</th>
                                            <th>耗时</th>
                                            <th>文件名称</th>
                                            <th>备份类型</th>
                                            <th>创建时间</th>
                                            <!-- <th>操作</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($backup_list as $list)
                                        <tr class="gradeC" cash_id="{{$list->id}}">
                                            <td>{{$list->id}}</td>
                                            <td>{{$list->days}}</td>
                                            <td>{{$list->use_time}}</td>
                                            <td>{{$list->file_name}}</td>
                                            <td>@if($list->is_auto == 1)自动备份@else手动备份@endif</td>
                                            <td>{{$list->created_at}}</td>
                                            <!-- <td><button type="button" class="btn btn-success oper_btn" status="1">下载</button></td> -->
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <nav id="pagination">
                                    {!!$backup_list->render()!!}
                                </nav>
