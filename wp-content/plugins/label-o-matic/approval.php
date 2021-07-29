<?php

include 'db-connect.php';

$user_id;
$previous_page = $_GET['prev'];
$order_number = $_GET['order_number'];
$tracking = 'lead-approved';

$get_requester = "SELECT user_id FROM orders WHERE order_number='" . $order_number . "'";
$requester_result = $conn->query($get_requester);

while ($row = $requester_result->fetch_assoc()) {
    $user_id = $row['user_id'];
}

$user_who_requested = get_user_by('id', $user_id);

$to = 'itdmarketing@intheditch.com';

// Taken from tracking.php

$update_order = "UPDATE orders SET tracking= '$tracking' WHERE order_number='" . $order_number . "'";

if ($conn->query($update_order) === TRUE) {
    echo "Existing record updated successfully<br>";
} else {
    echo "Error: " . $update_order . "<br>" . $conn->error;
}

// terminates connection
$conn->close();

$subject = "Marketing Dept. You have received a new label request.";

$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <!--[if gte mso 9]>
	<xml>
		<o:OfficeDocumentSettings>
		<o:AllowPNG/>
		<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="format-detection" content="date=no" />
    <meta name="format-detection" content="address=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="x-apple-disable-message-reformatting" />
    <!--[if !mso]><!-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!--<![endif]-->
    <title>Email Template</title>
    <!--[if gte mso 9]>
	<style type="text/css" media="all">
		sup { font-size: 100% !important; }
	</style>
	<![endif]-->


    <style type="text/css" media="screen">
        /* Linked Styles */
        body {
            font-family: \'Roboto\', sans-serif;
            padding: 0 !important;
            margin: 0 !important;
            display: block !important;
            min-width: 100% !important;
            width: 100% !important;
            background: #ffffff;
            -webkit-text-size-adjust: none
        }

        a {
            color: #0000ee;
            text-decoration: none
        }

        p {
            padding: 0 !important;
            margin: 0 !important
        }

        img {
            -ms-interpolation-mode: bicubic;
            /* Allow smoother rendering of resized image in Internet Explorer */
        }

        .mcnPreviewText {
            display: none !important;
        }


        /* Mobile styles */
        @media only screen and (max-device-width: 480px),
        only screen and (max-width: 480px) {
            .mobile-shell {
                width: 100% !important;
                min-width: 100% !important;
            }

            .bg {
                background-size: 100% auto !important;
                -webkit-background-size: 100% auto !important;
            }

            .text-header,
            .m-center {
                text-align: center !important;
            }

            .center {
                margin: 0 auto !important;
            }

            .container {
                padding: 20px 10px !important
            }

            .td {
                width: 100% !important;
                min-width: 100% !important;
            }

            .m-br-15 {
                height: 15px !important;
            }

            .p30-15 {
                padding: 30px 15px !important;
            }

            .p0-15-30 {
                padding: 0px 15px 30px 15px !important;
            }

            .p0-15 {
                padding: 0px 15px !important;
            }

            .mpb30 {
                padding-bottom: 30px !important;
            }

            .mpb15 {
                padding-bottom: 15px !important;
            }

            .m-td,
            .m-hide {
                display: none !important;
                width: 0 !important;
                height: 0 !important;
                font-size: 0 !important;
                line-height: 0 !important;
                min-height: 0 !important;
            }

            .m-block {
                display: block !important;
            }

            .fluid-img img {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
            }

            .column,
            .column-dir,
            .column-top,
            .column-empty,
            .column-empty2,
            .column-dir-top {
                float: left !important;
                width: 100% !important;
                display: block !important;
            }

            .column-empty {
                padding-bottom: 30px !important;
            }

            .column-empty2 {
                padding-bottom: 10px !important;
            }

            .content-spacing {
                width: 15px !important;
            }
        }
    </style>
</head>

<body class="body" style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#ffffff; -webkit-text-size-adjust:none;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
        <tr>
            <td align="center" valign="top">
                <!-- Header -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center">
                            <table width="650" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">
                                <tr>
                                    <td class="td" style="width:650px; min-width:650px; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">

                                        <!-- Header -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td class="p30-15 tbrr" style="padding: 30px 0px 40px 0px; border-radius:12px 12px 0px 0px;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <th class="column-top" width="145" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td class="h3 center pb15" style="color:#000000; font-family:Arial, sans-serif; font-size:22px; line-height:32px; text-align:center; padding-bottom:15px;">
                                                                            <h1>Internalweb/Label-O-Tron</h1>
                                                                       </td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- END Header -->
                                        


                                        <!-- CTA / Secondary -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td class="p0-15-30" style="padding: 20px 40px 50px 40px;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td class="h3 center pb15" style="color:#000000; font-family:Arial, sans-serif; font-size:22px; line-height:32px; text-align:center; padding-bottom:15px;"> ' . $user_who_requested->display_name . '\'s label request has been approved, and is ready to add to an order!</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text center pb15" style="color:#666666; font-family:Arial, sans-serif; font-size:15px; line-height:28px; text-align:center; padding-bottom:15px;">---------------------------------------------------------------------------------</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-link center" style="color:#0000ee; font-family:Arial, sans-serif; font-size:16px; line-height:28px; text-align:center;">
                                                                <a href="http://internalweb/label-o-matic" target="_blank" class="link-u" style="color:#0000ee; text-decoration:underline;"><span class="link-u" style="color:#0000ee; text-decoration:underline;">Click here to view all orders!</span></a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 40px;"></td>
                                            </tr>
                                        </table>
                                        <!-- END CTA / Secondary -->



                                        <!-- Footer -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td class="p0-15-30" style="padding-bottom: 40px;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td class="text-footer1 pb10" style="color:#777777; font-family:Arial, sans-serif; font-size:14px; line-height:20px; text-align:center; padding-bottom:10px;">This email brought to you by the power of automation and interweb magic.</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- END Footer -->
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <!-- END Header -->
            </td>
        </tr>
    </table>
</body>

</html>';

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <noreply@inventive-group.com>' . "\r\n";

// Mail labels
if (mail($to, $subject, $message, $headers)) : ?>
    <h3>Labels Approved.</h3>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.location.href = "/label-o-matic/?sub=user_update&order_number=<?php echo $order_number; ?>&prev=<?php echo $previous_page; ?>";
        }, false);
    </script>
<?php else : ?>
    <h3>There was a problem. Please contact marketing to see what went wrong!</h3>
<?php endif; ?>