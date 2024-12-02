$(() => {
    $('.datepicker').datepicker();
    $('#transactionReportForm').on('submit', function(e) {
        e.preventDefault();

        $("#loadingTbody").css("display", "table-row");
        $("#emptyTr").css("display", "none");

        let [month, day, year] = $("#from-date").val().split('/');
        const fromDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
        [month, day, year] = $("#to-date").val().split('/');
        const toDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;

        const formData = {
            from_date: fromDate,
            to_date: toDate,
            merchant: $("#merchant").val(),
            acquirer: $("#acquirer").val(),
        };

        $.ajax({
            headers: {
                "Authorization": sessionStorage.getItem('jwt_token'),
                "Accept": "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/proxy/transactions/report", // Local Laravel proxy endpoint
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(data) {
                // console.log(data);
                $("#loadingTbody").css("display", "none");
                $("#transactionReportBody").css("display", "none");
                $("#transactionReportAjaxBody").css("display", "block");

                data.forEach(function(item, index) {
                    $("#transactionReportAjaxBody").html(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.count}</td>
                        <td>${item.total}</td>
                        <td>${item.currency}</td>
                    </tr>`);
                });
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            },
            finally: function() {

            }
        });
    });
});
