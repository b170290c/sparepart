<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Deleting...</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="products_delete.php">
                <input type="hidden" class="prodid" name="id">
                <div class="text-center">
                    <p>DELETE PRODUCT</p>
                    <h2 class="bold name"></h2>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
              </form>
            </div>
        </div>
    </div>
</div>

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
              <form class="form-horizontal" method="POST" action="products_edit.php">
                <input type="hidden" class="prodid" name="id">
                <div class="form-group">
                  <label for="edit_name" class="col-sm-1 control-label">Name</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="edit_name" name="name" >
                  </div>

                  <label for="edit_category" class="col-sm-1 control-label">Brand</label>

                  <div class="col-sm-5">
                    <select class="form-control" id="edit_category" name="category">
                      <option selected id="catselected"></option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                 <label for="edit_recdate" class="col-sm-1 control-label">Date Received</label>

                  <div class="col-sm-5">
                    <input type="Date" class="form-control" id="edit_recdate" name="recdate" required>
                  </div>
                  
                  <label for="edit_vendor" class="col-sm-1 control-label">Vendor</label>

                  <div class="col-sm-5">
                    <select class="form-control" id="edit_vendor" name="vendor">
                      <option selected id="venselected"></option>
                    </select>
                  </div>
                </div>
                
                <div class="form-group">
                  

                  <label for="edit_price" class="col-sm-1 control-label">Price</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="edit_price" name="price">
                  </div>

                   <label for="edit_qnty" class="col-sm-1 control-label">Ready Stock</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="edit_qnty" name="qnty">
                  </div>
                 
                </div>

                 <div class="form-group">
                
                  
                  <label for="edit_minqnty" class="col-sm-1 control-label">Minimun Quantity</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="edit_minqnty" name="minqnty" required>
                  </div>

                  <label for="edit_minqnty1" class="col-sm-1 control-label">MLS</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="edit_minqnty1" name="minqnty1" required>
                  </div>

                </div>

                <div class="form-group">
                
                  
                  <label for="edit_roq" class="col-sm-1 control-label">ROQ</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="edit_roq" name="roq" required>
                  </div>

                  <label for="edit_leadtime" class="col-sm-1 control-label">Lead Time(Days)</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="edit_leadtime" name="leadtime" required>
                  </div>

                </div>

                <div class="form-group">
                  <label for="edit_idLoc" class="col-sm-1 control-label">ID Location</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="edit_idLoc" name="idLoc">
                  </div>

                   <label for="edit_noSAP" class="col-sm-1 control-label">SAP Number</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="edit_noSAP" name="noSAP">
                  </div>
                </div>

                 <div class="form-group">
                    
            

                  <label for="edit_noParts" class="col-sm-1 control-label">Parts Number</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="edit_noParts" name="noParts">
                  </div>

                </div>
        

                <p><b>Description</b></p>
                <div class="form-group">
                  <div class="col-sm-12">
                    <textarea id="editor2" name="description" rows="10" cols="80"></textarea>
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

