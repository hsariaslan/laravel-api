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
            url: "/proxy/transactions/report",
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
            }
        });
    });

    $('#clientForm').on('submit', function(e) {
        e.preventDefault();

        const formData = {
            transaction_id: $("#transaction-id").val(),
        };

        $.ajax({
            headers: {
                "Authorization": sessionStorage.getItem('jwt_token'),
                "Accept": "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/proxy/client",
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(data) {
                console.log(data);

                $("#client-id").html(data.id);
                $("#client-created_at").html(data.created_at);
                $("#client-updated_at").html(data.updated_at);
                $("#client-deleted_at").html(data.deleted_at);
                $("#client-number").html(data.number);
                $("#client-expiryMonth").html(data.expiryMonth);
                $("#client-expiryYear").html(data.expiryYear);
                $("#client-startMonth").html(data.startMonth);
                $("#client-startYear").html(data.startYear);
                $("#client-issueNumber").html(data.issueNumber);
                $("#client-email").html(data.email);
                $("#client-birthday").html(data.birthday);
                $("#client-gender").html(data.gender);
                $("#client-billingTitle").html(data.billingTitle);
                $("#client-billingFirstName").html(data.billingFirstName);
                $("#client-billingLastName").html(data.billingLastName);
                $("#client-billingCompany").html(data.billingCompany);
                $("#client-billingAddress1").html(data.billingAddress1);
                $("#client-billingAddress2").html(data.billingAddress2);
                $("#client-billingCity").html(data.billingCity);
                $("#client-billingPostCode").html(data.billingPostCode);
                $("#client-billingState").html(data.billingState);
                $("#client-billingCountry").html(data.billingCountry);
                $("#client-billingPhone").html(data.billingPhone);
                $("#client-billingFax").html(data.billingFax);
                $("#client-shippingTitle").html(data.shippingTitle);
                $("#client-shippingFirstName").html(data.shippingFirstName);
                $("#client-shippingLastName").html(data.shippingLastName);
                $("#client-shippingCompany").html(data.shippingCompany);
                $("#client-shippingAddress1").html(data.shippingAddress1);
                $("#client-shippingAddress2").html(data.shippingAddress2);
                $("#client-shippingCity").html(data.shippingCity);
                $("#client-shippingPostCode").html(data.shippingPostCode);
                $("#client-shippingState").html(data.shippingState);
                $("#client-shippingCountry").html(data.shippingCountry);
                $("#client-shippingPhone").html(data.shippingPhone);
                $("#client-shippingFax").html(data.shippingFax);
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    });
});
