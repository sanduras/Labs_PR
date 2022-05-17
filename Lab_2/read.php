<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    </head>

    <body>
        <?php

        $data = require_once 'config.php';

        $host = '{imap.gmail.com:993/imap/ssl}';
        $con = imap_open($host, $data['mail']['username'], $data['mail']['password']) or die('Error to connect to Gmail: ' . imap_last_error());;

        $messages = imap_search($con, 'FROM "z61149036@gmail.com"');
        /* loop through each email id mails are available. */
        if ($messages) {
            /* Mail output variable starts*/
            $mailOutput = '';
            $mailOutput .=
                '<table class= "table table-dark">
            <tr>
                <th>Subject </th>
                <th> From </th>
                <th> Date Time </th>
                <th> Content </th>
            </tr>
        ';
            rsort($messages);
            foreach ($messages as $email_number) {
                $headers = imap_fetch_overview($con, $email_number, 0);
                $message = imap_fetchbody($con, $email_number, '1');
                $subMessage = substr($message, 0, 150);
                $finalMessage = trim(quoted_printable_decode($subMessage)); //clear white space and decode message

                $mailOutput .= '<div class="row">';
                /* Gmail MAILS header information */
               if(isset($headers[0]->subject) ) {
                $mailOutput .= '<td><span class="col">' .
                $headers[0]->subject . '</span></td> ';
               }
                $mailOutput .= '<td><span class="columnClass">' .
                    $headers[0]->from . '</span></td>';
                $mailOutput .= '<td><span class="columnClass">' .
                    $headers[0]->date . '</span></td>';
                $mailOutput .= '</div>';

                /* Mail body is returned */
                $mailOutput .= '
                    <td>
                        <span class="column">' . $finalMessage . '</span>
                    </td>
                </tr>
        </div>';
            } // End foreach
            $mailOutput .= '</table>';
            echo $mailOutput;
        } //endif
        // echo '<pre>';
        // print_r($headers);
        // echo '</pre>';
        imap_close($con);
        ?>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>

</html>