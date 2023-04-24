<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        @if (config('admin.show_environment'))
            <strong>Env</strong>&nbsp;&nbsp; {!! config('app.env') !!}
        @endif

        &nbsp;&nbsp;&nbsp;&nbsp;


        <strong>Version</strong>&nbsp;&nbsp; {!! \Encore\Admin\Admin::VERSION !!}


    </div>
    <!-- Default to the left -->
    <strong>Powered by <a href="https://agriculture.co.ug/" class="text-success" target="_blank">MAAIF Uganda</a></strong>
</footer>
