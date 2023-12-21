    let modalContent = document.getElementById('modalContent')
    const GridDiv = document.getElementById("myGrid")
    var gridOptions = {
        columnDefs:[
            {headerName: '',
                field: 'removeIcon',
                cellRenderer: params =>  {
                    return '<a href="#" ><i class="fas fa-trash remove-icon"></i></a>';
                },
                width:10,
                onCellClicked: params => {
                    if (params.event.target.classList.contains('remove-icon')) {
                        removeRowAndDatabaseRecord(params.data);
                    }
                }
            },
            {headerName: 'Edit Customer', field: 'edit',
                cellRenderer: params => {
                    return `<a href="#"><i class="fas fa-solid fa-user-pen"></i></a>`;
                },
                width:10,
                onCellClicked: params => {
                    if (params.event.target.classList.contains('fa-user-pen')) {
                        showCustomerData(params.data);
                    }
                }
            },
            {headerName: 'ID', field: 'id',editable: false},
            {headerName: 'Name', field: 'name',editable: true},
            {headerName: 'Phone1', field: 'phone1',editable: true},
            {headerName: 'Phone2', field: 'phone2',editable: true},
            {headerName: 'FaceBook Account', field: 'fb_account',editable: true},
            {headerName: 'Instagram Account', field: 'ins_account',editable: true},
            {headerName: 'Address', field: 'address',editable: true}
        ],
        rowSelection : 'single',
        onCellEditingStopped : cellEditingStopped,

    };

    $(document).ready(function (){
        new agGrid.Grid(GridDiv, gridOptions);
        $.ajax({
            url: '/ecommerce/customer/getCustomers.php',
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

    function showCustomerData(customerData){
        modalContent.innerHTML = '';
        var content = `<form action="../ecommerce/customer/updatecustomer.php" method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="hidden" class="form-control " name="id" value = ${customerData.id}>
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" class="form-control " name="name" value = ${customerData.name}>
                                    <label for="phone1" class="form-label">Phone1:</label>
                                    <input type="text" class="form-control " name="phone1" value = ${customerData.phone1}>
                                    <label for="phone2" class="form-label">Phone2:</label>
                                    <input type="text" class="form-control " name="phone2" value = ${customerData.phone2} >
                
                                </div>
                                <div class="col-lg-6">
                                    <label for="fb_account" class="form-label">FaceBook Account:</label>
                                    <input type="text" class="form-control " name="fb_account" value = ${customerData.fb_account}>
                                    <label for="ins_account" class="form-label">Instagram Account:</label>
                                    <input type="text" class="form-control " name="ins_account" value = ${customerData.ins_account}>
                                    <label for="address" class="form-label">Address:</label>
                                    <input type="text" class="form-control " name="address"  value = ${customerData.ins_account}>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" name="submit" value="Submit" class="btn btn-primary my-3">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>`;
        modalContent.innerHTML += content;
        $('#customerModal').modal('show');
    }

    function  cellEditingStopped(params){
        $.ajax({
            type: "POST",
            url: "/ecommerce/customer/updatecustomer.php",
            data: {
                id : params.data.id,
                name: params.data.name,
                phone1: params.data.phone1,
                phone2: params.data.phone2,
                fb_account : params.data.fb_account,
                ins_account : params.data.ins_account,
                address : params.data.address
            },
            success: function(data) {
                console.log("customer updated!")
            },
            error: function(error) {
                console.error("Error:", error);
            }
        });
    }

    function removeRowAndDatabaseRecord(customerData){
        gridOptions.api.applyTransaction({ remove: [customerData] });
        deleteRecordInDatabase(customerData.id);
    }

    function deleteRecordInDatabase(customerId){
        console.log('customerId',customerId)
        $.ajax({
            type: 'GET',
            url: '/ecommerce/customer/removeCustomer.php',
            data: { id: customerId },
            success: function (response) {
                // Handle the response from the server (e.g., show a success message)
                console.log("customer deleted successfuly!");
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }

    function addNewCustomer(){
        $('#newCustomerModal').modal('show');
    }