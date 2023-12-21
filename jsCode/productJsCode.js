const GridDiv = document.getElementById("productGrid");
var gridOptions = {
    columnDefs:[
        {headerName: '',
            field: 'removeIcon',
            cellRenderer: params =>  {
                return '<a href="#" ><i class="fas fa-trash remove-icon"></i></a>';
            },
            width:10
            ,
            onCellClicked: params => {
                if (params.event.target.classList.contains('remove-icon')) {
                    removeRowAndDatabaseRecord(params.data);
                }
            }
        },
        {headerName: 'Edit Customer', field: 'edit',
            cellRenderer: params => {
                return `<a href="#" ><i class="fas fa-solid fa-user-pen"></i></a>`;
            },
            width:10
            ,
            onCellClicked: params => {
                if (params.event.target.classList.contains('fa-user-pen')) {
                    showProductData(params.data);
                }
            }
        },
        {headerName: 'ID', field: 'id',editable: false},
        {headerName: 'Product Image', field: 'product_image',editable: true,
            cellRenderer: function(params) {
                return '<img src="' + params.value + '" style="height: 50px; width: 50px;" />';
            }
        },
        {headerName: 'Product Name', field: 'product_name',editable: true},
        {headerName: 'Description', field: 'description',editable: true},
        {headerName: 'Price', field: 'price',editable: true},
        {headerName: 'Cost Price', field: 'cost_price',editable: true},
        {headerName: 'Available Quantity ', field: 'available_quantity',editable: true},
        {headerName: 'Tax Rate ', field: 'tax_rate',editable: true}
    ],
    rowSelection : 'single',
    // onCellEditingStopped : cellEditingStopped,
};

$(document).ready(function (){
    new agGrid.Grid(GridDiv, gridOptions);
    $.ajax({
        url: '/ecommerce/productsPages/getProducts.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Use the data variable (contains the JSON data) here
            console.log('data', data);
            gridOptions.api.setRowData(data);
            gridOptions.api.refreshCells();
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
});

function showProductData(ProductData){
    modalContent.innerHTML = '';
    var content = `<form action="updateProduct.php" method="post">
                        <div class="row ">
                             <div class="col-lg-3 mt-2">
                                  <div class="text-center">
                                       <img src=${ProductData.product_image} onclick="triggerClick();" id="uploadedImage" name ="product_image" style="width: 200px; height: 165px;">
                                        <!-- File input for image upload -->
                                        <input type="file" name="product_image" id="product_image" onchange="displayImage(this);" class="mt-3" style="display: none;">
                                  </div>
                             </div>
                             <div class="col-lg-9">
                              <div class="row">
                                    <div class="col-lg-6">
                                        <input type="hidden" class="form-control " name="id" value = ${ProductData.id}  >
                                        <label for="name" class="form-label">Product Name:</label>
                                        <input type="text" class="form-control " name="product_name" value = ${ProductData.product_name} >
                                        <label for="phone1" class="form-label">Description:</label>
                                        <input type="text" class="form-control " name="description" value = ${ProductData.description}>
                                        <label for="phone2" class="form-label">Price:</label>
                                        <input type="text" class="form-control " name="price" value = ${ProductData.price} >
                
                                    </div>
                                    <div class="col-lg-6" >
                                        <label for="fb_account" class="form-label">Cost Price :</label>
                                        <input type="text" class="form-control " name="cost_price" value = ${ProductData.cost_price}>
                                        <label for="ins_account" class="form-label">Available Quantity:</label>
                                        <input type="text" class="form-control " name="quantity" value = ${ProductData.available_quantity}>
                                        <label for="tax_rate" class="form-label">Tax_Rate:</label>
                                         <input type="text" class="form-control " name="tax_rate" value=${ProductData.tax_rate}>
                                        <div class="d-flex justify-content-end">
                                             <button type="submit" name="submit" value="Submit" class="btn btn-primary my-3">Update</button>                
                                        </div>
                                    </div>
                               </div>
                             
                            </div>                         
                        </div>          
                    </form>`;
    modalContent.innerHTML += content;
    $('#productModal').modal('show');
}
function removeRowAndDatabaseRecord(ProductData){
    gridOptions.api.applyTransaction({remove: [ProductData]});
    deleteRecordInDatabase(ProductData.id);
}
function deleteRecordInDatabase(productId){
    $.ajax({
        type: 'GET',
        url: '/ecommerce/productsPages/removeProduct.php',
        data: { id: productId },
        success: function (response) {
            console.log('productId',productId)
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

function addNewProduct(){
    $('#newProductModal').modal('show');
}
