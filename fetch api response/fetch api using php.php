<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch api using PHP</title>
</head>

<body>

    <h1 style="text-align:center;">Fetch API Response using PHP</h1>
    <div style="text-align:center;" id="data"></div>

    <table style="text-align:center;">
        <tbody>
            <?php

            $api_url = 'https://gorest.co.in/public/v1/users';
            $json_data = file_get_contents($api_url);
            $data = json_decode($json_data, true);

            for ($x = 0; $x < count($data['data']); $x++) {
                echo " <tr>
                        <td>" . $data['data'][$x]['id'] . "</td>     
                        <td>" . $data['data'][$x]['name'] . "</td> 
                        <td>" . $data['data'][$x]['email'] . "</td> 
                        <td>" . $data['data'][$x]['gender'] . "</td> 
                        <td>" . $data['data'][$x]['status'] . "</td>  
                    </tr>";
            }
            ?>
        </tbody>
    </table>

</body>

</html>