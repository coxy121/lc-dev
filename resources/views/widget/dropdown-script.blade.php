<script>
    $('#category_id').on('change', function(e){
        var category_id = e.target.value;
        //ajax
        $.get('/api/category-dropdown?category_id=' + category_id, function(data){
            //success data
            $('#subcategory_id').empty();
            $('#subcategory_id').append('<option value=""> Please choose one</option>');
            $.each(data, function(index, subcatObj){
                $('#subcategory_id').append('<option value="' + subcatObj.id+'">'
                        + subcatObj.subcategory_name + '</option>');
            });
        });
    });
</script>