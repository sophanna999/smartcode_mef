@if($errors->any())
    <script type="text/javascript">
        var messages = '';
        @foreach($errors->all() as $error)
            messages += '{{ $error }}' +'<br>';
        @endforeach

        if(messages){
            notification(messages,'warning');
        }
    </script>
@endif