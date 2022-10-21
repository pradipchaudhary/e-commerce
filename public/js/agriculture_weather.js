window.onload = function() {
    var mainInput = document.getElementById("nepali_datepicker");
    var mainInput1 = document.getElementById("nepali_datepicker1");
    const date_desc = document.getElementById("date_desc");
    mainInput.nepaliDatePicker({
        disableDaysBefore: 0,
        ndpYear: 200,
        ndpMonth: true,
        ndpYearCount: 10,
        onChange: function() {
            var dateString = mainInput.value;
            var dateObject = NepaliFunctions.ConvertToDateObject(dateString, "YYYY-MM-DD")
            var monthUnicode = NepaliFunctions.GetBsMonthInUnicode(parseInt(dateObject.month - 1));
            date_desc.setAttribute("value",monthUnicode + " " + dateObject.day);
        }
    });
    mainInput1.nepaliDatePicker({
        disableDaysBefore: 0,
        ndpYear: 200,
        ndpMonth: true,
        ndpYearCount: 200,
        onChange: function() {
            var dateString = mainInput1.value;
            var dateObject = NepaliFunctions.ConvertToDateObject(dateString, "YYYY-MM-DD")
            var monthUnicode = NepaliFunctions.GetBsMonthInUnicode(parseInt(dateObject.month - 1));
            var previous = document.getElementById("date_desc").value;
            date_desc.setAttribute("value"," " + previous + " देखि " +monthUnicode + " " + dateObject.day);
            console.log(date_desc.value);
        }
    });
};