@extends('layouts.master')
@section('title', 'Item')

@section('script')
<script>
  var rolesCheck = false;
</script>
  @if (Auth::check())
      <script>
         var loggedIn = true;
      </script>
      @if (auth()->user()->hasRole('Admin'))
      <script>
        rolesCheck = true;
     </script>
      @else
          
      @endif
  @else
      <script>
        var loggedIn = false;
      </script>
  @endif
  <script>
    console.log(loggedIn);
    console.log(rolesCheck);

</script>
    <script src="{{ asset('table/item-table.js') }}"></script>
    <script src="{{ asset('crud/items/add.js') }}"></script>
    <script src="{{ asset('crud/items/edit.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#satuan').select2({
                dropdownParent: $("#addItemModal"),
                placeholder: "-- Select Satuan --",
            });
            $('#edit_satuan').select2({
                dropdownParent: $("#editItemModal"),
                placeholder: "-- Select Satuan --",
            });
        });
      </script>
@endsection
@section('content')
<div class="max-w-7xl mx-auto p-6 lg:p-8"  style="margin-top: 50px">
    <div class="text-center mt-20">
        {{-- <h1 class="fs-1 text-white  fw-bolder">Mifa Abiyyu </h1> --}}
    </div>

    <div class="">
        <div class=" ">
            <div  class="p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none  motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                <div class="">
                    <div class="flex ">
                        <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <h2 class="mt-3  text-xl font-semibold text-gray-900 ">&nbsp; Data Item</h2>
                    </div>
                    
                    <div class="table-responsive">
                        <div class="d-flex justify-content-end">
                          @auth
                          <button  class="text-end bg-success p-2 text-white rounded " data-bs-toggle="modal" data-bs-target="#addItemModal">Add Item</button>
                          @endauth
                        </div>
                        <table class="table table-striped" id="item_table">
                            <thead>
                                <tr>
                                    <th scope="col">Images</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
                                  </tr>
                              </thead>
                              <tbody>
                             
                              </tbody>
                        </table>
                    </div>
                  
                </div>

               
            </div>
        </div>
    </div>

    <div class="modal fade" id="addItemModal"  role="dialog" aria-labelledby="addItemModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title fw-bolder" id="exampleModalLongTitle">Add Item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="add_item" method="POST">
                    @csrf
                    <div class="row fv-row mb-3">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Image </label>
                          <input type="file" class="form-control" accept=".jpg,.jpeg,.png" id="inputEmail4" name="image" placeholder="Image">
                        </div>
                        <div class="form-group col-md-6">
                          <label class="required" for="inputPassword4">Name <span class="" style="color: red">*</span></label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="row fv-row mb-3">
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">SKU <span class="" style="color: red">*</span></label>
                            <input type="text" class="form-control" id="sku" name="sku" placeholder="SKU">
                          </div>
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Status <span class="" style="color: red">*</span></label>
                          <select name="status" class="form-control "  id="status">
                            <option value="" selected disabled>-- Select Status --</option>
                            <option value="1">Active</option>
                            <option value="0">Non Active</option>
                          </select>
                        </div>
                      
                    </div>
                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Category <span class="" style="color: red">*</span></label>
                          <select name="category" class="form-control "  id="category">
                            <option value="" selected disabled>-- Select Category --</option>
                            @foreach ($category as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputPassword4">Stock</label>
                          <input type="text" class="form-control" id="stock" value="0" name="stock" placeholder="Stock">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-group col-md-12">
                          <label for="inputEmail4">Satuan <span class="" style="color: red">*</span></label>
                          <select name="satuan[]" style="width: 100%" multiple class="form-control "  id="satuan">
                            @foreach ($satuan as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn text-gray-900 btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" data-submit-item="submit" class="btn text-gray-900 btn-primary">Save</button>
                </div>
            </form>
          </div>
        </div>
    </div>

    <div class="modal fade" id="editItemModal"  role="dialog" aria-labelledby="editItemModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title fw-bolder" id="exampleModalLongTitle">Edit Item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="edit_item" method="POST">
                    @csrf
                    <div class="row fv-row mb-3">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Image </label>
                          <div class="input-group">
                            <input type="file" class="form-control" accept=".jpg,.jpeg,.png" id="inputEmail4" name="image" placeholder="Image">
                            <a class="btn btn-primary" id="imagesData" target="_blank" href="javascript:void(0)">View File</a>
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                          <label class="required" for="inputPassword4">Name <span class="" style="color: red">*</span></label>
                          <input type="text" class="form-control" id="edit_name" name="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="row fv-row mb-3">
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">SKU <span class="" style="color: red">*</span></label>
                            <input type="text" class="form-control" id="edit_sku" name="sku" placeholder="SKU">
                          </div>
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Status <span class="" style="color: red">*</span></label>
                          <select name="status" class="form-control "  id="edit_status">
                            <option value="" selected disabled>-- Select Status --</option>
                            <option value="1">Active</option>
                            <option value="0">Non Active</option>
                          </select>
                        </div>
                      
                    </div>
                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Category <span class="" style="color: red">*</span></label>
                          <select name="category" class="form-control "  id="edit_category">
                            <option value="" selected disabled>-- Select Category --</option>
                            @foreach ($category as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputPassword4">Stock</label>
                          <input type="text" class="form-control" id="edit_stock" value="0" name="stock" placeholder="Stock">
                        </div>
                    </div>
                    <div class="row mb-3">
                      <div class="form-group col-md-12">
                        <label for="inputEmail4">Satuan <span class="" style="color: red">*</span></label>
                        <select name="satuan[]" style="width: 100%" multiple class="form-control "  id="edit_satuan">
                          @foreach ($satuan as $data)
                          <option value="{{ $data->id }}">{{ $data->name }}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn text-gray-900 btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" data-submit-edititem="submit" class="btn text-gray-900 btn-primary">Update</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    <div class="modal fade" id="showItemModal"  role="dialog" aria-labelledby="showItemModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title fw-bolder" id="exampleModalLongTitle">Detail Item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row fv-row mb-3">
                <div class="form-group col-md-6">
                  <label class="required" for="inputPassword4">Name</label>
                  <h4 id="detail_name"></h4>
                  {{-- <input type="text" class="form-control form-control-transparent" id="detail_name" name="name" placeholder="Name"> --}}
                </div>
                <div class="form-group col-md-6">
                  <label for="inputPassword4">Stock</label>
                  <h4 id="detail_stock"></h4>
                  {{-- <input type="text" class="form-control form-control-transparent" id="detail_stock" value="0" name="stock" placeholder="Stock"> --}}
                </div>
            </div>
              <table class="table table-striped" id="detail_item">
                <thead>
                  <tr>
                      <th style="min-width: 200px">Date</th>
                      <th style="min-width: 200px">Code</th>
                      <th style="min-width: 200px">Type</th>
                      <th style="min-width: 200px">Qty</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn text-gray-900 btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

          </div>
        </div>
    </div>

     
</div>
@endsection