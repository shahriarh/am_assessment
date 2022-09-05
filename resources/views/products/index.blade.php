@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Products</h2>
            </div>
            <div class="pull-right">
                @can('product-create')
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Create New Product</button>
                {{-- <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a> --}}
                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button> --}}
                @endcan
                
                
                <div class="modal fade product_create" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <form id="addProductForm">
                          <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" name="name" class="form-control" id="name">
                          </div>
                          <div class="form-group">
                            <label for="message-text" class="col-form-label">Category:</label>
                            {{-- <textarea class="form-control" id="message-text"></textarea> --}}
                            <select class="form-select" name="category_id" id="category_id" aria-label="Default select example">
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
                        <button type="button" class="btn btn-primary btn_Product_add">Save</button>
                      </div>
                    </div>
                  </div>
                </div>
                @include('products.update')
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered product_data_table">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Category</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($products as $product)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $product->name }}</td>
	        <td>{{ $product->category->name }}</td>
	        <td>
                <form action="" method="POST">
                    <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a>
                    @can('product-edit')
                    <a class="btn btn-primary update_product_Form" 
                    {{-- href="{{ route('products.edit',$product->id) }}" --}}
                        data-toggle="modal" data-target="#upexampleModal" 
                        data-id="{{$product->id}}"
                        data-name="{{$product->name}}"
                        data-category="{{$product->category->name}}"
                        >Edit</a>
                    @endcan
                    @csrf
                    @method('DELETE')
                    @can('product-delete')
                    <button type="submit" class="btn btn-danger delete_product">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>
    {!! $products->links() !!}

    <script>
         $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
    </script>
    <script>

        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('New message to ' + recipient)
            modal.find('.modal-body input').val(recipient)
        })
    

        $(document).ready(function () {
            $(document).on('click','.btn_Product_add',function(e){
                e.preventDefault();
                let name = $('#name').val();
                let category_id = $('#category_id').val();
                // console.log(name+category_id);
                $.ajax({
                    url:"{{route('products.store')}}",
                    method:'post',
                    data:{name:name,category_id:category_id},
                    success:function(res){
                        if(res.status=='success'){
                            $('#addProductForm')[0].reset();
                            $('.product_create').modal('hide');
                            $('.product_data_table').load(location.href+' .product_data_table');
                        }
                    },error:function(err){
                        let error = err.responseJSON;
                        $.each(error.errors,function(index,value){
                            $('.errorMessage').append('<span class="text-danger">'+value+'</span>'+'<br>');
                        })
                    }
                });
            });

            //show product value in update form
            $(document).on('click','.update_product_Form',function(){
                let id = $(this).data('id');
                // alert(id)
                let name = $(this).data('name');
                let category = $(this).data('category');

                $('#up_id').val(id);
                $('#up_name').val(name);
                $('#up_category_id').val(category); 
            });

            // update form data
            $(document).on('click','.btn_Product_up',function(e){
                e.preventDefault();
                console.log();
                let up_id = $('#up_id').val();
                let up_name = $('#up_name').val();
                let up_category_id = $('#up_category_id').val();
                // console.log(name+category_id);
                $.ajax({
                    url:"{{route('products.update',$product->id)}}",
                    method:'PUT',
                    data:{up_name:up_name,up_category_id:up_category_id},
                    success:function(res){
                        if(res.status=='success'){
                            $('#updateProductForm')[0].reset();
                            $('.product_update').modal('hide');
                            $('.product_data_table').load(location.href+' .product_data_table');
                        }
                    },error:function(err){
                        let error = err.responseJSON;
                        $.each(error.errors,function(index,value){
                            $('.errorMessage').append('<span class="text-danger">'+value+'</span>'+'<br>');
                        })
                    }
                });
            });

            //delete form data
           
                $(document).on('click','.delete_product',function(e){
                e.preventDefault();
                let product_id = $(this).data('id');
                alert(product_id)
                // console.log(name+category_id);
                if(confirm('Are you to delete product?')){
                $.ajax({
                    url:"{{url('products/'.$product->id)}}",
                    method:'DELETE',
                    data:{product_id:product_id},
                    success:function(res){
                        if(res.status=='success'){
                            $('.product_data_table').load(location.href+' .product_data_table');
                        }
                    }
                });
            }
            });
            
        });
    // }

    </script>
@endsection
