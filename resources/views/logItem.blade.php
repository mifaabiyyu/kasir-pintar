@extends('layouts.master')
@section('title', 'Category')

@section('script')
    <script>
        var kode;
        var dataItem = {!! json_encode($items) !!};
        var deletedData = [];
    </script>
    <script src="{{ asset('table/log-table.js') }}"></script>
    <script src="{{ asset('crud/logitem/add.js') }}"></script>
    <script src="{{ asset('crud/logitem/edit.js') }}"></script>
    <script>
      $(document).ready(function() {
          var type = 'supplier';
          var typeEdit = '';
            $('#vendor_id').select2({
                dropdownParent: $("#addLogModal"),
                placeholder: "-- Select Vendor --",
                ajax: {
                type: "get",
                url:
                    route('vendor-data.index'),
                dataType: "json",
                delay: 0,
                data: function (params) {
                    return {
                        type,
                    };
                },
                processResults: function (res) {
                    return {
                        results: $.map(res.data, function (item) {
                            return {
                                text: item.name,
                                id: item.id,
                            };
                        }),
                    };
                },
                cache: true,
              },
            });

            $('#edit_vendor_id').select2({
                dropdownParent: $("#editLogModal"),
                placeholder: "-- Select Vendor --",
                ajax: {
                type: "get",
                url:
                    route('vendor-data.index'),
                dataType: "json",
                delay: 0,
                data: function (params) {
                    return {
                       type :typeEdit,
                    };
                },
                processResults: function (res) {
                    return {
                        results: $.map(res.data, function (item) {
                            return {
                                text: item.name,
                                id: item.id,
                            };
                        }),
                    };
                },
                cache: true,
              },
            });

            $('input[type=radio][name=type]').change(function() {
              if (this.value == "Incomming Transaction") {
                  type = "supplier";
              } else {
                  type = "customer";
              }
            });

            $('input[type=radio][name=typeEdit]').change(function() {
              if (this.value == "Incomming Transaction") {
                  typeEdit = "supplier";
              } else {
                  typeEdit = "customer";
              }
            });


            var dataTable = $('#detail_item').DataTable({
              paging: false,
              ordering: false,
              "searching": false,
              // scrollY: "500px",
              scrollCollapse: true,
            });
        
            var dataTableEdit = $('#edit_detail_item').DataTable({
              paging: false,
              ordering: false,
              "searching": false,
              // scrollY: "500px",
              scrollCollapse: true,
            });
        
            dataTable.row.add([
                        `<select name="item[]" id="item[]" class="form-control">
                                    <option selected disabled>-- Select Item --</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>`,
                          ` <input type="text" class="form-control" name="qty[]" id="qty">`,
                          `   <a href="javascript:void(0)" class="btn btn-icon btn-bg-light btn-danger btn-active-color-secondary btn-sm deleteData">
                                  <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                  <span class="svg-icon svg-icon-3">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                          <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                          <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                          <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                      </svg>
                                  </span>
                                  <!--end::Svg Icon-->
                              </a>`,
                      ])
                      .draw(false);

              $('#addItem').on('click', function (){
                dataTable.row.add([
                  `<select name="item[]" id="item[]" class="form-control">
                                    <option selected disabled>-- Select Item --</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>`,
                          ` <input type="text" class="form-control" name="qty[]" id="qty">`,
                          `   <a href="javascript:void(0)" class="btn btn-icon btn-bg-light btn-danger btn-active-color-secondary btn-sm deleteData">
                                  <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                  <span class="svg-icon svg-icon-3">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                          <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                          <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                          <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                      </svg>
                                  </span>
                                  <!--end::Svg Icon-->
                              </a>`,
                ]).draw(false)
              });

              $('#editAddItem').on('click', function (){
                dataTableEdit.row.add([
                  `<select name="item[]" id="item[]" class="form-control">
                                    <option selected disabled>-- Select Item --</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>`,
                          `<input type="hidden" name="id_detail[]" value="0" id="id_detail"> <input type="text" class="form-control" name="qty[]" id="qty">`,
                          `   <a href="javascript:void(0)" class="btn btn-icon btn-bg-light btn-danger btn-active-color-secondary btn-sm deleteData">
                                  <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                  <span class="svg-icon svg-icon-3">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                          <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                          <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                          <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                      </svg>
                                  </span>
                                  <!--end::Svg Icon-->
                              </a>`,
                ]).draw(false)
              });

              $("#detail_item tbody").on("click", ".deleteData", function () {
                  let thisData = $(this).parents("tr");
                  Swal.fire({
                      text: "Are you sure you want to delete item ?",
                      icon: "warning",
                      showCancelButton: true,
                      buttonsStyling: false,
                      confirmButtonText: "Yes, activate !",
                      cancelButtonText: "No, cancel",
                      customClass: {
                          confirmButton: "btn fw-bold btn-danger",
                          cancelButton: "btn fw-bold btn-active-light-primary",
                      },
                  }).then(function (result) {
                      if (result.value) {
                          dataTable.row(thisData).remove().draw(false);

                          toastr.success("item deleted successfully !", options);
                      }
                  });
              });
              $("#edit_detail_item tbody").on("click", ".deleteData", function () {
                let thisData = $(this).parents("tr");
                let idDetail = $(this).data("id");
                Swal.fire({
                    text: "Are you sure you want to delete item ?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, activate !",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary",
                    },
                }).then(function (result) {
                    if (result.value) {
                        dataTableEdit.row(thisData).remove().draw(false);
                        deletedData.push(idDetail);
                        $('#deleted_data').val(JSON.stringify(deletedData));
                        toastr.success("item deleted successfully !", options);
                    }
                });
    });


      $("body").on("click", "#edit-data", function () {
        kode = $(this).data("id");
        // showUrl.replace(":id", kode);
        $.ajax({
            type: "GET",
            url: route("log-data.show", kode),

            success: function (response) {
              // console.log(response);
               typeEdit = response.data.get_vendor.type;
              $("input[name=typeEdit][value='" + response.data.type + "']").attr(
                  "checked",
                  "checked"
              );
                $("#edit_date").val(response.data.date);
                $("#edit_title").html("Edit Transaction " + response.data.code);
               
        
                var $newOption = $("<option selected='selected'></option>")
                    .val(response.data.vendor)
                    .text(response.data.get_vendor.name);
                $("#edit_vendor_id").append($newOption).trigger("change");
                $("#edit_code").val(response.data.code);

                dataTableEdit.rows().remove().draw();

                response.data.get_detail.forEach((element, index) => {
                  let satuans = "";
                  dataItem.forEach((item) => {
                    satuans +=  `<option value="${item.id}"  ${ item.id == element.item_id ? 'selected' : '' }>${item.name}</option>`;
                  });
                  dataTableEdit.row.add([
                    `<select name="item[]" id="editItem${index}" class="form-control">
                                      <option selected disabled>-- Select Item --</option>

                                  </select>`,
                            `   <input type="hidden" name="id_detail[]" value="${element._id}" id="id_detail"><input type="text" class="form-control" name="qty[]" id="qty" value="${element.qty}"">`,
                            `   <a href="javascript:void(0)" data-id="${element._id}" class="btn btn-icon btn-bg-light btn-danger btn-active-color-secondary btn-sm deleteData">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>`,
                  ]).draw(false);
                    $('#editItem' + index +'').html(satuans);
                });
            },
            error: function (error) {
                Swal.fire({
                    text: error.responseJSON.message,
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                });
            },
        });
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
                        <h2 class="mt-3  text-xl font-semibold text-gray-900 ">&nbsp; Data Category Item</h2>
                    </div>
                    
                    <div class="table-responsive">
                        <div class="d-flex justify-content-end">
                            <button  class="text-end bg-success p-2 text-white rounded " data-bs-toggle="modal" data-bs-target="#addLogModal">Add Category</button>
                        </div>
                        <table class="table table-striped" id="log_table">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    {{-- <th scope="col">Code</th> --}}
                                    <th scope="col">Vendor</th>
                                    <th scope="col">Type</th>
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

    <div class="modal fade" id="addLogModal"  role="dialog" aria-labelledby="addLogModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title fw-bolder" id="exampleModalLongTitle">Add Transaction</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="add_log_item" method="POST">
                    @csrf
                  <div class="row fv-row mb-3">
                    <label class="required" for="inputPassword4">Type <span class="" style="color: red">*</span></label>
                    <div class="form-group col-md-3">
                      <div class="form-check">
                        <input class="form-check-input" checked type="radio" name="type" value="Incomming Transaction" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                          Incomming Transaction
                        </label>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" value="Outgoing Transaction" id="flexRadioDefault2">
                        <label class="form-check-label" for="flexRadioDefault1">
                          Outgoing Transaction
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="row fv-row mb-3">
                    <div class="form-group col-md-6">
                      <label class="required" for="inputPassword4">Date <span class="" style="color: red">*</span></label>
                      <input type="date" class="form-control" id="date" name="date" placeholder="Date">
                    </div>
                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Vendor </label>
                        <select name="vendor" style="width: 100%; height:100%" class="form-control"  id="vendor_id">
                          <option ></option>
                        </select>
                      </div>
                  </div>
                  <div class="d-flex justify-content-end">
                    <a id="addItem" class=" btn btn-primary">Add</a>
                  </div>
                  <div class="row fv-row mb-3">
                      <table class="table table-striped" id="detail_item">
                        <thead>
                          <tr>
                              <th style="min-width: 400px">Item</th>
                              <th style="min-width: 300px">Qty</th>
                              {{-- <th style="min-width: 300px">Satuan</th> --}}
                              <th style="max-width: 50px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>
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

    <div class="modal fade" id="editLogModal"  role="dialog" aria-labelledby="addLogModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fw-bolder" id="edit_title">Edit Transaction</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <form id="edit_log_item" method="POST">
                  @csrf
                  @method('PUT')
                <div class="row fv-row mb-3">
                  <label class="required" for="inputPassword4">Type <span class="" style="color: red">*</span></label>
                  <div class="form-group col-md-3">
                    <div class="form-check">
                      <input class="form-check-input" checked type="radio" name="typeEdit" value="Incomming Transaction" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                        Incomming Transaction
                      </label>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="typeEdit" value="Outgoing Transaction" id="flexRadioDefault2">
                      <label class="form-check-label" for="flexRadioDefault1">
                        Outgoing Transaction
                      </label>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="deleted_data" id="deleted_data">
                <div class="row fv-row mb-3">
                  <div class="form-group col-md-6">
                    <label class="required" for="inputPassword4">Date <span class="" style="color: red">*</span></label>
                    <input type="date" class="form-control" id="edit_date" name="date" placeholder="Date">
                  </div>
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">Vendor </label>
                      <select name="vendor" style="width: 100%; height:100%" class="form-control"  id="edit_vendor_id">
                        <option ></option>
                      </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                  <a id="editAddItem" class=" btn btn-primary">Add</a>
                </div>
                <div class="row fv-row mb-3">
                    <table class="table table-striped" id="edit_detail_item">
                      <thead>
                        <tr>
                            <th style="min-width: 400px">Item</th>
                            <th style="min-width: 300px">Qty</th>
                            {{-- <th style="min-width: 300px">Satuan</th> --}}
                            <th style="max-width: 50px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
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