                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>标题</th>
                                            <th>创建时间</th>
                                            <th>修改时间</th>
                                            <th>是否置顶</th>
                                            <th>是否删除</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($article_list as $list)
                                        <tr class="gradeC" cash_id="{{$list->id}}">
                                            <td>{{$list->id}}</td>
                                            <td>{{$list->title}}</td>
                                            <td>{{$list->created_at}}</td>
                                            <td>{{$list->update_at}}</td>
                                            <td>{{$list->is_top}}</td>
                                            <td>{{$list->deleted_at}}</td>
                                            <td><a href="{{URL::to('home/articleEdit',array('id' => $list->id))}}" class="btn btn-success" status="1">编辑</a>  <a href="{{URL::to('home/articleView',array('id' => $list->id))}}" class="btn btn-primary" status="-1">查看</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <nav id="pagination">
                                    {!!$article_list->render()!!}
                                </nav>
