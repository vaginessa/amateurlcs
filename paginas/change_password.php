<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">New Password</h4>
        </div>
        <div class="modal-body">
            <form class='form form-horizontal'>
                <div class="form-group ">
                    <label for="inputEmail3" class="col-md-4 control-label">New Password</label>
                    <div class="col-md-5">
                        <input id='pass_1' type="password" class="form-control" >
                    </div>
                </div>
                <div class="form-group ">
                    <label for="inputEmail3" class="col-md-4 control-label">Confirm Password</label>
                    <div class="col-md-5">
                        <input id='pass_2' type="password" class="form-control">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss='modal' class="btn default">
                Close
            </button>
            <button  type='button' data-dismiss='modal' id='savepass' class='btn btn-success'>
                Save
            </button>
        </div>
    </div>
</div>
<script>
    $("#savepass").on('click', function() {
        if ($('#pass_1').val() == $('#pass_2').val()) {
            $.ajax({
                url : './paginas/change_password2.php',
                type : 'POST',
                data : {
                    password : $('#pass_1').val()
                },
                success : function() {
                    window.location.href = 'login';
                }
            })
        } else {
            alert("Passwords do not match!");
        }
    })
</script>