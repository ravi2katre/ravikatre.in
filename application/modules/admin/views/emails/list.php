<div class="container_list" >

    <button class="btn btn-success" onclick="add_row()"><i class="glyphicon glyphicon-plus"></i>Add</button>
    <button class="btn btn-default" onclick="reloadTable()"><i class="glyphicon glyphicon-refresh"></i>Reload</button>
    <button id="deleteList" class="btn btn-danger" style="display: none;" onclick="deleteList()"><i class="glyphicon glyphicon-trash"></i>Delete list</button>
    <br />
    <br />
    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th><input type="checkbox" id="check-all"></th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        </tfoot>
    </table>
</div>

<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function() {

        //datatables
        table = $('#table').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo $ctrler; ?>/ajax_list",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [ 0 ], //first column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [ -1 ], //last column
                    "orderable": false, //set not orderable
                },

            ],


        });

        //check all
        $("#check-all").click(function () {
            $(".data-check").prop('checked', $(this).prop('checked'));
            showBottomDelete();
        });



    });

    function showBottomDelete()
    {
        var total = 0;

        $('.data-check').each(function()
        {
            total+= $(this).prop('checked');
        });

        if (total > 0)
            $('#deleteList').show();
        else
            $('#deleteList').hide();
    }

    function add_row()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $(".modal-body").find('.info_box').html('');
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add'); // Set Title to Bootstrap modal title
    }

    function edit_row(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $(".modal-body").find('.info_box').html('');
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo $ctrler; ?>/ajax_edit/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

                $('[name="id"]').val(data.id);
                $('[name="detail[first_name]"]').val(data.first_name);
                $('[name="detail[last_name]"]').val(data.first_name);
                $('[name="detail[email]"]').val(data.email);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error getting data from ajax');
            }
        });
    }

    function reloadTable()
    {
        //table.ajax.reload();
        table.ajax.reload(null,false); //reload datatable ajax
        $('#deleteList').hide();
    }

    function save()
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable
        var url;

        if(save_method == 'add') {
            url = "<?php echo $ctrler; ?>/ajax_add";
        } else {
            url = "<?php echo $ctrler; ?>/ajax_update";
        }

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reloadTable();
                }
                else
                {       //select parent twice to select div form-group class and add has-error class
                        $(".modal-body").find('.info_box').html('<div class="alert alert-danger fade in has-error">'+data.error_string+'</div>'); //select span help-block class set text error string

                }
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

            }
        });
    }

    function delete_row(id)
    {
        if(confirm('Are you sure to remove the record?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo $ctrler; ?>/ajax_delete/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reloadTable();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });

        }
    }

    function deleteList()
    {
        var list_id = [];
        $(".data-check:checked").each(function() {
            list_id.push(this.value);
        });
        if(list_id.length > 0)
        {
            if(confirm('Are you sure delete this '+list_id.length+' data?'))
            {
                $.ajax({
                    type: "POST",
                    data: {id:list_id},
                    url: "<?php echo $ctrler; ?>/ajax_list_delete",
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.status)
                        {
                            reloadTable();
                        }
                        else
                        {
                            alert('Failed.');
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });
            }
        }
        else
        {
            alert('no data selected');
        }
    }

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Menu</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <div class="info_box"></div>
                    <input type="hidden" value="" name="<?php echo $primary_key_field; ?>"/>
                    <div class="form-body">

                        <div class="form-group">
                            <label class="control-label col-md-3">First Name</label>
                            <div class="col-md-9">
                                <input name="detail[first_name]" placeholder="First Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Last Name</label>
                            <div class="col-md-9">
                                <input name="detail[last_name]" placeholder="Last Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email/Username</label>
                            <div class="col-md-9">
                                <input name="detail[email]" placeholder="email" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Password</label>
                            <div class="col-md-9">
                                <input name="detail[password]" placeholder="Password" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Password Confirmation</label>
                            <div class="col-md-9">
                                <input name="password_confirm" placeholder="Password Confirmation" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Group</label>
                            <div class="col-md-9">
                                <select name="detail[group_id]" class="form-control">
                                    <option value="0">--Select Group--</option>
                                    <?php
                                    foreach($list as $value){
                                        echo '<option value="'.$value->menu_id.'">'.$value->name.'</option>';
                                    }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
