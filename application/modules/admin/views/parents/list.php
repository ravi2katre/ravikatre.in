<div class="container_list" >

    <button class="btn btn-success" onclick="add_row()"><i class="glyphicon glyphicon-plus"></i>Add</button>
    <button class="btn btn-default" onclick="reloadTable()"><i class="glyphicon glyphicon-refresh"></i>Reload</button>
    <button class="btn btn-default" onclick="import_frm()"><i class="glyphicon glyphicon-import"></i>Import</button>
    <button id="deleteList" class="btn btn-danger" style="display: none;" onclick="deleteList()"><i class="glyphicon glyphicon-trash"></i>Delete list</button>
    <br />
    <br />

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title" >Custom Filter : </h3>
        </div>
        <div class="panel-body">
            <form id="form-filter" class="form-inline">

                <div class="form-group">
                    <label for="FirstName" class="control-label">First Name</label>
                    <div class="">
                        <input type="text" class="form-control" id="first_name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="control-label">Lirst Name</label>
                    <div class="">
                        <input type="text" class="form-control" id="last_name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="first_name" class=" control-label">Principal Name</label>
                    <div class="">
                        <input type="text" class="form-control" id="first_name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="control-label">Contact Number</label>
                    <div class="">
                        <input type="text" class="form-control" id="phone">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <div class="">
                        <input type="text" class="form-control" id="email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class=" control-label"></label>
                    <div class="">
                        <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                        <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th><input type="checkbox" id="check-all"></th>

            <th>Id</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Phone2</th>
            <th>Email</th>
            <th>Address</th>

            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        </tbody>
        <tfoot>
        <tr>
            <th></th>

            <th>Id</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Phone2</th>
            <th>Email</th>
            <th>Address</th>


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
                "type": "POST",
                "data": function ( data ) {
                    data.first_name = $('#first_name').val();
                    data.email = $('#email').val();
                }
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

                <?php
                    foreach($columns as $val){
                        if(!empty($val) && $val != $primary_key_field){
                ?>
                    $('[name="detail[<?php echo $val;?>]"]').val(data.<?php echo $val;?>);
                <?php

                        }
                    }
                ?>



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

<script>
    $(document).ready(function() {


        $(document).ready(function() {
            $('#btn-filter').click(function(){ //button filter event click
                table.ajax.reload();  //just reload table
            });
            $('#btn-reset').click(function(){ //button reset event click
                $('#form-filter')[0].reset();
                table.ajax.reload();  //just reload table
            });

        });


    });



    function import_frm(){


        $.confirm({
            title: false,
            content: 'url:<?php echo base_url("job/import_frm");?>',
            onContentReady: function () {
                // when content is fetched & rendered in DOM
                //alert('onContentReady');
                //var self = this;
              /* this.buttons.ok.disable();
                this.$content.find('.btn').click(function(){
                    self.$content.find('form').val('Chuck norris');
                    self.buttons.ok.enable();
                });*/


            },
            contentLoaded: function(data, status, xhr){
                // when content is fetched
                //self.buttons.ok.enable();
                //alert('contentLoaded: ' + status);
            },
            onOpenBefore: function () {
                // before the modal is displayed.
                //alert('onOpenBefore');
            },
            onOpen: function () {
                // after the modal is displayed.
                //alert('onOpen');
            },
            onClose: function () {
                // before the modal is hidden.
                //alert('onClose');
            },
            onDestroy: function () {
                // when the modal is removed from DOM
                //alert('onDestroy');
            },
            onAction: function (btnName) {
                // when a button is clicked, with the button name
                //alert('onAction: ' + btnName);
            },
            buttons: {

                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var self = this;
                        var user_file = this.$content.find('#user_file').val();
                        if(!user_file){
                            $.alert('please select file');
                            return false;
                        }

                        this.$content.find('form#uploadForm').ajaxSubmit({
                            target:   '#targetLayer',
                            beforeSubmit: function() {
                                $("#progress-bar").width('0%');
                            },
                            uploadProgress: function (event, position, total, percentComplete){
                                $("#progress-bar").width(percentComplete + '%');
                                $("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
                            },
                            success:function (){
                                $('#loader-icon').hide();
                                $.alert("File uploaded successful!");
                                self.$$cancel.trigger('click');
                            },
                            resetForm: true
                        });


                        return false;
                    }
                },
                cancel: function () {
                    //close
                },
            }
        });

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
                            <label class="control-label col-md-3">Middle Name</label>
                            <div class="col-md-9">
                                <input name="detail[middle_name]" placeholder="Middle Name" class="form-control" type="text">
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
                            <label class="control-label col-md-3">Address</label>
                            <div class="col-md-9">
                                <input name="detail[address]" placeholder="Address" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Contact Number</label>
                            <div class="col-md-9">
                                <input name="detail[phone]" placeholder="Contact Number" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Contact Number2</label>
                            <div class="col-md-9">
                                <input name="detail[phone2]" placeholder="Contact Number2" class="form-control" type="text">
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

                        <!--div class="form-group">
                            <label class="control-label col-md-3">Roles</label>
                            <div class="col-md-9">

                                <?php
                        /*foreach($groups as $value){
                            echo '<div class="checkbox">';
                            echo '<label><input type="checkbox" name="group_ids[]"  value="'.$value->id.'"> '.$value->name."</label>";
                            echo '</div>';
                        }*/
                        ?>

                                <span class="help-block"></span>
                            </div>
                        </div -->
                        <input type="hidden" name="group_ids[]" value="<?php echo PARENT; ?>">

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