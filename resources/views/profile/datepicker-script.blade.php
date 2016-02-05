<script type="text/javascript">
    $(document).ready(function() {
        $('#birthdate').datepicker({
            changeMonth: true,
            changeYear: true,
            maxDate: "-10y",
            minDate: "-100y",
            yearRange: "1915:2010"
        });
    });
</script>