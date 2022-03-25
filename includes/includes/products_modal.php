<!-- Description -->
<div class="modal fade" id="description">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b><span class="name"></span></b></h4>
            </div>
            <div class="modal-body">
                <p id="desc"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Add New Product</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="products_add.php" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="name" class="col-sm-1 control-label">Name</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="name" name="name" required>
                  </div>

                  <label for="category" class="col-sm-1 control-label">Brand</label>

                  <div class="col-sm-5">
                    <select class="form-control" id="category" name="category" required>
                      <option value="" selected disabled> Select Brand</option>
                    </select>
                  </div>
                </div>

                <div class='form-group'>

                    <label for="vendor" class="col-sm-1 control-label">Vendor</label>

                  <div class="col-sm-5">
                    <select class="form-control" id="vendor" name="vendor" required>
                      <option value="" selected disabled> Select Vendor</option>
                    </select>
                  </div>

                  <label for="idLoc" class="col-sm-1 control-label">ID Location</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="idLoc" name="idLoc" required>
                  </div>
                  </div>

                  <div class="form-group">
                  <label for="noSAP" class="col-sm-1 control-label">SAP Number</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="noSAP" name="noSAP" required>
                  </div>

                  <label for="noParts" class="col-sm-1 control-label">Parts Number</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="noParts" name="noParts" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="qnty" class="col-sm-1 control-label">Quantity</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="qnty" name="qnty" required>
                  </div>

                 <!--  <label for="noSerial" class="col-sm-1 control-label">Serial Number</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="noSerial" name="noSerial" required>
                  </div> -->
                   </div>

                  <div class="form-group">
                  <label for="minqnty" class="col-sm-1 control-label">ROP</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="minqnty" name="minqnty" required>
                  </div>

                   <label for="minqnty1" class="col-sm-1 control-label">MLS</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="minqnty1" name="minqnty1" required>
                  </div>

                </div>

                   <div class="form-group">
                  <label for="roq" class="col-sm-1 control-label">ROQ</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="roq" name="roq" required>
                  </div>

                   <label for="leadtime" class="col-sm-1 control-label">Lead Time (Days)</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="leadtime" name="leadtime" required>
                  </div>

                </div>
              


                <div class="form-group">
                  <label for="price" class="col-sm-1 control-label">Price RM</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="price" name="price" required>
                  </div>

                   <div class="form-group">

                   <label for="recdate" class="col-sm-1 control-label">Date Received</label>

                  <div class="col-sm-5">
                    <input type="Date" class="form-control" id="recdate" name="recdate" required>
                  </div>
              </div>

                  <label for="photo" class="col-sm-1 control-label">Photo</label>

                  <div class="col-sm-5">
                    <input type="file" id="photo" name="photo">
                  </div>
                </div>
                <p><b>Description</b></p>
                <div class="form-group">
                  <div class="col-sm-12">
                    <textarea id="editor1" name="description" rows="10" cols="80" required></textarea>
                  </div>
                  
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Photo -->
<div class="modal fade" id="edit_photo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b><span class="name"></span></b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="products_photo.php" enctype="multipart/form-data">
                <input type="hidden" class="prodid" name="id">
                <div class="form-group">
                    <label for="photo" class="col-sm-3 control-label">Photo</label>

                    <div class="col-sm-9">
                      <input type="file" id="photo" name="photo" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="upload"><i class="fa fa-check-square-o"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>