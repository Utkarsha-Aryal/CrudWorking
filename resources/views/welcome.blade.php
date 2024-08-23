<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operations</title>

    <!-- Latest Bootstrap and DataTables CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
    <link rel="stylesheet" href="{{asset('scss/main.css')}}">
    <!-- Nepali Datepicker CSS -->
    <link href="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/css/nepali.datepicker.v4.0.4.min.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />


    {{-- Fontawsome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- jQuery and required JS libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.4.min.js"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/43.0.0/classic/ckeditor.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
      
        
        .container{
            margin-top: 3rem;
        }
        .edit-btn{
            border-radius: 5px;
            padding: 0.4rem 0.6rem;
            background: blue;
            color: white;
            border: none;
            outline: none;
        }
        .delete-btn{
            border-radius: 5px;
            padding: 0.4rem 0.6rem;
            background: red;
            color: white;
            border: none;
            outline: none;
        }
        .edit-btn i, .delete-btn i{
            margin-right: 0.5rem;
        }
        img{
            width: 150px;
            height: 110px;
        }
        tr td img{
            width: 70px;
            height: 70px;
        }
        .modal-body{
            display: grid;
            grid-template-columns: 47% 47%;
            gap: 1rem;
            padding: 1rem 1.2rem;
        }
        label{
            font-weight: 600;
        }
        input{
            outline: none;
            border: 1px solid black;
        }
        #createModel{
            border-radius: 10px;
        }
        .ck-rounded-corners{
            height: 200px;
        }
        .ck.ck-reset{
            width: 206%;
        }
        .photo-container {
    position: relative;
    display: inline-block;
}

#defaultImage {
    display: block;
}

#uploadIcon {
    position: absolute;
    top: 8px; 
    right: 10px;
    font-size: 24px; 
    border-radius: 50%;
    padding: 5px; 
    z-index: 10; 
}

.photo-container img {
    display: block; 
}
.datepick{
    position: relative !important;
    z-index: 999;
}
#ndp-nepali-box {
    top: 60px !important;
    left: 10px !important;
}

/* #ndp-nepali-box {
    position: absolute !important;
    z-index: 999;
    top: 0 !important;
    right: -23rem !important;

} */

    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <h2>CRUD Operations</h2>
            <button class="btn btn-primary" id="add_add" data-toggle="modal" data-target="#createModal">Add New</button>
        </div>

        <table id="ishanTable" class="display table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>


        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                  
                </div>
            </div>
        </div>
    </div>

    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.0.0/"
            }
        }
      </script>
    
      <script type="module">
        import {
            ClassicEditor,
            Essentials,
            Bold,
            Italic,
            Font,
            Paragraph
        } from 'ckeditor5';
    
        ClassicEditor
            .create(document.querySelector('#descriptionEditor'), {
                plugins: [Essentials, Bold, Italic, Font, Paragraph],
                toolbar: {
                    items: [
                        'undo', 'redo', '|', 'bold', 'italic', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                    ]
                }
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error('There was a problem initializing the editor:', error);
            });
      </script>
    <script>
        $(document).ready(function() {

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var table = $('#ishanTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('student.data') }}",
                columns: [
                    { data: 'id'
                     },
                    { data: 'name',orderable:false },
                    { data: 'email',orderable:false },
                    { data: 'description',orderable:false },
                    { data: 'image',orderable:false },
                    { data: 'date',orderable:false },
                    { data: 'action' ,orderable:false}
                ]
            });

            // $('#createForm').ajaxForm({; 
            //     success: function(response) {
            //         $('#createForm')[0].reset();
            //         $('#id').val('');
            //         $('#createModal').modal('hide');
            //     },
            //     error: function(xhr) {
            //         console.log('An error occurred:', xhr.responseText);
                
            //     }
            // });

            $('.btn-primary').on('click', function(e) {
            e.preventDefault();
            var url = '{{ route('student.form') }}';
                $.get(url, function(response) {
                    $('#createModal .modal-content').html(response);
                    $('#createModal').modal('show');
                });
            });

        $(document).on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            var url = '{{ route("student.form") }}';
            var data = {
                id: id
            };

            $.ajax({
                url: url,
                type: 'get',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    $('#createModal .modal-content').html(response);
                    $('#createModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('An error occurred:', status, error);
                }
            });
        });


            $('#ishanTable').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this record?')) {
                    $.ajax({
                        url: "{{ route('student.delete') }}",
                        type: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        data: { id: id },
                        success: function(response) {
                            if (response.type === 'success') {
                                alert(response.message);
                                table.ajax.reload(); 
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred while processing your request.');
                            console.log(xhr.responseText);
                        }
                    });
                }
            });

//             // The code that was missing or not handling reset properly
// $('#add_add').on('click', function () {
//     $('#createForm')[0].reset();
//     $('#id').val('');
//     $('#defaultImage').attr('src', '{{asset("images/default.jpeg")}}');
//     window.editor.setData('');
});




   </script>



  
  
</body>
</html>