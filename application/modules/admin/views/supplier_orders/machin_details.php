<div class="row">
    <div class="col-md-6">


        <div class="panel panel-default">
            <div class="panel-heading">
            <h3 class="panel-title">Machin Details</h3>
            </div>
            <div class="panel-body">
            <div class="table-responsive">

            <table class="table">
                    <?php foreach($machine as $key=>$val){ ?>
                    <tr>
                    <td>
                    <?php echo $key ?>

                    </td>
                    <th>

                    <?php if($key == 'image'){ ?>
                    <img src="<?php echo $val ?>" width="200px" heigth="200px" />
                    <?php }else{ ?>
                        <?php echo $val ?>
                    <?php } ?>
                    </th>

                    </tr>
                    <?php } ?>
            </table>

            </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">


        <div class="panel panel-default">
            <div class="panel-heading">
            <h3 class="panel-title">Personal Details</h3>
            </div>
            <div class="panel-body">
            <div class="table-responsive">
            <table class="table">
                    <?php foreach($user_detail as $key=>$val){ ?>
                    <tr>
                    <td><?php echo $key ?></td>
                    <th><?php echo $val ?></th>

                    </tr>
                    <?php } ?>
            </table>
            </div>
            </div>
        </div>
    </div>
</div>
