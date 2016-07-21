<script type="text/javascript">
@if($errors->any())
    l.error("{{$errors->first()}}");
@endif

@if(Session::get('success'))
    l.success("{{ Session::get('success','操作成功') }}")
@endif

</script>
<img src="{{URL::to('crontab')}}" style="width:0px;height:0px;" />
