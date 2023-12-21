const GridDiv = document.getElementById("ordersGrid");
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
        {headerName: 'order_id', field: 'order_id'},
        {headerName: 'customer_id ', field: 'customer_id'},
        {headerName: 'product_id ', field: 'product_id'},
        {headerName: 'tax_value', field: 'tax_value'},
        {headerName: 'shipping_price', field: 'shipping_price'},
        {headerName: 'product_price', field: 'product_price'},
        {headerName: 'total', field: 'total'},
        {headerName: 'order_date', field: 'order_date'}
    ],
    rowSelection : 'single',
};

$(document).ready(function (){
    new agGrid.Grid(GridDiv, gridOptions);
    $.ajax({
        url: '/ecommerce/orders/getOrders.php',
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

function removeRowAndDatabaseRecord(orderdata){
    gridOptions.api.applyTransaction({remove: [orderdata]});
    deleteRecordInDatabase(orderdata.order_id);
}

function deleteRecordInDatabase(orderId){
    $.ajax({
        type: 'GET',
        url: '/ecommerce/orders/deleteOrder.php',
        data: { order_id: orderId },
        success: function (response) {
            console.log('orderId',orderId)
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}


function getProductOptionValue(productid){
    $.ajax({
        type: "GET",
        url: "../productsPages/getProductInfo.php",
        data: { id : productid },
        dataType: 'json',
        success: function(data) {
            var productData = data[0];
            console.log('productData', productData)
            $("#cost_price").val(productData.cost_price);
            $("#tax_rate").val(productData.tax_rate);
            $("#productid").val(productData.id);
            $("#compare_quantity").val(productData.available_quantity);
            $("#product_price").val(productData.cost_price);
            $("#hidden_tax_rate").val(productData.tax_rate);
        },
        error: function(error) {
            console.error("Error:", error);
        }
    });
}

function validateInput(){
    var  available_quantityValue = document.getElementById("compare_quantity").value;
    console.log('available_quantityValue',available_quantityValue)

    var inputValue = document.getElementById("quantity").value;
    console.log('inputValue',inputValue)
    if (inputValue > available_quantityValue){
        console.log('inputValue > available_quantityValue',inputValue > available_quantityValue)
        console.log(document.getElementById("result"))
        document.getElementById("result").style.display = "block";
        document.getElementById("result").innerHTML = "Input is Not valid!";
    }else {
        console.log('inputValue > available_quantityValue',inputValue > available_quantityValue)
        console.log(document.getElementById("result"))
    }

}
function getCustomerOptionValue(customerid){
    $.ajax({
        type: "GET",
        url: "../customer/getCustomerInfo.php",
        data: { id : customerid },
        dataType: 'json',
        success: function(data) {
            var customerData = data[0];
            console.log('customerid', customerid)
            $("#customerid").val(customerData.id);
        },
        error: function(error) {
            console.error("Error:", error);
        }
    });
}

function getcompanyOptionValue(companyid){
    $.ajax({
        type: "GET",
        url: "../shipping/getCompanyInfo.php",
        data: { shipping_company_id : companyid },
        dataType: 'json',
        success: function(data) {
            var companyData = data[0];
            console.log('companyData', companyData)
            $("#companyid").val(companyData.shipping_company_id);
            $("#shipping_cost").val(companyData.shipping_cost);
            $("#hidden_shipping_cost").val(companyData.shipping_cost);
        },
        error: function(error) {
            console.error("Error:", error);
        }
    });
}
