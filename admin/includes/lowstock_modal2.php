
<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Edit Product</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="lowstock_edit.php?edit=true">
                <input type="hidden" class="prodid" name="id">
              
                <div class="form-group">
                  
                  <label for="edit_qnty" class="col-sm-1 control-label" >Current Quantity</label>

                  <div class="col-sm-5">
                    <input type="textarea" class="form-control" id="edit_qnty" disabled>
                    <input type="hidden" class="form-control" id="edit_qnty2" name="qnty">
                    <input type="hidden" class="form-control" id="edit_qnty3" name="ownqnty">
                  </div>

                  <label for="edit_qnty1" class="col-sm-1 control-label">New Quantity</label>
                  <div class="col-sm-5">
                    <input type="textarea" class="form-control" id="edit_qnty1" name="qnty1">
                  </div>
                </div>


            



              
                  
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>

