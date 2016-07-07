<script type="text/javascript">
@if($errors->any())
    l.error("{{$errors->first()}}");
@endif

@if(Session::get('success'))
    l.success("{{ Session::get('success','操作成功') }}")
@endif

</script>
