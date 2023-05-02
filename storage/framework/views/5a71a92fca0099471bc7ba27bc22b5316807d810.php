<?php
use App\Models\Utils;
?><style>
    .ext-icon {
        color: rgba(0, 0, 0, 0.5);
        margin-left: 10px;
    }

    .installed {
        color: #00a65a;
        margin-right: 10px;
    }

    .card {
        border-radius: 5px;
    }

    .case-item:hover {
        background-color: rgb(254, 254, 254);
    }
</style>
<div class="card  mb-4 mb-md-5 border-0">
    <!--begin::Header-->
    <div class="d-flex justify-content-between px-2 px-md-4 border-bottom ">
        <p class="h4  text-bold mb-2 mb-md-3 ">My recent daily activities</p> 
        <div>
            <a href="<?php echo e(admin_url('/events'), false); ?>" class="btn btn-sm btn-success mt-2">
                View All
            </a>
        </div>
    </div>
    <div class="card-body py-2 py-md-3 ">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="d-flex align-items-center mb-2 case-item bg-light">
                <a href="<?php echo e(url('/dinner'), false); ?>" title="<?php echo e($i->topic_text, false); ?>" style="border-left: solid rgb(44, 132, 3) 5px!important;"
                    class="flex-grow-1 pl-2 pl-md-3 border-primary text-primary">
                    <b><?php echo e(Utils::my_date($i->date), false); ?></b> - <b
                        class="text-success"><?php echo e(Str::limit($i->topic_text, 30), false); ?></b>
                    <span class="text-dark d-block">
                        <?php echo e(Str::limit($i->notes, 50), false); ?>,
                    </span>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH C:\github\maaif\admin\resources\views/dashboard/events.blade.php ENDPATH**/ ?>