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
            url: "/financial-house/proxy/transactions/report",
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(data) {
                console.log(data);
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
            url: "/financial-house/proxy/client",
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(data) {
                console.log(data);

                $("#client-id").html(data?.id);
                $("#client-created_at").html(data?.created_at);
                $("#client-updated_at").html(data?.updated_at);
                $("#client-deleted_at").html(data?.deleted_at);
                $("#client-number").html(data?.number);
                $("#client-expiryMonth").html(data?.expiryMonth);
                $("#client-expiryYear").html(data?.expiryYear);
                $("#client-startMonth").html(data?.startMonth);
                $("#client-startYear").html(data?.startYear);
                $("#client-issueNumber").html(data?.issueNumber);
                $("#client-email").html(data?.email);
                $("#client-birthday").html(data?.birthday);
                $("#client-gender").html(data?.gender);
                $("#client-billingTitle").html(data?.billingTitle);
                $("#client-billingFirstName").html(data?.billingFirstName);
                $("#client-billingLastName").html(data?.billingLastName);
                $("#client-billingCompany").html(data?.billingCompany);
                $("#client-billingAddress1").html(data?.billingAddress1);
                $("#client-billingAddress2").html(data?.billingAddress2);
                $("#client-billingCity").html(data?.billingCity);
                $("#client-billingPostCode").html(data?.billingPostCode);
                $("#client-billingState").html(data?.billingState);
                $("#client-billingCountry").html(data?.billingCountry);
                $("#client-billingPhone").html(data?.billingPhone);
                $("#client-billingFax").html(data?.billingFax);
                $("#client-shippingTitle").html(data?.shippingTitle);
                $("#client-shippingFirstName").html(data?.shippingFirstName);
                $("#client-shippingLastName").html(data?.shippingLastName);
                $("#client-shippingCompany").html(data?.shippingCompany);
                $("#client-shippingAddress1").html(data?.shippingAddress1);
                $("#client-shippingAddress2").html(data?.shippingAddress2);
                $("#client-shippingCity").html(data?.shippingCity);
                $("#client-shippingPostCode").html(data?.shippingPostCode);
                $("#client-shippingState").html(data?.shippingState);
                $("#client-shippingCountry").html(data?.shippingCountry);
                $("#client-shippingPhone").html(data?.shippingPhone);
                $("#client-shippingFax").html(data?.shippingFax);
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

    $('#getTransactionForm').on('submit', function(e) {
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
            url: "/financial-house/proxy/get-transaction",
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(data) {
                console.log(data);

                $("#merchant-name").html(data?.merchant?.name);

                $("#fx-merchant-originalAmount").html(data?.fx?.merchant?.originalAmount);
                $("#fx-merchant-originalCurrency").html(data?.fx?.merchant?.originalCurrency);

                $("#client-id").html(data?.customerInfo?.id);
                $("#client-created_at").html(data?.customerInfo?.created_at);
                $("#client-updated_at").html(data?.customerInfo?.updated_at);
                $("#client-deleted_at").html(data?.customerInfo?.deleted_at);
                $("#client-number").html(data?.customerInfo?.number);
                $("#client-expiryMonth").html(data?.customerInfo?.expiryMonth);
                $("#client-expiryYear").html(data?.customerInfo?.expiryYear);
                $("#client-startMonth").html(data?.customerInfo?.startMonth);
                $("#client-startYear").html(data?.customerInfo?.startYear);
                $("#client-issueNumber").html(data?.customerInfo?.issueNumber);
                $("#client-email").html(data?.customerInfo?.email);
                $("#client-birthday").html(data?.customerInfo?.birthday);
                $("#client-gender").html(data?.customerInfo?.gender);
                $("#client-billingTitle").html(data?.customerInfo?.billingTitle);
                $("#client-billingFirstName").html(data?.customerInfo?.billingFirstName);
                $("#client-billingLastName").html(data?.customerInfo?.billingLastName);
                $("#client-billingCompany").html(data?.customerInfo?.billingCompany);
                $("#client-billingAddress1").html(data?.customerInfo?.billingAddress1);
                $("#client-billingAddress2").html(data?.customerInfo?.billingAddress2);
                $("#client-billingCity").html(data?.customerInfo?.billingCity);
                $("#client-billingPostCode").html(data?.customerInfo?.billingPostCode);
                $("#client-billingState").html(data?.customerInfo?.billingState);
                $("#client-billingCountry").html(data?.customerInfo?.billingCountry);
                $("#client-billingPhone").html(data?.customerInfo?.billingPhone);
                $("#client-billingFax").html(data?.customerInfo?.billingFax);
                $("#client-shippingTitle").html(data?.customerInfo?.shippingTitle);
                $("#client-shippingFirstName").html(data?.customerInfo?.shippingFirstName);
                $("#client-shippingLastName").html(data?.customerInfo?.shippingLastName);
                $("#client-shippingCompany").html(data?.customerInfo?.shippingCompany);
                $("#client-shippingAddress1").html(data?.customerInfo?.shippingAddress1);
                $("#client-shippingAddress2").html(data?.customerInfo?.shippingAddress2);
                $("#client-shippingCity").html(data?.customerInfo?.shippingCity);
                $("#client-shippingPostCode").html(data?.customerInfo?.shippingPostCode);
                $("#client-shippingState").html(data?.customerInfo?.shippingState);
                $("#client-shippingCountry").html(data?.customerInfo?.shippingCountry);
                $("#client-shippingPhone").html(data?.customerInfo?.shippingPhone);
                $("#client-shippingFax").html(data?.customerInfo?.shippingFax);

                $("#transaction-merchant-referenceNo").html(data?.transaction?.merchant?.referenceNo);
                $("#transaction-merchant-merchantId").html(data?.transaction?.merchant?.merchantId);
                $("#transaction-merchant-status").html(data?.transaction?.merchant?.status);
                $("#transaction-merchant-channel").html(data?.transaction?.merchant?.channel);
                $("#transaction-merchant-customData").html(data?.transaction?.merchant?.customData);
                $("#transaction-merchant-chainId").html(data?.transaction?.merchant?.chainId);
                $("#transaction-merchant-agentInfoId").html(data?.transaction?.merchant?.agentInfoId);
                $("#transaction-merchant-operation").html(data?.transaction?.merchant?.operation);
                $("#transaction-merchant-fxTransactionId").html(data?.transaction?.merchant?.fxTransactionId);
                $("#transaction-merchant-updated_at").html(data?.transaction?.merchant?.updated_at);
                $("#transaction-merchant-created_at").html(data?.transaction?.merchant?.created_at);
                $("#transaction-merchant-acquirerTransactionId").html(data?.transaction?.merchant?.acquirerTransactionId);
                $("#transaction-merchant-code").html(data?.transaction?.merchant?.code);
                $("#transaction-merchant-message").html(data?.transaction?.merchant?.message);
                $("#transaction-merchant-transactionId").html(data?.transaction?.merchant?.transactionId);
                $("#transaction-merchant-agent").html(data?.transaction?.merchant?.agent);
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

    $("#transactionQueryForm").on("submit", function(e) {
        e.preventDefault();

        $("#loadingTbody").css("display", "table-row");
        $("#transactionQueryBody").css("display", "none");

        let formData = {};

        if ($("#from-date").val()) {
            let [month, day, year] = $("#from-date").val().split('/');
            const fromDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;

            formData.from_date = fromDate;
        }

        if ($("#to-date").val()) {
            let [month, day, year] = $("#to-date").val().split('/');
            const toDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;

            formData.to_date = toDate;
        }

        if ($("#merchant_id").val()) {
            formData.merchant_id = $("#merchant_id").val();
        }

        if ($("#acquirer_id").val()) {
            formData.acquirer_id = $("#acquirer_id").val();
        }

        if ($("#status").val()) {
            formData.status = $("#status").val();
        }

        if ($("#operation").val()) {
            formData.operation = $("#operation").val();
        }

        if ($("#payment_method").val()) {
            formData.payment_method = $("#payment_method").val();
        }

        if ($("#error_code").val()) {
            formData.error_code = $("#error_code").val();
        }

        if ($("#filter_field").val()) {
            formData.filter_field = $("#filter_field").val();
        }

        if ($("#filter_value").val()) {
            formData.filter_value = $("#filter_value").val();
        }

        // console.log(formData)

        $.ajax({
            headers: {
                "Authorization": sessionStorage.getItem('jwt_token'),
                "Accept": "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/financial-house/proxy/transactions/query",
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(data) {
                console.log(data);
                $("#loadingTbody").css("display", "none");
                $("#transactionQueryAjaxBody").css("display", "table-row");

                let htmlData = '';
                data.data?.forEach(function(item, index) {
                    const dataRow = item.data;

                    htmlData += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${dataRow?.fx?.merchant?.originalAmount + ' ' + dataRow?.fx?.merchant?.originalCurrency}</td>
                        <td>${dataRow?.customerInfo?.billingFirstName + ' ' + dataRow?.customerInfo?.billingLastName}</td>
                        <td>${dataRow?.merchant?.name}</td>
                        <td>${(dataRow?.ipn?.received) ? `<p className='text-success'>Received</p>` : `<p className='text-danger'>Not Received</p>`}</td>
                        <td>
                            ${dataRow?.transaction?.forEach(function (transactionItem) {
                                switch (transactionItem) {
                                    case "APPROVED":
                                        `<span class='text-success'>APROVED</span>`
                                        break;
                                    case "WAITING":
                                        `<span class='text-warning'>WAITING</span>`
                                        break;
                                    case "DECLINED":
                                        `<span class='text-danger'>DECLINED</span>`
                                        break;
                                    case "ERROR":
                                        `<span class='text-danger'>ERROR</span>`
                                        break;
                                }
                                " / "
                                transactionItem?.operation
                            })}
                        </td>
                        <td>
                            ${dataRow?.acquirer?.name + " / "}
                            <span class='text-info'>${dataRow?.acquirer?.type}</span>
                        </td>
                        <td>${(dataRow?.refundable) ? `<p class='text-success'>True</p>` : `<p class='text-danger'>False</p>`}</td>
                    </tr>
                    `;
                });

                $("#transactionQueryAjaxBody").html(htmlData);
                $("#pagination").html(data.paginator);
            },
            error: function(xhr) {
                $("#transactionQueryErrors").text(xhr?.responseText?.message);
                $("#loadingTbody").css("display", "none");
                $("#paginationTFoot").css("display", "none");
                $("#transactionQueryAjaxBody").css("display", "block");
            }
        });
    });
});
