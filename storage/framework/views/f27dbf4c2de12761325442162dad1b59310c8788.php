<?php
use App\Models\Utils;
?> 
<div class="card  mb-4 mb-md-5 border-0">
    <!--begin::Header-->
    <div class="d-flex justify-content-between px-3 pt-2 px-md-4 border-bottom">
        <h4 style="line-height: 1; margrin: 0; " class="fs-22 fw-800">
            My Evaluation
        </h4>
    </div>
    <div class="card-body py-2 py-md-3">
        <canvas id="graph_animals" style="width: 100%;"></canvas>
    </div>
</div>


<script>
    $(function() {
        var config = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [96, 4],
                    backgroundColor: [
                        'green',
                        'red',
                        '#F6DE5C',
                        '#7D57F8',
                        '#431B02',
                        '#23A2E9',
                        '#34F1B7',
                        '#868686',
                        '#C71C5D',
                        '#D0B1FD',
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Completed activities - 96%',
                    'Pending activities - 4%', 
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'left',
                    display: true, 
                },
                title: {
                    display: false,
                    text: 'Persons with Disabilities by Categories'
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        };

        var ctx = document.getElementById('graph_animals').getContext('2d');
        new Chart(ctx, config);
    });
</script>
<?php /**PATH C:\github\maaif\admin\resources\views/widgets/by-categories.blade.php ENDPATH**/ ?>