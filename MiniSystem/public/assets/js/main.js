
// START CODE FOR BASIC DATA TABLE 
$(document).ready(function() {
    $('#example1').DataTable();
} );
// END CODE FOR BASIC DATA TABLE 


// START CODE FOR Child rows (show extra / detailed information) DATA TABLE 
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extension number:</td>'+
            '<td>'+d.extn+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extra info:</td>'+
            '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
    '</table>';
}

$(document).ready(function() {
    var table = $('#example2').DataTable( {
        "ajax": "assets/data/dataTablesObjects.txt",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "name" },
            { "data": "position" },
            { "data": "office" },
            { "data": "salary" }
        ],
        "order": [[1, 'asc']]
    } );
        
    // Add event listener for opening and closing details
    $('#example2 tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
    
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
} );
// END CODE FOR Child rows (show extra / detailed information) DATA TABLE 		

        

// START CODE Show / hide columns dynamically DATA TABLE 		
$(document).ready(function() {
    var table = $('#example3').DataTable( {
        "scrollY": "350px",
        "paging": false
    } );
    
    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
    
        // Get the column API object
        var column = table.column( $(this).attr('data-column') );
    
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );
} );
// END CODE Show / hide columns dynamically DATA TABLE 	


// START CODE Individual column searching (text inputs) DATA TABLE 		
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example4 thead th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
    
    // DataTable
    var table = $('#example4').DataTable();
    
    // Apply the search
    table.columns().every( function () {
        var that = this;
    
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );
