<div class="container_list" >

    <button class="btn btn-success" onclick="add_menu()"><i class="glyphicon glyphicon-plus"></i>Add</button>
    <button class="btn btn-default" onclick="reloadTable()"><i class="glyphicon glyphicon-refresh"></i>Reload</button>
    <button id="deleteList" class="btn btn-danger" style="display: none;" onclick="deleteList()"><i class="glyphicon glyphicon-trash"></i>Delete list</button>
    <br />
    <br />
    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><input type="checkbox" id="check-all"></th>
                <th>Name</th>
                <th>Parent</th>
                <th>Url</th>
                <th>Icon</th>
                <th>Sort by</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Parent</th>
                <th>Url</th>
                <th>Icon</th>
                <th>Sort by</th>
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
        dom: 'lBfrtip',
        buttons: [
            {
                className: 'buttons-alert',
                "text": "Export csv",
                action: function (e, dt, node, config)
                {
                    /*var SearchData = table.search();
                    var OrderData = table.order();
                    alert("Test Data for Searching: " + SearchData);
                    alert("Test Data for Ordering: " + OrderData);*/
                    window.location.href = 'menus/export';
                    exit;
                }
            }
        ],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "menus/ajax_list",
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
    //set input/textarea/select event when change value, remove class error and remove text help block
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
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

function add_menu()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add'); // Set Title to Bootstrap modal title
}

function edit_menu(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "menus/ajax_edit/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="menu_id"]').val(data.menu_id);
            $('[name="name"]').val(data.name);
            $('[name="url"]').val(data.url);
            $('[name="icon"]').val(data.icon);
            $('[name="sort_by"]').val(data.sort_by);
            $('[name="parent_id"]').val(data.parent_id);
            $.each(data.group_ids, function(i, val){
                $('.checkbox').find( 'input[value="' + val.group_id + '"]').prop('checked', 'checked');
            });
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
        url = "menus/ajax_add";
    } else {
        url = "menus/ajax_update";
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
            {
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
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

function delete_menu(id)
{
    if(confirm('Are you sure to remove the row?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "menus/ajax_delete/"+id,
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
                url: "menus/ajax_list_delete",
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
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                      <div class="form-group">
                          <div class="col-md-9">
                              <input name="menu_id" class="form-control" type="hidden">
                              <span class="help-block"></span>
                          </div>
                      </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Name</label>
                            <div class="col-md-9">
                                <input name="name" placeholder="Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Url</label>
                            <div class="col-md-9">
                                <input name="url" placeholder="Url" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Icon</label>
                            <div class="col-md-9">
                                <input name="icon" placeholder="Icon" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Sort by</label>
                            <div class="col-md-9">
                                <input name="sort_by" placeholder="Sort by" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Parent Menu</label>
                            <div class="col-md-9">
                                <select name="parent_id" class="form-control">
                                    <option value="">--Select Menu--</option>
                                    <?php
                                    foreach($list as $value){
                                      echo '<option value="'.$value->menu_id.'">'.$value->name.'</option>';
                                    }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Roles</label>
                            <div class="col-md-9">

                                    <?php
                                    foreach($groups as $value){
                                        echo '<div class="checkbox">';
                                        echo '<label><input type="checkbox" name="group_ids[]"  value="'.$value->id.'"> '.$value->name."</label>";
                                        echo '</div>';
                                    }
                                    ?>

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
