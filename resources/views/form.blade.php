<div class="modal-header">
    <h5 class="modal-title" id="createModalLabel">{{ !empty($prevPost->id) ? 'Update Existing Member Details' : 'Add New Member' }}
        
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="createForm" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" id="id" value="{{ @$prevPost->id }}">
        <div class="form-group">
            <label for="createName">Name</label>
            <input type="text" class="form-control" id="createName" name="name" value="{{ @$prevPost->name }}">
        </div>
        <div class="form-group">
            <label for="createEmail">Email</label>
            <input type="email" class="form-control" id="createEmail" name="email" value="{{ @$prevPost->email }}">
        </div>
        <div class="form-group photo">
            <div class="photo-container">
                <?php
                $photo = asset("default.jpg");
                if (!empty(@$prevPost->image)) {
                    $photo = asset("storage/images/" . $prevPost->image);
                }
                ?>
                <img id="defaultImage" src="{{asset($photo)}}" alt="Default Image">
                <a class="fa-solid fa-camera profile-edit text-primary" id="uploadIcon" href="javascript:void(0);"></a>
            </div>
            <input type="file" name="image" id="image" style="display:none;" accept="image/*">
        </div>
        
        <div class="form-group datepick">
            <label for="createDate">Date</label>
            <input class="form-control" type="date" id="nepali-datepicker" value="{{ @$prevPost->date }}" placeholder="Select Event Date" name="date">
        </div>
        {{-- <div id="editor">
            <p>Hello from CKEditor 5!</p>
        </div> --}}
       <div>
        <div>
            <div class="name">
                <label for="description" name="description">Description</label>
                <div id="descriptionEditor" name="description">{!! @$prevPost->description !!}</div> 
                
                <input type="hidden" name="details" id="des">
            </div>
        </div>
       </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

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
    $(document).ready(function(){
        
        
        var mainInput = document.getElementById("nepali-datepicker");
            mainInput.nepaliDatePicker();
            $("#nepali-datepicker").nepaliDatePicker({
                container: ".datepick",
            });

        $('#image').change(function () {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#defaultImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            });
            
            $('#uploadIcon').on('click', function() {
                    $('#image').trigger('click');
                });

                

                $('#createForm').on('submit', function(e) {
                    e.preventDefault();

                    var table = $('#ishanTable').DataTable();
                    var formData = new FormData(this);
                    formData.append('description', editor.getData());

                    $.ajax({
                        url: "{{ route('student.save') }}",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function() {
                            table.ajax.reload();
                            $('#createForm').trigger('reset');
                            $('#id').val('');
                            $('#createModal').modal('hide');
                        },
                        error: function(xhr) {
                            alert('An error occurred: ' + xhr.responseText);
                            console.error(xhr.responseText);
                        }
                    });
                });



    })
</script>