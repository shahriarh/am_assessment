<div class="modal fade product_update" id="upexampleModal" tabindex="-1" role="dialog" aria-labelledby="updateexampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      
      <div class="modal-content">
        <div class="modal-header">
         
          <div class="errorMessage">

          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="updateProductForm">
          
            <input type="hidden" name="" id="up_id">
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Name:</label>
              <input type="text" name="up_name" class="form-control" id="up_name">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Category:</label>
              {{-- <textarea class="form-control" id="message-text"></textarea> --}}
              <select class="form-select" name="up_category_id" id="up_category_id" aria-label="Default select example">
                  <option selected>Open this select menu</option>
                  @foreach ($categories as $item)
                  <option value="{{$item->id}}">{{$item->name}}</option>
                  @endforeach
                  
                </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary btn_Product_add">Save</button> --}}
          <button type="button" class="btn btn-primary btn_Product_up">Update</button>
        </div>
      </div>
    </div>
  </div>