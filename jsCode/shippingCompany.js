
const GridDiv = document.getElementById("shippingCompaniesGrid");
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
        {headerName: 'ID', field: 'shipping_company_id'},
        {headerName: 'Company Name', field: 'company_name'},
        {headerName: 'Shipping Cost', field: 'shipping_cost'}
    ],
    rowSelection : 'single',
};

$(document).ready(function (){
    new agGrid.Grid(GridDiv, gridOptions);
    $.ajax({
        url: '/ecommerce/shipping/getShippingCompanies.php',
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

function removeRowAndDatabaseRecord(companyData){
    gridOptions.api.applyTransaction({remove: [companyData]});
    deleteRecordInDatabase(companyData.shipping_company_id);
}
function deleteRecordInDatabase(companyId){
    $.ajax({
        type: 'GET',
        url: '/ecommerce/shipping/removeCompany.php',
        data: { shipping_company_id : companyId },
        success: function (response) {
            console.log('companyId',companyId)
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

function addNewCompany(){
    $('#newComapnyModal').modal('show');

}