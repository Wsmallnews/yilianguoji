                                <ul class="chat">
                                    @foreach($article_list as $key => $list)
                                    <li class="left clearfix" article_id="{{$list->id}}">
                                        <a href="{{url('home/articleView',array('id' => $list->id))}}">
                                            <span class="chat-icon pull-left">
                                                <i class="fa fa-hand-o-right fa-5x huge"></i>
                                            </span>

                                            <div class="chat-body clearfix">
                                                <div class="header">
                                                    <strong class="primary-font">{{$list->title}}</strong>
                                                    <small class="pull-right text-muted">
                                                        <i class="fa fa-clock-o fa-fw"></i> {{$list->updated_at}}
                                                    </small>
                                                </div>
                                                <p>
                                                    {{$list->description}}
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>

                                <nav id="pagination">
                                    {!!$article_list->render()!!}
                                </nav>
