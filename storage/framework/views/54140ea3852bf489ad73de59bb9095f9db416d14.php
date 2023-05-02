<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        <?php if(config('admin.show_environment')): ?>
            <strong>Env</strong>&nbsp;&nbsp; <?php echo config('app.env'); ?>

        <?php endif; ?>

        &nbsp;&nbsp;&nbsp;&nbsp;


        <strong>Version</strong>&nbsp;&nbsp; <?php echo \Encore\Admin\Admin::VERSION; ?>



    </div>
    <!-- Default to the left -->
    <strong>Powered by <a href="https://agriculture.co.ug/" class="text-success" target="_blank">MAAIF Uganda</a></strong>
</footer>
<?php /**PATH C:\github\maaif\vendor\encore\laravel-admin\src/../resources/views/partials/footer.blade.php ENDPATH**/ ?>