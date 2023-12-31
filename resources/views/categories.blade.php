@extends('layouts.master')
@section('title', 'Category')

@section('script')
    <script src="{{ asset('table/category-table.js') }}"></script>
    <script src="{{ asset('crud/categories/add.js') }}"></script>
    <script src="{{ asset('crud/categories/edit.js') }}"></script>
    <script>
        // $(document).ready(function() {
        //     $('#category').select2({
        //         dropdownParent: $("#addCategoryModal")
        //     });
        // });
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
                        <h2 class="mt-3  text-xl font-semibold text-gray-900 ">&nbsp; Data Category Item</h2>
                    </div>
                    
                    <div class="table-responsive">
                        <div class="d-flex justify-content-end">
                            <button  class="text-end bg-success p-2 text-white rounded " data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Category</button>
                        </div>
                        <table class="table table-striped" id="category_table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Name</th>
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

    <div class="modal fade" id="addCategoryModal"  role="dialog" aria-labelledby="addCategoryModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title fw-bolder" id="exampleModalLongTitle">Add Item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="add_category" method="POST">
                    @csrf
                    <div class="row fv-row mb-3">
                        <div class="form-group">
                          <label class="required" for="inputPassword4">Code <span class="" style="color: red">*</span></label>
                          <input type="text" class="form-control" id="code" name="code" placeholder="Code">
                        </div>
                    </div>
                    <div class="row fv-row mb-3">
                        <div class="form-group">
                          <label class="required" for="inputPassword4">Name <span class="" style="color: red">*</span></label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Name">
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

    <div class="modal fade" id="editCategoryModal"  role="dialog" aria-labelledby="editCategoryModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title fw-bolder" id="exampleModalLongTitle">Edit Categories</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="edit_category" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row fv-row mb-3">
                        <div class="form-group">
                          <label class="required" for="inputPassword4">Code <span class="" style="color: red">*</span></label>
                          <input type="text" class="form-control" id="edit_code" name="code" placeholder="Code">
                        </div>
                    </div>
                    <div class="row fv-row mb-3">
                        <div class="form-group">
                          <label class="required" for="inputPassword4">Name <span class="" style="color: red">*</span></label>
                          <input type="text" class="form-control" id="edit_name" name="name" placeholder="Name">
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

     
</div>
@endsection