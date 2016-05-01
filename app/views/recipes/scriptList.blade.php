<script>
    function updateSelectedIngredients(id){
        var value = $("#"+id);
        if(value == 'on'){
            $('#tags option[value=id]').prop('selected', true)
        }
    }
</script>