<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-th"></i>
    </a>
    <ul class="dropdown-menu" style="padding: 0;box-shadow: 0 2px 3px 0 rgba(0,0,0,.2);">
        <li>
            <div class="box box-solid" style="width: 300px;height: 300px;margin-bottom: 0;">
                <div class="box-body">

                    <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="btn btn-app" href="<?php echo e($i['url'], false); ?>">
                            <i class="fa fa-<?php echo e($i['icon'], false); ?>"></i> <?php echo e($i['title'], false); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </li>
    </ul>
</li>
<?php /**PATH C:\github\maaif\resources\views/widgets/dropdown.blade.php ENDPATH**/ ?>